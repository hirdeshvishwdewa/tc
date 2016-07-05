<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class GetUserReqFields
{
	const arr = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "userNumber"	=>	array("mandatory"=>	false, 	"type"=>"int")
       ,"order"			=>	array("mandatory"=>	false, 	"type"=>"order")
       ,"limit"			=>	array("mandatory"=>	false, 	"type"=>"int")
       ,"offset"		=>	array("mandatory"=>	false, 	"type"=>"int")
       ,"searchTerm"	=>	array("mandatory"=>	false, 	"type"=>"searchTerm")
    );

}
?>