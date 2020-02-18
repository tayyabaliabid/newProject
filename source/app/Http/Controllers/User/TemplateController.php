<?php

namespace App\Http\Controllers\User;
 
use Illuminate\Http\Request; 
use App\Template;    
use App\Http\Controllers\Controller; 
use Illuminate\Support\Facades\Storage; 

class TemplateController extends Controller
{ 
    /**
     * show all templates
     */
    public function index()
    {
        $templates  = Template::whereUserId(auth()->id())->paginate(10);
        $counter    = 0;   
        return view('user.templates.index', compact('templates', 'counter')); 
    }
 
    /**
     * Create a new user
     */
    public function create()
    {    
        return view('user.templates.create');
    }

    /**
     * Store user with their types
     */
    public function store(Request $request)
    {         
        $rules = [ 
            'name'      =>  'required', 
            'body'      =>  'required',  
        ];

        $this->validate($request, $rules);   

        $template              = new Template();

        $template->user_id     = auth()->id(); 
        $template->name        = $request->name; 
        $template->body        = $request->body; 
        $template->save(); 
 
        $request->session()->flash('alert-success' , 'Template Created Successfully');
        return back();
    } 

    /**
     * Show the form for editing the specified resource.
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $template = Template::find($id); 
        return view('user.templates.edit', compact('template'));  
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
            'name'      =>  'required', 
            'body'      =>  'required',  
        ];

        $this->validate($request, $rules);   

        $template              = Template::find($id);

        $template->user_id     = auth()->id(); 
        $template->name        = $request->name; 
        $template->body        = $request->body; 
        $template->save(); 
        
        $request->session()->flash('alert-success', 'Template Updated Successfully');
        return redirect()->route('user.templates');
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    { 
        $template = Template::find($id); 
        $template->delete(); 
        session()->flash('alert-success', 'Template Deleted Successfully!');  
        return redirect()->route('user.templates'); 
    }
 
    
}
