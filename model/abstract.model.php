<?php

namespace Model;

use Lib\Secure;

abstract class AbstractModel {
	protected $data = array();
	protected $errors = array();

	function __construct($data = NULL){
		if($data)
			$this->data = $data;		
	}

	public function setData($data){
    	$this->data = $data;

    	//secure id values which are supposed to be only int
    	foreach ($this->data as $key => $value) {
    		if($key == "id" || "owner")
    			$this->data[$key] = Secure::forceInt($value);
    	}
	}
}
?>