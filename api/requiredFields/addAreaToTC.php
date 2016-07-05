<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class AddAreaToTCReqFields
{
	const arr = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "tc_id"		=>	array("mandatory"=>true, "type"=>"int")
       ,"area_id"	=>	array("mandatory"=>true, "type"=>"int")
    );

}

?>