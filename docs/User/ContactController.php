<?php

namespace App\Http\Controllers\User;

use App\Contact;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($number=null)
	{
		$groups = auth()->user()->groups;
		
		return view( 'user.contacts.create', compact( 'groups','number' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request )
	{
		//return $request->all();
		// validating
		$this->validate( $request, [
			'group_id'   => 'required',
			'first_name' => 'required|max:25|min:2',
			//'email'      => 'required|max:50|email',
			'last_name'  => 'string|nullable|max:25|min:2',
			'phone'      => 'required|max:15|min:10',
			'city'       => 'string|nullable|max:25|min:2',
			'state'      => 'string|nullable|max:25|min:2',
			'zip'        => 'string|nullable|max:25|min:2',
        ] );
		$contact             = new Contact();
		$contact->user_id    = auth()->id();
		$contact->group_id   = $request->group_id;
		$contact->first_name = $request->first_name;
		$contact->last_name  = $request->last_name;
		$contact->number     = makeInternalNumber($request->phone);
		$contact->email      = $request->email;
		$contact->city       = $request->city;
		$contact->state      = $request->state;
		$contact->zip        = $request->zip;
		$contact->status     = 'contact_form';
		$contact->save();

		// success message
		$request->session()->flash( 'alert-success', 'Contact has been created successfully' );

		// redirect
		return redirect()->back();
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param \App\Contact $contact
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( Contact $contact )
	{
		$groups = auth()->user()->groups;

		return view( 'user.contacts.edit', compact( 'contact', 'groups' ) );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id )
	{
		// validating
		$this->validate( $request, [
			'group_id'   => 'required',
			'first_name' => 'required|max:25|min:2',
			/*'email'      => 'required|max:50|email',*/
			'last_name'  => 'string|nullable|max:25|min:2',
			'phone'      => 'required|max:15|min:10',
			'city'       => 'string|nullable|max:25|min:2',
			'state'      => 'string|nullable|max:25|min:2',
			'zip'        => 'string|nullable|max:25|min:2',
		] );

		$contact             = Contact::find( $id );
		$contact->user_id    = auth()->id();
		$contact->group_id   = $request->group_id;
		$contact->first_name = $request->first_name;
		$contact->last_name  = $request->last_name;
		$contact->number     = makeInternalNumber($request->phone);
		$contact->email      = $request->email;
		$contact->city       = $request->city;
		$contact->state      = $request->state;
		$contact->zip        = $request->zip;
		$contact->save();

		// success message
		$request->session()->flash( 'alert-success', 'Contact has been updated successfully' );

		// redirect
		return back();//redirect()->route( 'leads.show', $request->group_id );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id )
	{
		// get group info
		$contact = Contact::find( $id );

		// User can only delete its own contacts files
		if ( $contact->user_id != auth()->id() ) {
			return redirect()->back();
		}

		//delete contacts
		Contact::destroy( $id );

		// success message
		\request()->session()->flash( 'alert-success', 'Contact has been deleted successfully!' );

		// redirect back
		return redirect()->back();
	}
}
