<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ProfileController extends Controller
{ 
    /**
     * edit profile
     */
    public function index()
    {
        $profile = User::find(auth()->id());

        return view('user.profile.index', compact('profile'));
    }
    /**
     * update profile
     */
    public function update(Request $request)
    { 
        $user = User::find( auth()->id() );

        // Set Rules Validation
        $rules = [
            'name'          => 'required|regex:/^[a-zA-Z0-9]+([_\s\-]?[a-zA-Z0-9])+s*$/',
            'email'         => 'required:unqie,email,'.$user->id,
            'password'      => 'nullable',

        ];
        $this->validate($request,$rules);

        // Save to database

        $user               = User::find(auth()->id() );
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->password     = ( null === $request->password ) ? $user->password : bcrypt( $request->password );
        $user->save();

        $request->session()->flash( 'alert-success', 'Success: Profile has been Updated Successfully');
        return redirect()->back();
    }

     
}
