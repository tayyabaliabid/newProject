<?php

namespace App\Jobs;

use Illuminate\Support\Collection;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Exception;
use Carbon\Carbon;
use App\Jobs\TwilioLookUp;
use App\Group;
use App\Contact;

class ImportContacts implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	/**
	 * The number of times the job may be attempted.
	 *
	 * @var int
	 */
	public $tries = 1;
	/**
	 * The number of seconds the job can run before timing out.
	 *
	 * @var int
	 */
	public $timeout = 80000;
	public $userId;
	public $groupId;
	public $group;
	/**
	 * Create a new job instance.
	 *
	 * @param $userId
	 * @param $groupId
	 */
	public function __construct( $userId, $groupId )
	{
		$this->userId  	= $userId;
		$this->groupId 	= $groupId;
		$this->group 	=	Group::find($groupId);
	}

	/**
	 * Execute the job and import contacts from CSV file into the application
	 *
	 * @return void
	 */
	public function handle()
	{
		try{
			// Fetch group
			$group = Group::find( $this->groupId );

			// return null if nothing found to fetch
			if ( empty( $group ) ) :
				return null;
			endif;

			// Update Group Status
			$this->update( 'processing' );

			// Read CSV file
			$contacts = $this->readCsv( $group->upload_path );

			\Log::info('CSV read with '.count($contacts). ' Contacts');
			\Log::info($contacts);
			// return null if nothing found to fetch
			if ( empty( $contacts ) ):
				$this->update( 'completed' );
				return null;
			endif;

			// Save contacts
			$this->store( $contacts );

			// Update Group Status
			$this->update( 'completed' );

		}catch(Exception $ex){
			\Log::info( $ex );
			$this->update( 'completed' );
		}
	}

	/**
	 * Read the imported CSV file
	 *
	 * @param $filePath
	 *
	 * @return array
	 */
	public function readCsv( $filePath )
	{

		// read the file from directory
		$csv           = array_map( 'str_getcsv', file( $filePath ) );
		$colCount      = 0;
		$array_counter = 0;
		$inserts       = [];

		// read csv file,
		foreach ( $csv as $key => $value ) :
             $contacts = Contact::where('group_id',$this->groupId)->where('number',makeInternalNumber( $value[ 0 ] ))->count();

			if ($contacts==0 && strlen( $value[ 0 ] ) > 5 ) :

				$colCount ++;

				//dd($lookup_date);
				$inserts[ $array_counter ][ 'user_id' ]    	= $this->userId;
				$inserts[ $array_counter ][ 'group_id' ]   	= $this->groupId;
				$inserts[ $array_counter ][ 'number' ]     	=  makeInternalNumber( $value[ 0 ] );
				$inserts[ $array_counter ][ 'first_name' ] 	= ( isset( $value[ 1 ] ) ) ? $value[ 1 ] : null;
				$inserts[ $array_counter ][ 'last_name' ]  	= ( isset( $value[ 2 ] ) ) ? $value[ 2 ] : null;
				$inserts[ $array_counter ][ 'email' ]     	= ( isset( $value[ 3 ] ) ) ? $value[ 3 ] : null;
				$inserts[ $array_counter ][ 'city' ]     	= ( isset( $value[ 3 ] ) ) ? $value[ 3 ] : null;
				$inserts[ $array_counter ][ 'state' ]     	= ( isset( $value[ 3 ] ) ) ? $value[ 3 ] : null;
				$inserts[ $array_counter ][ 'zip' ]     	= ( isset( $value[ 3 ] ) ) ? $value[ 3 ] : null;
				$inserts[ $array_counter ][ 'created_at' ] 	= Carbon::now();
				$inserts[ $array_counter ][ 'updated_at' ] 	= Carbon::now();
			endif; // end of fixer
			$array_counter ++;
		endforeach;

		return $inserts;
	}

	/**
	 * Save contacts
	 *
	 * @param array $contacts
	 *
	 * @return int
	 */
	public function store( $contacts )
	{
		$savedContacts = new Collection;
		$contactsSaved = 0;


		foreach($contacts as $contact){
			try{
				$savedContacts->push(Contact::create($contact)); 
				$contactsSaved++;
			}catch(Exception $ex){
				\Log::info($ex->getMessage());
			}
		}

		$totalContacts = count( $contacts );

		$this->group->total_contacts+=$contactsSaved;
		$this->group->save();
		
		return $totalContacts;
	}

	/**
	 * Update group status
	 *
	 * @param $status
	 * @return void
	 */
	public function update( $status )
	{
		Group::where( 'id', $this->groupId )->update( [ 'status' => $status ] );
	}
}
