<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class RegisterUserReqFields
{
	const add = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "username"		=>array("mandatory"=>true, "type"=>"username") 
       ,"password"		=>array("mandatory"=>true, "type"=>"password")
       ,"email"			=>array("mandatory"=>true, "type"=>"email")
    );

}
?>