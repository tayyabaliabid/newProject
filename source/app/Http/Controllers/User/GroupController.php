<?php

namespace App\Http\Controllers\User;
 
use Illuminate\Http\Request; 
use App\Group;  
use App\Contact;   
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Storage; 

class GroupController extends Controller
{ 
    /**
     * show all groups
     */
    public function index()
    {
        $groups   = Group::whereUserId(auth()->id())->paginate(10);
        $counter    = 0;   
        return view('user.groups.index', compact('groups', 'counter')); 
    }
 
    /**
     * Create a new user
     */
    public function create()
    {   
        $groups   = Group::whereUserId(auth()->id())->get();
        return view('user.groups.create', compact('groups'));
    }

    /**
     * Store user with their types
     */
    public function store(Request $request)
    {         
        $rules = [ 
            'new_name'      =>  'required_if:type,==,new', 
            'existing_name' =>  'required_if:type,==,existing', 
            'file'          =>  'required|mimes:csv,txt'
        ];

        $this->validate($request, $rules); 

        //upload csv file
        $upload_file        = Storage::put('csv_files', $request->file);
        $filename           = asset('/source/storage/app/'.$upload_file); 

        //read csv file
        $numbers            = $this->readCSV($filename, array('delimiter' => ',')); 
         

        $group              = $request->type == 'new' ? new Group() : Group::find($request->existing_name); 

        $request->type == 'new' ? $group->name = $request->new_name : ''; 

        $group->user_id     = auth()->id(); 
        $group->file_path   = $filename; 
        $group->save();

        foreach($numbers as $number)
        {
            $contact               = new Contact();
            $contact->group_id     = $group->id; 
            $contact->number       = $number[0]; 
            $contact->save();
        } 
        $msg =  $request->type == 'new' ? 'Group Created Successfully' : 'Group Updated Successfully';
        $request->session()->flash('alert-success' , $msg);
        return back();
    }

    /**
     * read csv file and return an array
     */
    public function readCSV($csvFile, $array)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
        }
        fclose($file_handle);
        return $line_of_text;
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $group = Group::find($id); 
        return view('user.groups.edit', compact('group'));  
    }

    public function view($id)
    {   
        $contacts = Contact::whereGroupId($id)->paginate(10); 
        $counter  = 0;
        return view('user.groups.view', compact('contacts', 'counter'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        $filename = false;
        $rules['name'] = 'required';  

        if($request->file)
        {
            $rules['file']  = 'required';
            //upload csv file
            $upload_file        = Storage::put('csv_files', $request->file);
            $filename           = asset('/source/storage/app/'.$upload_file); 

             //read csv file
            $numbers            = $this->readCSV($filename, array('delimiter' => ',')); 
            
        } 

        $this->validate($request, $rules);
        
        $group                = Group::find($id); 
        $group->name          = $request->name; 
        if($filename)
        {
            $group->file_path = $filename;
            foreach($numbers as $number)
            {
                $contact               = new Contact();
                $contact->group_id     = $id; 
                $contact->number       = $number[0]; 
                $contact->save();
            }
        } 
        $group->save();
        
        $request->session()->flash('alert-success', 'Group Updated Successfully');
        return redirect()->route('user.groups');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $group = Group::find($id); 
        $group->delete(); 
        session()->flash('alert-success', 'Group Deleted Successfully!');  
        return redirect()->route('user.groups'); 
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy_contact($id)
    {
        $contact = Contact::find($id);
        $contact->delete(); 
        session()->flash('alert-success', 'Contact Deleted Successfully!');  
        return back(); 
    }
    
}
