<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{
    // 
    /**
     * show api credentials
     */
    public function index()
    { 
        $setting = Setting::whereUserId(auth()->id())->first();
        if(!$setting)
        $setting = new Setting();
        return view('user.settings.index', compact('setting'));
    } 

    /**
     * update settings
     */
    public function update(Request $request)
    {    
        $setting = Setting::whereUserId(auth()->id())->first(); 
        if (!$setting) 
            $setting   = new  Setting; 

        $setting->user_id       =   auth()->id();
        $setting->sid           =   $request->sid;
        $setting->token         =   $request->token; 
        $setting->save();

        $request->session()->flash('alert-success', 'Success: Settings Updated Successfully');
        return back();
    } 
}
