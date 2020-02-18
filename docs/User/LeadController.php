<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Jobs\ImportContacts;
use App\Http\Controllers\Controller;
use App\Group;
use App\Contact;

class LeadController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$groups  = Group::where( 'user_id', auth()->id() )->get();
        $counter = 0;
		return view( 'user.leads.index', compact( 'groups', 'counter' ) );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view( 'user.leads.create' );
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
		// validation
		$this->validate( $request, [
			'group_name' => 'required|unique:groups,name',
			'leads_csv'  => 'required|mimetypes:text/csv,text/plain,text/tsv',
		] );

		$uploadedLeadsInfo = $this->uploadLeadsCsv( $request );

		// insert into db
		$group                 = new Group();
		$group->user_id        = auth()->id();
		$group->name           = $request->group_name;
		$group->file_name      = $uploadedLeadsInfo[ 'file_name' ];
		$group->upload_path    = $uploadedLeadsInfo[ 'upload_path' ];
		$group->total_contacts = 0;
		$group->status         = 'queued';
		$group->save();

		 //lets dispatch job
		$job = ( new ImportContacts(auth()->id(), $group->id ) )->onQueue( 'importContacts' );
		$this->dispatch( $job );

		// success message
		session()->flash( 'alert-success','Contacts have been added into queue successfully!' );

		// redirect back
		return back();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id )
	{
		$contacts = Group::find( $id )->contacts()->paginate(500);
		$counter  = 0;

		return view( 'user.leads.show', compact( 'contacts', 'counter' ) );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 * @throws \Exception
	 */
	public function destroy( $id )
	{
		// get group info
		$group = Group::find( $id );

		// User can only delete its own contacts files
		if ( $group->user_id != auth()->id() ) {
			return redirect()->back();
		}

		// remove uploaded csv
		if (file_exists($group->upload_path))
		unlink($group->upload_path);

		// delete group contacts
		Contact::where( 'group_id', $group->id )->delete();

		//delete group
		Group::destroy( $id );

		// success message
		\request()->session()->flash( 'alert-success', 'Contacts group have been deleted successfully!' );

		// redirect back
		return redirect()->back();
	}

	/**
	 * Upload Contacts CSV
	 *
	 * @param $request
	 *
	 * @return array
	 */
	public function uploadLeadsCsv( Request $request )
	{

		//dd($request->all());
		$fileRowsCount = count( file( $request->file( 'leads_csv' ) ) );
		$file          = $request->file( 'leads_csv' );

		// setting file directory
		$mainDir = public_path() . '/uploads/user_' . auth()->id().'/';

		$fileSpecDir = $mainDir . '/' . $request->group_name;

		// Upload file and make return array
		$uploaded_file_path     = $file->move( $mainDir, $request->group_name . '.' . $file->getClientOriginalExtension() );
		$fileInfo               = $this->getFileDetails( $file );
		$uploadedFileProperties = [
			'file_name'           => $fileInfo[ 'file_name' ],
			'extension'           => $fileInfo[ 'file_ext' ],
			'upload_path'         => $uploaded_file_path,
			'contacts_group_path' => $mainDir,
			'total_contacts'      => $fileRowsCount,
		];

		return $uploadedFileProperties;
	}

	/**
	 * Get uploaded file details
	 *
	 * @param $file
	 *
	 * @return array
	 */
	public function getFileDetails( $file )
	{
		$file_details = [];
		//Display File Name
		$file_details[ 'file_name' ] = $file->getClientOriginalName();

		//Display File Extension
		$file_details[ 'file_ext' ] = $file->getClientOriginalExtension();

		//Display File Real Path
		$file_details[ 'file_real_path' ] = $file->getRealPath();

		return $file_details;
	}
}
