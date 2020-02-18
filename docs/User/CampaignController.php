<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Template;

use App\Setting;
use App\Keyword;
use App\Jobs\ProcessCampaign;
use App\Http\Controllers\Controller;
use App\Group;
use App\CampaignMeta;
use App\Campaign;
use App\ApiService\TwilioService;
use App\ApiService\PlivoService;

class CampaignController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$counter   = 0;
		$campaigns = Campaign::where( 'user_id', auth()->id() )
		                     ->orderBy( 'created_at', 'Desc' )
		                     ->get();

		return view( 'user.campaigns.index', compact( 'campaigns', 'counter' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$counter           = 0;
		$keywords          = Keyword::where( 'user_id', auth()->id() )->latest()->get();
		$message_templates = Template::where( 'user_id', auth()->id() )->get();

		return view( 'user.campaigns.create', compact( 'keywords', 'message_templates', 'counter' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request )
	{ 
		$is_schedule=false;
		
		$rules = [
			'title'   			=> 'required|max:255|unique:campaigns',
			'message' 			=> 'required|max:140',
			'to_number'			=> 'required',
			'from_number' 		=> 'required|array',
			// 'delay' 			=> 'required|numeric|min:0|max:60',

		];
		
		if ( isset( $request->schedule_campaign) ) {
			$rules[ 'schedule_campaign' ]      = 'required';
			$rules[ 'campaign_schedule_date' ] = 'required';
			$is_schedule=true;
		}
		
			// Validating inputs
		$this->validate( $request, $rules );
		

		// $contactGroup = Group::find($request->to_number);
		// $totalToNumbers = $contactGroup->contacts->count();
		
        // $totalAvailableLimitOfNumbers = 0;
		// foreach ($request->from_number as $number) {
        //     $totalAvailableLimitOfNumbers += checkAvailableLimit($number);
		// }

		// if (  $totalAvailableLimitOfNumbers < $totalToNumbers ){
		// 	session()->flash('alert-danger','Selected Number does not have required Message sending limit');
		// 	return back()->withInput();
		// }

		// saving into the database
		$campaign = new Campaign();

		$campaign->user_id          = auth()->id();
		$campaign->title            = $request->title;
		$campaign->from_numbers     = $request->from_number;
		$campaign->to_number_group  = $request->to_number;
		$campaign->message          = $request->message; 
		// $campaign->delay         	= $request->delay; 
		$campaign->delay         	= 0; 
		 

		

		/**
		 * Check if Campaign is Not Scheduled 
		 * than Set Status to queued for processing
		 * and Process Campaign Imidiatly
		 */
		if (!$is_schedule)
		{ 
			/**
			 * Set Campaign Stus 
			 */
			$campaign->status           = 'created';
			$campaign->save();

			// Dispatch Job to Process and Send Campaign
            dispatch(new ProcessCampaign($campaign->id))->onQueue('processCampaign');
			
		}
		/**
		 * if Campaign is Scheduled Than update Status as scheduled
		 * and Scheduled Time than Return Back Cron Job will run 
		 * Campaign on Scheduled Time
		 */
		else{
			$campaign->status           = 'scheduled';
			$campaign->scheduled_at		= $request->campaign_schedule_date;
			$campaign->save();
		}

		// success message
		$request->session()->flash( 'alert-success', 'Campaign has been created successfully!' );

		// redirect
		return redirect()->back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id )
	{
		$counter              = 0;
		$campaignMetaContacts = CampaignMeta::where( 'campaign_id', $id )
		                                    ->where( 'user_id', '=', auth()->id() )
		                                    ->get();

		$campaign_name = Campaign::select( 'title' )->where( 'id', $id )
		                         ->where( 'user_id', '=', auth()->id() )
		                         ->first();

		return view( 'user.campaigns.show', compact( 'campaignMetaContacts', 'campaign_name', 'counter' ) );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id )
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id )
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function StoreKeyword( Request $request )
	{
		$rules = [
			'keyword'      => 'required|unique:keywords,keyword,NULL,id,user_id,' . auth()->id(),
			'keyword_type' => 'required',
		];

		if ( $request->keyword_autoresponse == 'yes' ) {
			$rules[ 'keyword_text' ] = 'required';
		}

		// Validating inputs
		$this->validate( $request, $rules );
		// store
		$keyword = new Keyword();

		$keyword->user_id              = auth()->id();
		$keyword->keyword              = $request->keyword;
		$keyword->keyword_type         = $request->keyword_type;
		$keyword->keyword_autoresponse = $request->keyword_autoresponse;
		$keyword->keyword_text         = ( $request->keyword_autoresponse == 'yes' ) ? $request->keyword_text : '';

		$keyword->save();

		$request->session()->flash( 'alert-success', 'Keyword has been created successfully' );

		return back();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id )
	{
		//
	}

	/**
	 * Get the From Plivo numbers group on page load. An ajax method which
	 * had been written to make campaigns view a little responsive
	 *
	 * @return string
	 */
	public function fromNumberGroups()
	{
		/**
		 * Initiazlise Service instance according
		 * to user set Service Provider
		 */
        $isTwilio = \Auth::user()->setting->isTwilioEnabled();
		if ( $isTwilio ){
			$service  = new TwilioService( auth()->id() );
		}else{
			$service  = new PlivoService( auth()->id() );
		}
		$numbers = $service->listNumbers();

		/**
		 * Number of Texts Allowed per Twilio/Plivo Number
		 */
		// $allowedTextPerNumber = auth()->user()->setting ? auth()->user()->setting->per_number_text : 99999 ;
		 
		
		$html    = '';
		foreach ( $numbers as $number ):
			
			/**
			 * Filter number That have Reached 
			 * Messages Limit for Current Day
			 */
            $longCode = $isTwilio?  $number->phoneNumber:  $number->number;
			// $numberOfTextSentPerNumber = CampaignMeta::where('from_number',$longCode)->where('created_at','Like',Carbon::now()->format('Y-m-d').'%')->count();
				$html .= '<option value="' . $longCode . '">' . $longCode . '</option>';
		endforeach;
		if ($html == ''){
            $html .= '<option value="">No Number Found</option>';
		}
		return $html;
	}

	/**
	 * Make an HTML of contacts groups to show on Campaign create view
	 * This is an ajax method
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	public function ToNumberGroups()
	{

		$groups = Group::select( '*' )
		               ->where( 'user_id', auth()->id() )
		               ->get();
		$html   = '<option value="">Select To Numbers Groups</option>';
		foreach ( $groups as $group ):
			$html .= '<option value="' . $group->id . '">' . $group->name . '</option>';
		endforeach;

		return $html;
	}

	/**
	 * Make an HTML of FetchKeywords show on Campaign create view
	 * This is an ajax method
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	public function FetchKeywords()
	{

		$keywords = Keyword::where( 'user_id', '=', auth()->id() )->latest()->get();
		$html     = '<option value="">Select Keywords</option>';
		foreach ( $keywords as $keyword ):
			$html .= '<option value="' . $keyword->id . '">' . $keyword->keyword . '</option>';
		endforeach;

		return $html;
	}

	/**
	 * Stop campaign
	 *
	 * @param $campaignId
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */

	public function stopCampaign( $campaignId )
	{
		Campaign::where( 'id', $campaignId )
		        ->where( 'user_id', '=', auth()->id() )
		        ->update( [
			        'status' => 'stopped',
		        ] );
		// success message
		\request()->session()->flash( 'alert-success', 'Campaign has been stopped successfully!' );

		// redirect
		return redirect()->back();
	}

	/**
	 * Delete or Destroy Campaign
	 *
	 * @param $campaignId
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */

	public function destroyCampaign( $campaignId )
	{
		// destroy campaign meta
		CampaignMeta::where( 'campaign_id', $campaignId )->where( 'user_id', auth()->id() )->delete();

		// destroy campaign
		Campaign::where( 'id', $campaignId )->where( 'user_id', auth()->id() )->delete();

		// success message
		\request()->session()->flash( 'alert-success', 'Campaign has been removed successfully!' );

		// redirect
		return redirect()->back();
	}

	/**
	 * Restart a stopped or failed campaign
	 *
	 * @param $campaignId
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restartCampaign( $campaignId )
	{
		// update the campaign status ready again
		$update = Campaign::where( 'id', $campaignId )->where( 'user_id', auth()->id() )->update( [
			'status' => 'ready',
		] );

		// lets do this again
		if ( $update ) {

			$job = ( new RunCampaign( $campaignId, auth()->id() ) )->onQueue( 'RunCampaign' );

			dispatch( $job );
		}
		// success message
		\request()->session()->flash( 'alert-success', 'Campaign has been restarted successfully!' );

		// redirect
		return redirect()->back();
	}

	public function sendScheduledCampaigns(){
		$scheduledCampaigns = Campaign::where('status','scheduled')
										->where('scheduled_at','<=',Carbon::now())
										->get();
		
		foreach ($scheduledCampaigns as $campaign) {
			$campaign->status 		= 'created';
            $campaign->scheduled_at = null;
            $campaign->save();
			dispatch(new ProcessCampaign($campaign->id))->onQueue('processCampaign');
		}
		\Log::info("{$scheduledCampaigns->count()} Campaigns Sent");
	}
}
