<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Setting;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
		
        $settings = \Auth::user()->setting;
        if (!$settings){
            $settings    =   new Setting;
        }
        
		return view( 'user.settings.edit', compact( 'settings' ) );
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
        /**
         * Validate Request
         */
        $rules = [
            'twilio_account_sid'    => 'required_if:provider,twilio',
            'twilio_auth_token'     => 'required_if:provider,twilio',
            
            'plivo_account_sid'     => 'required_if:provider,plivo',
            'plivo_auth_token'      => 'required_if:provider,plivo',

			// 'per_number_text'       => 'required|numeric',
        ];
        $this->validate( $request, $rules, [
            '*.required_if' => ':attribute is Required' 
        ]);
        
        $settings   =   \Auth::user()->setting;
        if (!$settings){
            $settings = new Setting;
        }

        $settings->user_id            = auth()->id();
        
        if($settings->provider == 'twilio'){
            $settings->twilio_account_sid = $request->twilio_account_sid;
            $settings->twilio_auth_token  = $request->twilio_auth_token;
        }else{
            $settings->plivo_id = $request->plivo_account_sid;
            $settings->plivo_token  = $request->plivo_auth_token;
        }
        // $settings->per_number_text    = $request->per_number_text;
		$settings->save();

		
		// success message
		$request->session()->flash( 'alert-success', 'Settings have been updated successfully!' );

		// redirect back
		return redirect()->back();
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
}
