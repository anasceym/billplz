<?php 
namespace Anasceym\Billplz\Traits;

trait ModelTrait {
	
	/**
	 * @param null $properties
	 * @return bool
	 */
	public static function create($properties = null) {
		
		return parent::createModel(new self(), $properties);
	}
}