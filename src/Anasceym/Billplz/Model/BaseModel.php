<?php
namespace Anasceym\Billplz\Model;


use anlutro\cURL\cURL;
use Exception;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseModel {

	/**
	 * @var ReflectionClass
	 */
	private $selfReflection;

	/**
	 * @var
	 */
	protected $apiKey;

	/**
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * @param $apiKey
	 */
	function __construct($apiKey = null)
	{
		$this->apiKey = $apiKey;	
		$this->selfReflection = new ReflectionClass($this);
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function __set($name, $value) {
		
		if($this->isAvailableField($name)) {
			
			$this->attributes[$name] = $value;
		}
	}

	/**
	 * @param $name
	 * @return mixed
	 */
	public function __get($name) {
		
		if($this->isAvailableField($name)) {
			
			return $this->attributes[$name];
		}
	}

	/**
	 * @param $name
	 * @return bool
	 */
	private function isAvailableField($name) {
		
		return  in_array($name, $this->getProperty('required_data')) 
			|| in_array($name, $this->getProperty('optional_data')) || $name == 'id';
	}

	/**
	 * @param $model
	 * @param null $propertiesArray
	 * @return bool
	 */
	public static function createModel($model, $propertiesArray = null, $save = true) {
		
		if(!$model instanceof BaseModel) {
			
			return false;
		}
		
		if(! is_array($propertiesArray)) {
			
			return $model;
		}
		
		if(array_key_exists('id', $propertiesArray)) unset($propertiesArray['id']);
		
		if(!$save) {
			
			return $model->mapArrayToModel($propertiesArray);
		}
		
		return $model->mapArrayToModel($propertiesArray)->save();
	}

	/**
	 * @param array $propertiesArray
	 * @return $this
	 */
	public function mapArrayToModel($propertiesArray = []) {
		
		foreach($propertiesArray as $key => $prop) {
			
			$this->{$key} = $prop;
		}
		
		return $this;
	}

	/**
	 * @param $selfReflection
	 */
	private function getProperty($propertyName)
	{
		
		try {
			
			$properties = $this->selfReflection->getProperty($propertyName);
		
			$properties->setAccessible(true);
		
			return $properties->getValue($this);
		} catch(Exception $exp) {}
		
		return [];
	}

	/**
	 * @throws Exception
	 */
	protected function validatePostData() {
		
		if(count($missingFields = array_diff($this->getProperty('required_data'), array_keys($this->attributes)))) {
			
			throw new Exception('Please provide the following fields : '. implode(', ', $missingFields));
		}
	}
}