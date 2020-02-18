<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Group;
use App\Contact;
use App\Campaign;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view ('user.dashboard.index');
    }

    public function getData(){
        
        $contactsCount      =   Contact::where('user_id',auth()->Id())->count();
        $campaignCount      =   Campaign::where('user_id',auth()->Id())->count();
        $leadsCount         =   Group::where('user_id',auth()->Id())->count();
        $activeCampaigns    =   Campaign::with(['group'=>function($query){
            $query->select('id', 'name');
        }])->where('user_id',auth()->Id())->where('status','sending')->get();
        $activeCampaignCount=   count($activeCampaigns);

        return response()->json([
            'activCampaigns'        =>  $activeCampaigns,
            'numberCount'           =>  $contactsCount,
            'campaignCount'         =>  $campaignCount,
            'leadsCount'            =>  $leadsCount,
            'activeCampaignCount'   =>  $activeCampaignCount,
        ]);
    }



}
