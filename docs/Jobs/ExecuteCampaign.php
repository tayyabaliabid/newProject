<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use App\CampaignMeta;
use App\Campaign;
use App\ApiService\TwilioService;
use App\ApiService\PlivoService;

class ExecuteCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds a job can run 
     */
    public $timeout = 80000;
    
    private $campaignId;
    private $campaign;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaignId)
    {
        $this->campaignId = $campaignId;
        $this->campaign   = Campaign::find($campaignId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->updateCampaignStatus('sending');
        
        try {
            /**
             * Check user Enabled SMS Service providor
             * And Initialize Service of that provider
             */
            if ( $this->campaign->user->setting->isTwilioEnabled() ){
                $service = new TwilioService($this->campaign->user_id);
            }else{
                $service = new PlivoService( $this->campaign->user_id );
            }

            CampaignMeta::where('campaign_id', $this->campaignId)
                        ->where('status','ready')->chunk(500,function($metas) use($service){

                $sent = collect();
                $faild = collect();
                
                /**
                 * Loop throug each Record of this chunk
                 */
                foreach ($metas as $meta) {
                   
                    /**
                     * Send Message
                     */
                    $result = $service->sendMessage(
                        $meta->from_number,
                        $meta->to_number,
                        $meta->message
                    );

                    if ($result->success){
                        $meta->status = 'sent';
                        $meta->save();

                        $this->updateCounts(1, null);
                        
                        // $sent->push($meta->id);
                    }else{
                        $meta->status = 'faild';
                        $meta->error_message = $result->message;
                        $meta->save();

                        $this->updateCounts(null, 1);
                        
                        // $faild->push($meta->id);
                    }

                    /**
                     * Delay Message sending
                     */
                    sleep($this->campaign->delay);
                }

                /**
                 * Bulk Update Message Statuses
                 */

                // Update Sent
                // CampaignMeta::whereIn('id',$sent->toArray())->update([
                //     'status' => 'sent'
                // ]);

                //Update Faild
                // CampaignMeta::whereIn('id',$faild->toArray())->update([
                //     'status' => 'faild'
                // ]);

                // $this->updateCounts(
                //     count($sent), 
                //     count($faild)
                // );

            });
            
            $this->updateCampaignStatus('completed');
            
        } catch (\Exception $ex) {
            \Log::info($ex);
            $this->updateCampaignStatus('faild'.substr($ex,0,15));
            return null;
        }
        
    }

    private function updateCampaignStatus($status)
    {
        $this->campaign->status = $status;
        $this->campaign->save();
    }

    private function updateCounts($sent = null,$faild = null){

        /**
         * Check if sent is set
         */
        if ($sent){
            $this->campaign->total_sent     += $sent;
        }

        /**
         * check if faild is set
         */
        if ($faild){
            $this->campaign->total_failed   += $faild;
        }

        /**
         * Save status
         */
        $this->campaign->save();
        
    }
}
