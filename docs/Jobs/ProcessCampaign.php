<?php

namespace App\Jobs;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Carbon\Carbon;
use App\CampaignMeta;
use App\Campaign;

class ProcessCampaign implements ShouldQueue
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
        try {
            if (!$this->campaign){
                \Log::info('Campaign Deleted');
                return null;
            }
    
            /**
             * Update Campaign Status to Processing
             */
            $this->updateCampaignStatus('processing');
            
            /**
             * Get From numbers for this campaign
             */
            $fromNumbers = collect($this->campaign->from_numbers);
    
            if ( count($fromNumbers) <=0 ){
                $this->updateCampaignStatus('No From Numbers');
                return null;
            }
    
            /**
             * Get To numbers Group for this campaign
             */
            $toNumberGroup = $this->campaign->group;
            
            if ( !$toNumberGroup ){
                $this->updateCampaignStatus('To Numbers Group not Found');
                return null;
            }
    
            
            /**
             * Get To Numbers for this Campaign
             */
            $toNumebrs = $toNumberGroup->contacts;
    
            if ( count($toNumebrs) <=0  ){
                $this->updateCampaignStatus('No To Numbers to Send Campaign');
                return null;
            }
    
    
            $numberOfTextsPerNumber = ceil( count($toNumebrs) / count($fromNumbers) );
    
            /**
             * Prepare campaign Meta
             */
            foreach( $toNumebrs->chunk( $numberOfTextsPerNumber ) as $chunk){
                
                /**
                 * Prepare Bulk Insert Record
                 */
                $inserts = array();
                $fromNumber = $fromNumbers->pop();
                
                foreach($chunk as $contact){
                    
                    /**
                     * Get Message
                     */
                    $message = $this->campaign->message;
                    
                    /**
                     * Replace Variables
                     */
                    $message = str_replace("[[FIRST_NAME]]", $contact->first_name,$message);
                    $message = str_replace("[[LAST_NAME]]", $contact->last_name,$message);
                    $message = str_replace("[[ZIP]]", $contact->zip,$message);
                    $message = str_replace("[[CITY]]", $contact->city,$message);
                    $message = str_replace("[[STATE]]", $contact->state,$message);
                    $message = str_replace("[[EMAIL]]", $contact->email,$message);
                     
                    $inserts[] = [
                        'user_id'       => $this->campaign->user_id,
                        'campaign_id'   => $this->campaignId,
                        'from_number'   => $fromNumber,
                        'to_number'     => $contact->number,
                        'message'       => $message,
                        'status'        => 'ready',
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now(),
                    ];
                }
    
                /**
                 * Insert Records to Database
                 */
                CampaignMeta::insert($inserts);
    
            }
    
            $this->updateCampaignStatus('queued_for_sending');
    
            /**
             * Dispatch Execute Campaign Job to Send Job
             */

             dispatch(new ExecuteCampaign($this->campaignId))->onQueue('executeCampaign');
             
        } catch (\Exception $ex) {
            \Log::info($ex->getMessage());
            $this->updateCampaignStatus("processing_faild");
        }
        
    }

    private function updateCampaignStatus($status)
    {
        $this->campaign->status = $status;
        $this->campaign->save();
    }
}
