<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class AddReviewReqFields
{
	const add = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "tc_id"			=>	array("mandatory"=>true, "type"=>"int")
       ,"user_number"	=>	array("mandatory"=>true, "type"=>"int")
       ,"review_title"	=>	array("mandatory"=>false, "type"=>"review_title")
       ,"rating"		=>	array("mandatory"=>false, "type"=>"int")
       ,"review_desc"	=>	array("mandatory"=>false, "type"=>"review_desc")
    );

}
?>