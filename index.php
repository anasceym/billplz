<?php

require_once('vendor/autoload.php');

$curl = new anlutro\cURL\cURL;

CONST API_KEY = 'b53a791f-a2fd-433e-b833-3e686d95ce05';

//$postData = array(
//	'title' => 'Test Collection'
//);
//
//$response = $curl
//	->newRequest('post', CREATE_COLLECTION_URL, $postData)
//	->setUser(API_KEY)->send();
//
//var_dump($response);

//$collection = \Anasceym\Billplz\Model\Collection::create(['title' => 'Anas Test']);
//var_dump($collection->id);

//$bill = new \Anasceym\Billplz\Model\Bill();
//$bill->collection_id = '_weno8vd';
//$bill->email = 'anasfirdauss@gmail.com';
//$bill->name = 'Anas Firdaus';
//$bill->amount = '500';
//$bill->callback_url = 'http://google.com';
//$bill->save();
//
//var_dump($bill->id);

$bill = \Anasceym\Billplz\Model\Bill::find('d6myaq343');
