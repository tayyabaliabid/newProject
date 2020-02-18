<?php

namespace App\Http\Controllers\Admin;
 
use Illuminate\Http\Request; 
use App\User;   
use App\Http\Controllers\Controller; 
// use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    
    /**
     * show all users
    */
    public function index()
    {
        $users   = User::where('type', '!=', 'admin')->paginate(10);
        $counter = 0;   
        return view('admin.users.index', compact('users', 'counter')); 
    }


    /**
     * Create a new user
     */
    public function create()
    {  
        return view('admin.users.create');
    }

    /**
     * Store user with their types
     */
    public function store(Request $request)
    {    
        $rules = [
            'name'          =>  'required',
            'email'         =>  'required|Regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/i|unique:users',  
            'password'      =>  'required',   
            'active'        =>  'required', 
        ];

        $this->validate($request, $rules);
 
        $user               =   new User();
        $user->name         =   $request->name;
        $user->email        =   $request->email;  
        $user->active       =   $request->active;
        $user->password     =   bcrypt($request->password);// bcrypt(trim($request->));
        $user->save();
 
        $request->session()->flash('alert-success' , 'User Created Successfully');
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $user = User::find($id); 
        return view('admin.users.edit', compact('user'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $rules = [
            'name'          => 'required', 
            'email'         => 'required|Regex:/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/i|unique:users,email,'.$id,  
            'phone'        => 'required', 
            'active'        => 'required', 
        ]; 

        $this->validate($request,$rules);
        
        $user = User::find($id);
        
        $user->name          = $request->name;
        $user->email         = $request->email; 
        $user->number          = $request->phone;  
        $user->active        = $request->active;
        
        if($request->password != '')
            $user->password  = bcrypt($request->password);
        
        $user->save();
        
        $request->session()->flash('alert-success', 'User Updated Successfully');
        return redirect()->route('admin.users');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete(); 
        session()->flash('alert-success', 'User Deleted Successfully!');  
        return redirect()->route('admin.users'); 
    }
}
