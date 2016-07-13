<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class UpdateUserAddressReqFields
{
	const edit = array(
        /*fieldName=>array(mandatory, fieldType)*/
       	"address_id"    =>	array("mandatory"=>true, "type"=>"int")
       ,"user_number"	  =>	array("mandatory"=>true, "type"=>"int")
       ,"address_type"  =>	array("mandatory"=>true, "type"=>"int")
       ,"house_no"      =>	array("mandatory"=>false, "type"=>"house_no")
       ,"building_name" =>	array("mandatory"=>false, "type"=>"building_name")
       ,"street_name"   =>	array("mandatory"=>true, "type"=>"street_name")
       ,"pincode"       =>	array("mandatory"=>true, "type"=>"pincode")
    );

}

?>