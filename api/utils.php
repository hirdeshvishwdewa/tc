<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

require_once 'dbBasic.php';
require 'validation.php';
class Utils extends DBBasic
{
	public function getJSONResponse($responseData = array(), $error = false, $errorCode = 0){
        $response = array();
        $response["error"] = $error;
        $response["errorCode"] = $errorCode;

        if(!empty($responseData)){
            $response["responseData"] = $responseData;
        }
        return json_encode($response);
    }
    
    /**
     * Verifying required params posted or not
     */
    public function verifyRequiredParams($requiredFields = array(), $requestData = array()) {
        $error_fields = array();

        if(count(array_diff_key($requiredFields, $requestData)) === count($requiredFields)){
            $keys = array_keys($requestData);
            return array(implode(',', $keys) => 'unwanted filters, no correct filter found!');
        }
        
        foreach ($requiredFields as $field=>$attr) {
            //check if the field is empty but was mandatory
            if(empty(trim($requestData[$field]))){
                if($attr['mandatory'] === true)
                    $error_fields[$field] = 'required';
            }else if(!Validations::validate($attr['type'], trim($requestData[$field]))){
                //server side validation of the field value type
                $error_fields[$field] = 'type';
            }
        }
        return empty($error_fields) ? null : $error_fields;
    }
}
