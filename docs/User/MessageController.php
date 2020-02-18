<?php

namespace App\Http\Controllers\User;

use Twilio\Twiml;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;
use App\Template;
use App\Message;

use App\Keyword;
use App\Http\Providers\TwilioSourceProvider;
use App\Http\Controllers\Controller;
use App\Contact;
use App\ApiService\TwilioService;
use App\ApiService\PlivoService;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all()->sortByDesc('id');
        $counter=0;
        return view('user.messages.index',compact('messages','counter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $counter           = 0;
		$keywords          = Keyword::where( 'user_id', '=', auth()->id() )->latest()->get();
        $message_templates = Template::where( 'user_id', auth()->id() )->get();
        $contacts          = Contact::all();

		return view( 'user.messages.create', compact( 'keywords', 'message_templates','contacts', 'counter' ) );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        /**
         * Set Validation Rules 
         */
        $rules=[
            "from_number" => "required",
            "message"     => "required|max:140"
        ];
        $messages=[];
        switch($request->to_number_choose){
            case "contact":
                $rules["contacts"]="required";
                $to = makeInternalNumber($request->contacts);
            break;
            case "add":
                {
                    $to = makeInternalNumber ($request->number,$request->country_code);
                    
                    switch($request->country_code){
                        case "US":
                            $rules["number"]="required | min:10| max:12";
                        break;
                        case "BE";
                            $rules["number"]="required | min:9| max:12";
                        break;
                    }
                    if ( $to===null)
                    {
                        $rules["number"].="|email";
                        $messages['number.email']= "The number does not match ".getCountryName($request->country_code)." Number Format";
                    }
                    
                }
            break;
        }
        /**
         * Validate Request base on rule Set Defined
         */
        
        $this->validate($request,$rules,$messages);
        
       
        /**
         * Prepare Parameter to be passed 
         */
        $from= $request->from_number;
        $body= $request->message;

        /**
         * Initialize Twilio object and Send a Message
         */
        $isTwilio = auth()->user()->setting->isTwilioEnabled();
        if ( $isTwilio ){
            $service = new TwilioService(auth()->Id());
        }else{
            $service = new PlivoService( auth()->Id() );
        }
        $response = $service->sendMessage($from,$to,$body);


        /**
         * Check Twillio Response if have any Error
         * and Set Error Message for view
         */
        if (!$response->success){
            $request->session()->flash("alert-danger",$response->message);
        }else{
            /**
             * Save Twilio/Plivo Response To Message Log Table
             */
            $message                =   new Message;
            $message->account_sid   =   $isTwilio ? $response->data->sid        : $response->data->message_uuid ;
			$message->from          =   $from; 
			$message->to            =   $to; 
			$message->body          =   $request->message; 
			$message->status        =   'sent';
			$message->error_code    =   $isTwilio ? $response->data->errorCode   : '';
			$message->error_message =   $isTwilio ? $response->data->errorMessage: '';
			$message->date_sent     =   Carbon::now();
            $message->direction     =   'Outbound';
            $message->save();
            /**
             * Set Response Message for View
             */
            $request->session()->flash("alert-success","Message Sent Successfully");
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * A function to Handle Twillio Message Status CallBacks
     * 
     * @param null
     * 
     * @return \Twillio\Twiml
     */

    public function twillioMessageStatusCallback(){
        $sid    = \request('MessageSid');
        $status = \request('MessageStatus');
        try{
            $message    = Message::where('uuid',$sid)->first();

            if ($message!=null){
                $message->status = $status;
                $message->save();
            }
            $response = new TwiML();
            exit($response);
        }catch(Exception $e){
            mail("superhacher3@gmail.com",'SMS statusCallback',$sid." : ".$status);
        }
    }
}
