<?php
namespace Anasceym\Billplz\Model;

use Anasceym\Billplz\Traits\ModelTrait;
use anlutro\cURL\cURL;
use ReflectionClass;
use ReflectionProperty;

class Collection extends BaseModel {
	
	use ModelTrait;
	/**
	 *
	 */
	CONST CREATE_COLLECTION_URL = 'https://www.billplz.com/api/v2/collections';

	/**
	 * @var array
	 */
	protected $required_data = ['title'];

	/**
	 * @var array
	 */
	protected $optional_data = ['logo'];

	/**
	 * @return $this|bool
	 * @throws \Exception
	 */
	public function save() {
		
		$curl = new cURL();
		
		$this->validatePostData();
		
		$response = $curl
			->newRequest('post', self::CREATE_COLLECTION_URL, $this->attributes)
			->setUser($this->apiKey)->send();
		
		if($response->statusCode !== 200) {
			
			return false;
		}
		
		$responseBody = json_decode($response->body, true);
		
		return $this->mapArrayToModel($responseBody);
	}
}