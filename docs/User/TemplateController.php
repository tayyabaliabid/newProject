<?php

namespace App\Http\Controllers\User;

use App\Template;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::where('user_id', '=', auth()->id() )->latest()->get();
		$counter   = 0;

		return view( 'user.templates.index', compact( 'templates', 'counter' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( 'user.templates.create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
		$this->validate( $request, [
			'title'         => 'required|unique:templates,title,NULL,id,user_id,' . auth()->id(),
			'template_body' => 'required',
		] );

		// store
		$template = new Template();

		$template->user_id       = auth()->id();
		$template->title         = $request->title;
		$template->template_body = $request->template_body;

		$template->save();

		// success
		$request->session()->flash( 'alert-success', 'Template has been added successfully!' );

		// redirect
		return redirect()->back();
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
    public function edit( Template $template )
    {
        if ( auth()->id() != $template->user_id ) {
			return redirect()->back();
		}
        
		return view( 'user.templates.edit', compact( 'template' ) );
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
       
        // validate
		$this->validate( $request, [
			'title'         => 'required',
			'template_body' => 'required',
		] );

		$template                = Template::find( $id );
		$template->user_id       = auth()->id();
		$template->title         = $request->title;
		$template->template_body = $request->template_body;

		$template->save();

		// success
		$request->session()->flash( 'alert-success', 'Template has been updated successfully!' );

		// redirect
		return redirect()->route( 'user.templates.index' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = Template::where( 'id', '=', $id )->where( 'user_id', '=', auth()->id() )->first();

		$template->delete();

		// success
		\Request::session()->flash( 'alert-success', 'Template has been deleted successfully!' );

		// redirect
		return redirect()->route( 'user.templates.index' );
    }
}
