<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

require 'validationRegEx.php';

class Validations {
	
	public static function validate($fieldType, $fieldValue){

		$validationRegEx = ValidationRegEx::regEx[$fieldType];
		return 
			$validationRegEx !== null
				?
			preg_match($validationRegEx, $fieldValue) === 1
				:
			self::customFilter($fieldType, $fieldValue)
				;
	}

	private function customFilter($fieldType, $fieldValue){
		$return = false;
		switch ($fieldType) {
			case 'email':
				$return = filter_var($fieldValue, FILTER_VALIDATE_EMAIL) == $fieldValue;
				break;
			case 'int':
				$return = filter_var($fieldValue, FILTER_VALIDATE_INT) == $fieldValue;
				break;
			case 'boolean':
				$return = filter_var($fieldValue, FILTER_VALIDATE_BOOLEAN) == $fieldValue;
				break;
			default:
				$return = filter_var($fieldValue, FILTER_CALLBACK, array('options'=> 'self::typeNotFoundCallback')) == $fieldValue;
				break;
		}
		return $return;
	}

	private function typeNotFoundCallback(){
		return false;
	}
}