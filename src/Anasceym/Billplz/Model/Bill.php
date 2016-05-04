<?php
namespace Anasceym\Billplz\Model;


use Anasceym\Billplz\Traits\ModelTrait;
use anlutro\cURL\cURL;

class Bill extends BaseModel {

	use ModelTrait;
	
	/**
	 *
	 */
	CONST CREATE_BILL_URL = 'https://www.billplz.com/api/v2/bills';
	
	/**
	 *
	 */
	CONST GET_BILL_URL = 'https://www.billplz.com/api/v2/bills/{billID}';

	/**
	 * @var array
	 */
	protected $required_data = ['collection_id', 'email', 'name', 'amount', 'callback_url'];

	/**
	 * @var array
	 */
	protected $optional_data = ['due_at', 'metadata', 'redirect_url', 'deliver'];

	/**
	 * @return $this|bool
	 * @throws \Exception
	 */
	public function save() {
		
		$curl = new cURL();
		
		$this->validatePostData();
		
		$response = $curl
			->newRequest('post', self::CREATE_BILL_URL, $this->attributes)
			->setUser($this->apiKey)->send();
		
		if($response->statusCode !== 200) {
			
			return false;
		}
		
		$responseBody = json_decode($response->body, true);
		
		return $this->mapArrayToModel($responseBody);
	}

	/**
	 * @param null $billID
	 * @return bool|null
	 */
	public static function find($billID = null, $apiKey) {
		
		if(!$billID) {
			
			return null;
		}
		
		$curl = new cURL();
		
		$response = $curl
			->newRequest('get', str_replace('{billID}', $billID, self::GET_BILL_URL))
			->setUser($apiKey)->send();
		
		
		if($response->statusCode !== 200) {
			
			return null;
		}
		
		$responseBody = json_decode($response->body, true);
		
		return parent::createModel(new self(), $responseBody, false);
	}

	/**
	 * @param null $billID
	 * @return bool|null
	 */
	public static function delete($billID = null, $apiKey) {
		
		if(!$billID) {
			
			return null;
		}
		
		$curl = new cURL();
		
		$response = $curl
			->newRequest('delete', str_replace('{billID}', $billID, self::GET_BILL_URL))
			->setUser($apiKey)->send();
		
		if($response->statusCode !== 200) {
			
			return false;
		}
		
		return true;
	}
}