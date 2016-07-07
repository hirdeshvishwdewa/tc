<?php
	$DEBUG_MODE = false;

	if($DEBUG_MODE){
	    error_reporting();
	}else {
	    error_reporting(0);
	}

	$DEBUG_ARR = [
	    'settings' => [
	        'displayErrorDetails' => true
	    ]
	];

	function dump(){
		$args = func_get_args();
		foreach ($args as $value) {
			var_dump($value);
		}
	}
?>