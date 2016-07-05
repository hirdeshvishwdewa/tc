<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

require_once 'api/utils.php';

/****************************************Functions*****************************************/
/**
 * Function will be responsible for regisering a user.
 * @param  array  $user This is the array of fields which will be stored in users DB table.
 * @return json   A json string which contains the response string, which will be sent to client.
 */
function registerUser($user = array()){
    require_once 'api/requiredFields/registerUser.php';
    $u = new Utils();
    
    if (!empty($user)) {
        $errorArr = $u->verifyRequiredParams(RegisterUserReqFields::arr, $user);
        if(!empty($errorArr)){
            return $u->getJSONResponse($errorArr, true, 1);
        }else {
            $userNumber = $u->createUser($user, true);
            if($userNumber){
                if(!$u->createUserWallet($userNumber)){
                    return $u->getJSONResponse(null, true, 2);
                }
                return $u->getJSONResponse();
            }
                return $u->getJSONResponse(null, true, 2);
        }
    }
    return $u->getJSONResponse(null, true, 3);
}
/**
 * Function will be responsible for regisering a TC.
 * @param  array  $TCData This is the array of fields which will be stored in tc_master DB table.
 * @return json   A json string which contains the response string, which will be sent to client.
 */
function resgisterTC($TCData = array()){
    require_once 'api/requiredFields/resgisterTC.php';
    $u = new Utils();
    
    if (!empty($TCData)) {
        $errorArr = $u->verifyRequiredParams(RegisterTCReqFields::arr, $TCData);
        if(!empty($errorArr)){
            return $u->getJSONResponse($errorArr, true, 7);
        }else if(!$u->createTC($TCData)){
            return $u->getJSONResponse(null, true, 8);
        }else{
            return $u->getJSONResponse();
        }
    }
    return $u->getJSONResponse(null, true, 6);
    
}

/**
 * Function will be responsible for adding row in the review table.
 * @param  array  $reviewData This is the array of fields which will be stored in review DB table.
 * @return json   A json string which contains the response string, which will be sent to client.
 */
function addReview($reviewData = array()){
    require_once 'api/requiredFields/addReview.php';
    $u = new Utils();
    if (!empty($reviewData)) {
        $errorArr = $u->verifyRequiredParams(AddReviewReqFields::arr, $reviewData);
        if(!empty($errorArr)){
            return $u->getJSONResponse($errorArr, true, 13);
        }else if(!$u->addReview($reviewData)){
            return $u->getJSONResponse(null, true, 14);
        }else{
            return $u->getJSONResponse();
        }
    }
    return $u->getJSONResponse(null, true, 15);
}

/**
 * Function will be responsible for adding new area in areas table when (area_name, city_id) is 
 * passed, while when (tc_id, area_id) is passed it will create a map b/w tc and area.
 * When (area_name, city_id, tc_id) is passed it will create a new area as well as map it with 
 * the passed tc_id. 
 * When (area_name, city_id, tc_id, area_id) all four are passed, will add new 
 * area and map the given (tc_id, area_id).
 * @param  array  $areaData This is the array of fields which will be stored in review DB table.
 * @return json   A json string which contains the response string, which will be sent to client.
 */
function addArea($areaData = array()){
    require_once 'api/requiredFields/addArea.php';
    $u = new Utils();
    $areaID = $areaData['area_id'];
    $tcID = $areaData['tc_id'];
    if (!empty($areaData)){
        if(!empty($areaData['area_name']) || !empty($areaData['city_id'])){
            $errorArr = $u->verifyRequiredParams(AddAreaReqFields::arr, $areaData);
            if(!empty($errorArr)){
                return $u->getJSONResponse($errorArr, true, 16);
            }
            /*unset, bcoz when passed with these array elements it will give error in medoo insert*/
            unset($areaData['tc_id']);
            unset($areaData['area_id']);
            $areaIDNew = $u->addArea($areaData, isset($tcID));
        }
        
        $areaData['tc_id'] = $tcID;

        $areaID = $areaID === null ? $areaIDNew : $areaID;
        
        if(is_bool($areaID) && !$areaID)
            return $u->getJSONResponse(null, true, 17);

        else if(!empty($tcID) || !empty($areaID)){
            require_once 'api/requiredFields/addAreaToTC.php';
            $areaData['area_id'] = $areaID;
            $errorArr = $u->verifyRequiredParams(AddAreaToTCReqFields::arr, $areaData);
            if(!empty($errorArr))
                return $u->getJSONResponse($errorArr, true, 22);

            unset($areaData['area_name']);
            unset($areaData['city_id']);
            
            if(!$u->addAreaToTC($areaData))
                return $u->getJSONResponse($errorArr, true, 23);
        }
        return $u->getJSONResponse();
        
    }
    return $u->getJSONResponse(null, true, 18);
}

function addPlan($planData = array()){
    require_once 'api/requiredFields/addReview.php';
    $u = new Utils();
    if (!empty($planData)) {
        $errorArr = $u->verifyRequiredParams(AddPlanReqFields::arr, $planData);
        if(!empty($errorArr)){
            return $u->getJSONResponse($errorArr, true, 24);
        }else if(!$u->addReview($planData)){
            return $u->getJSONResponse(null, true, 25);
        }else{
            return $u->getJSONResponse();
        }
    }
    return $u->getJSONResponse(null, true, 26);
}


function updateUserDetails($userDetails = array()){
    
}

/**
 * This function will return the users depending upon the options.
 * $options will be a query sting contains filters for giving conditions.
 * @param  string $options its a ? (question mark) less query string.
 * @return json   contains the json encoded response (user data).
 */
function getUser($options = null){
    require_once 'api/requiredFields/getUser.php';
    $u = new Utils();
    $optionsArr = array();
    parse_str($options, $optionsArr);

    if(!empty($optionsArr)){
        $errorArr = $u->verifyRequiredParams(GetUserReqFields::arr, $optionsArr);
        if(!empty($errorArr))
            return $u->getJSONResponse($errorArr, true, 4);
    }
    $response = $u->getUser($optionsArr);    
    if(count($response) === 0)
        return $u->getJSONResponse(null, true, 5);
    else
        return $u->getJSONResponse($response);
}

/**
 * This function will return the TCs depending upon the options.
 * $options will be a query sting contains filters for giving conditions.
 * @param  string $options its a ? (question mark) less query string.
 * @return json   contains the json encoded response (TC data).
 */
function getTC($options = null){
    require_once 'api/requiredFields/getTC.php';
    $u = new Utils();
    $optionsArr = array();
    parse_str($options, $optionsArr);
    if($options !== null){
        $errorArr = $u->verifyRequiredParams(GetTCReqFields::arr, $optionsArr);
        if(!empty($errorArr))
            return $u->getJSONResponse($errorArr, true, 11);
    }
        $response = $u->getTC($optionsArr);    
    if(count($response) === 0)
        return $u->getJSONResponse(null, true, 12);
    else
        return $u->getJSONResponse($response);
}
