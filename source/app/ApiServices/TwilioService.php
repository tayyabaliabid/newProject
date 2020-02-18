<?php
/**
 * Twilio REST API Source Provider Class.
 * This class define Twilio REST API useful method which are required in project
 *
 * @author : AdnanShabbir
 * Date: 21/10/2018
 * Time: 11:08
 */
namespace App\ApiServices;

use App\User;
use App\Setting;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Exception;

class TwilioService{

    protected $userId;
	protected $authId;
	protected $authToken;

    private $twilio;
	/**
	 * TwilioSourceProvider constructor.
	 *
	 * @param $userId
	 */
	public function __construct($userId = 0 )
	{
		$this->userId = $userId;

		$settings         	= Setting::where( 'user_id', $userId )->first();
		 
		if ( !$settings ){
            throw new Exception("Admin Settings not found");
		}
		$this->authId  		= $settings->sid;
		$this->authToken 	= $settings->token;
        $this->twilio = new Client( $this->authId, $this->authToken );
	}


	/**
	 * Fetch Twilio account numbers
	 *
	 * @return null|TwilioException|array
	 */
	public function listNumbers()
	{

		$response = null;

		try {
			$incomingPhoneNumbers = $this->twilio->incomingPhoneNumbers->read();
			$counter              = 0;

			return (Object)[
				'code' 		=>200,
				'message' 	=> 'success',
				'data'		=> $incomingPhoneNumbers
			];

		} catch ( TwilioException $exception ) {
			return (Object)[
				'code' 		=> $exception->getCode(),
				'message' 	=>  $exception->getMessage(),
			];
		}

		return $response;
	}

	/**
	 * Search the Twilio and get the list of numbers available to buy as per your criteria
	 *
	 * @ref-url https://www.twilio.com/docs/api/rest/available-phone-numbers in use
	 * @param array $search_params
	 *
	 * @return array list of free twilio numbers list
	 */
	public function searchNumbers($type, array $params) {
 
        $type = $params['type'];

		// dd(
		// 	array(
		// 	"areaCode"     => $params['areaCode'],
		// 	"voiceEnabled" => $params['voice'],
		// 	"mmsEnabled"   => $params['sms'],
		// 	"smsEnabled"   => $params['mms'],
		// 	)
		// );

		$api_sim_param = [
			"areaCode"     				=> $params['areaCode'], 
			'excludeAllAddressRequired'	=> 'false'
		];

		$features = ['voiceEnabled' => 'voice', 'smsEnabled' => 'sms', 'mmsEnabled' => 'mms'];
		
		foreach($features as $key => $feature)
		{
			if($params[$feature] == true)
			{
				$api_sim_param[$key] = true;
			}
		}
		

		try{
            $numbers = $this->twilio->availablePhoneNumbers( $params['country'] )->$type->read($api_sim_param);

            if ( empty ( $numbers ) ){
                return (Object)[
                    'code'      => 400,
                    'message'   => 'No number Found'
                ];
            }
            else{
                return (Object)[
                    'code'      => 200,
                    'message'   => 'success',
                    'data'      => $numbers,
                ];
            }

		}catch(TwilioException $e ){     
            return (Object)[
                'code'      => 400,
                'message'   => $e->getMessage(),
            ];
		}

    }

    /**
	 * Purchase a number directly from Twilio
	 * Initiated from the purchase numbers view
	 *
	 * @ref-url https://www.twilio.com/docs/tutorials/buy-a-number
	 * @ref-url https://www.twilio.com/docs/api/rest/incoming-phone-numbers#create-a-new-incomingphonenumber in use
	 */
	public function purchaseNumber(array $params) {

		try{
                $response = $this->twilio->incomingPhoneNumbers
                                ->create(array(
                                             "friendlyName"         => $params['name'],
                                             "phoneNumber"          => $params['number'],
                                             "voiceMethod"          => "POST",
                                             "voiceUrl"             => $params['url'],
                                             'statusCallback'       => $params['statusUrl'],
                                             'statusCallbackMethod' => 'POST'
                                         )
                                );
            return (Object)[
                'code'      =>  200,
                'message'   =>  'success',
                'data'      =>  $response
            ];
        }catch(Exception $ex){
            return (Object)[
                'code'      =>  400,
                'message'   =>  $ex->getMessage()
            ];
        }
	}
	

	/**
	 * Update a number directly to Twilio
	 * Initiated from the purchase numbers view
	 *
	 * @ref-url https://www.twilio.com/docs/tutorials/buy-a-number
	 * @ref-url https://www.twilio.com/docs/api/rest/incoming-phone-numbers#create-a-new-incomingphonenumber in use
	 */
	public function updateNumber($sid,array $params){
		try{
			$response = $this->twilio->incomingPhoneNumbers($sid)
							->update(array(
										 "friendlyName"         => $params['name'],
										 "voiceUrl"             => $params['url'],
										 'statusCallback'       => $params['statusUrl'],
										 'statusCallbackMethod' => 'POST',
										 'voiceMethod'			=> 'POST'
									 )
							);
			return (Object)[
				'code'      =>  200,
				'message'   =>  'success',
				'data'      =>  $response
			];
		}catch(Exception $ex){
			return (Object)[
				'code'      =>  400,
				'message'   =>  $ex->getMessage()
			];
		}
	}

}