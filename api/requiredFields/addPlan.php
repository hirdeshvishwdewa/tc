<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class AddPlanReqFields
{
	const add = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "city_id"		=>	array("mandatory"=>true, "type"=>"int")
       ,"area_name"		=>	array("mandatory"=>true, "type"=>"area_name")
    );

}

?>