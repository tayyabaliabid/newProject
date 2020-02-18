<?php

namespace App\Http\Controllers\Admin;

use App\ApiServices\TwilioService;  
use App\Number;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numbers = Number::all();
        return view('admin.numbers.index',compact('numbers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $numbers = \request()->session()->get( 'user_id' . auth()->id() );
		$counter = 0;

        return view( 'admin.numbers.add', compact( 'numbers', 'counter' ) );
    }

    /**
     * Searches a Number Source by Given options from Twilio
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
            
        $rules = [
            'country'   => 'required',
            'areaCode'  => 'required',
            'type'      => 'required|in:tollFree,local',
            'voice'     => 'required_without_all:sms,mms',
            'sms'       => 'required_without_all:voice,mms',
            'mms'       => 'required_without_all:voice,sms',
        ];
        $res = $this->validate($request,$rules);
         
        if($request->voice && $request->sms)
        {
            $type = 'all';
        }
        else 
        {
            //$type = $request->sms ? 'sms' : $request->voice ? 'voice' : '';
        }

        $type = ['all'];
        $twilio = new TwilioService(auth()->id());
        $response =  $twilio->searchNumbers($request->areaCode, $res);
      
        if(isset($response->code) && $response->code == 200)
        { 
            $numbers = $response->data;
            return view('admin.numbers.searchResult', compact('numbers')); 
        }
        else
        {
            session()->flash('alert-success','Error : '.$response[0]->message);
            return back();
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $res = $this->validate($request,['number'=>'required']);

        
        $twilio     = new TwilioService(auth()->id()); 

        
        // $response =  $twilio->purchaseNumber($res); 
        $response =  $twilio->purchaseNumber([
            'name'      => $request->name,
            'number'    => $request->number,
            'url'       => '',
            'statusUrl' => ''
            ]
        );
 
        if ($response->code == 200){

            $purchased = $response;

            $number             = new Number;
            $number->user_id    = auth()->Id();
            $number->sid        = $purchased->sid;
            $number->name       = $request->name;
            $number->number     = $purchased->phoneNumber;
            // $number->url        = $purchased->voiceUrl;
            // $number->statusUrl  = $purchased->statusCallback;
            $number->save();
            
            $attributes = array(
                "PhoneNumber"          => $purchased->phoneNumber,
                "VoiceUrl"             => route('call.inbound'),
                'HangupCallback'       => route('call.inbound.statusCallback'),
                'HangupCallbackMethod' => 'POST',
                'VoiceMethod'		   => 'POST'
            );
            
            $response_update =  json_decode($twilio->updateNumber($attributes)); 
    
            if ($response_update->code == 200){
                $number->name       = $request->name;
                $number->url        = $response_update->voice_url;
                $number->statusUrl  = $response_update->hangup_callback;
                $number->save();
                
                session()->flash('alert-success','Success: Number Purchased Successfully');
                return redirect(route('admin.numbers'));

            }else{
                session()->flash('alert-danger','Error: '.$response_update->message);
                return back();
            }

        }else{
            session()->flash('alert-danger','Error: '.$response->message);
            return redirect(route('admin.number.create'));
        }
    }
 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Number $number)
    {
        return view('admin.numbers.edit',compact('number'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Number $number)
    {  
        $rules = [ 
            'url'       => 'required',
            'statusUrl' => 'required',
        ];
        $this->validate($request,$rules);

        $attributes = array(
            "PhoneNumber"     => $number->number,
            "VoiceUrl"        => $request->url,
            'HangupCallback'  => $request->statusUrl, 
        );
        
        $twilio     = new TwilioService; 
        $response   =  json_decode($twilio->updateNumber($attributes));
        
        if ($response->code == 200){
            $number->name       = $number->name;
            $number->url        = $response->voice_url;
            $number->statusUrl  = $response->hangup_callback;
            $number->save();
            session()->flash('alert-success','Success: Number Updated');
            return back();
        }else{
            session()->flash('alert-danger','Error: '.$response->message);
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Number $number)
    {
        $number->delete();
        session()->flash('alert-success','Number deleted');
        return back();
    }
}
