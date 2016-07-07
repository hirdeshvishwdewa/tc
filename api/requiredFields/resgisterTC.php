<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class RegisterTCReqFields
{
	const add = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "user_number"	=>array("mandatory"=>true, "type"=>"int") 
    	,"tc_name"		=>array("mandatory"=>true, "type"=>"tc_name")
    	,"short_desc"	=>array("mandatory"=>true, "type"=>"tc_short_desc")
    );

}
?>