<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class UpdateUserDetailsReqFields
{
	const edit = array(
        /*fieldName=>array(mandatory, fieldType)*/
       	"user_number"   =>	array("mandatory"=>true, "type"=>"int")
       ,"mobile_number"	=>	array("mandatory"=>true, "type"=>"mobile_number")
       ,"title"			    =>	array("mandatory"=>true, "type"=>"int")
       ,"first_name"	  =>	array("mandatory"=>true, "type"=>"name")
       ,"middle_name"   =>	array("mandatory"=>false, "type"=>"name")
       ,"last_name"     =>	array("mandatory"=>true, "type"=>"name")
       ,"gender_id"     =>	array("mandatory"=>false, "type"=>"int")
    );

}

?>