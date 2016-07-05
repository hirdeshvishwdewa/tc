<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class GetTCReqFields
{
	const arr = array(
        /*fieldName=>array(mandatory, fieldType)*/
        "TCID"		=>	array("mandatory"=>false, "type"=>"int")
       ,"areaID"	=>	array("mandatory"=>true, "type"=>"int")
       ,"cityID"	=>	array("mandatory"=>false, "type"=>"int")
       ,"order"		=>	array("mandatory"=>false, "type"=>"order")
       ,"limit"		=>	array("mandatory"=>false, "type"=>"int")
       ,"searchTerm"=>	array("mandatory"=>false, "type"=>"searchTerm")
    );

}
?>