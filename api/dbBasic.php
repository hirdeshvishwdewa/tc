<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

require_once 'vendor/catfan/medoo/medoo.php';
require 'dbConfig.php';

class DBBasic {
	private $db;
	public function __construct($credentials = null){
		$this->db = $credentials === null ? DBConfig::properties : $credentials;
	}

	/**********************************CREATE FUNCTIONS*******************************************/
	public function createUser($userData = array(), $returnInsertID = false, $debug = false){
		$userExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
		$userData = array_merge($userData, $userExtras);
        return $this->insert('users', $userData, $returnInsertID, $debug);
    }

    public function createTC($TCData = array(), $returnInsertID = false, $debug = false){
		$TCExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
		$TCData = array_merge($TCData, $TCExtras);
		return $this->insert('tc_master', $TCData, $returnInsertID, $debug);
    }

    public function addReview($reviewData = array(), $returnInsertID = false){
        $reviewExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
        $reviewData = array_merge($reviewData, $reviewExtras);
        return $this->insert('tc_reviews', $reviewData, $returnInsertID);
    }

    public function addArea($areaData = array(), $returnInsertID = false){
        $areaExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
        $areaData = array_merge($areaData, $areaExtras);
        return $this->insert('areas', $areaData, $returnInsertID);
    }

    public function addAreaToTC($data = array(), $returnInsertID = false){
        $extras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
        $areaData = array_merge($data, $extras);
        return $this->insert('tc_area_map', $areaData, $returnInsertID);
    }

    public function createUserWallet($userNumber, $returnInsertID = false){
    	$data = array('user_number'=>$userNumber, '#last_modified'=>'NOW()');
        return $this->insert('user_wallet', $data, $returnInsertID);
    }

    public function createAddress($userNumber, $returnInsertID = false){
        
    }

    /**********************************UPDATE FUNCTIONS*******************************************/

    public function updateUserDetails($userData, $debug = false){
        $userNumber = $userData['user_number'];
        unset($userData['user_number']);
        $data = array();
        $data['tableName']  = "user_details";
        $data['data']       = $userData;
        $data['where']      = array('user_number[=]' => $userNumber);
        return $this->update($data, $debug);
    }

	/**********************************SELECT FUNCTIONS*******************************************/
    public function getUser($options = array(), $debug = false){
        //Give specific user
        $medoo = new medoo($this->db);
        $select = array(
        				"user_details.title"
        				, "user_details.first_name"
        				, "user_details.middle_name"
        				, "user_details.last_name"
        				, "users.user_number"
        				, "users.username"
        				, "users.email"
        				, "user_genders.gender_name(gender)"
                        , "user_wallet.balance"
        			);

        $join = array(
        			   "[>]user_details" => "user_number"
                       ,"[>]user_genders" => array("user_details.gender_id"=>"gender_id")
                       ,"[>]user_wallet" => "user_number"
        			);

        /*If userNumber = null then we will return list of latest users*/
        if($options['userNumber'] !== null)
            $where["OR"] = array('user_number[=]'=>$options['userNumber']);
        
        if($options['limit'] !== null){
        	$where["LIMIT"] = $options['limit'];
        }
        if($options['offset'] !== null)
        	$where["OFFSET"] = $options['offset'];

        if($options['order'] !== null)
        	$where['ORDER'] = "users.user_number ".$options['order'];

        if($options['searchTerm'] !== null){
        	$where["OR"] = array(
                                    'users.username[~]' => $options['searchTerm']
                                    ,'users.email[~]'     => $options['searchTerm']
                                );
        }
        $data = array();
        $data['tableName']  = "users";
        $data['join']       = $join;
        $data['selectFields'] = $select;
        $data['where'] = $where;
        return $this->select($data, $debug);
    }

    public function getTC($options = array()){
        $medoo = new medoo($this->db);
        //$medoo->debug();
        
        $select = array(
                        "tc_master.tc_name"
                        ,"tc_master.tc_id"
                        , "tc_master.short_desc"
                        , "tc_master.long_desc"
                        , "tc_master.created_at"
                        , "tc_master.last_modified"
                    );

        /*If TCID = null then we will return list of latest TC*/
        if(isset($options['TCID']) && $options['TCID'] !== null)
            $where["tc_id[=]"] = $options['TCID'];
        
        if(isset($options['limit']) && $options['limit'] !== null)
            $where["LIMIT"] = $options['limit'];
        else
            $where["LIMIT"] = 10;

        if(isset($options['offset']) && $options['offset'] !== null)
            $where["OFFSET"] = $options['offset'];
        else
            $where["OFFSET"] = 0;

        if(isset($options['order']) && $options['order'] !== null)
            $where['ORDER'] = "tc_master.tc_id ".$options['order'];
        else
            $where['ORDER'] = "tc_master.tc_id DESC";

        if(isset($options['areaID']) && $options['areaID'] !== null){
            $data = array();
            $data['tableName']      = "tc_area_map";
            $data['selectFields']   = "tc_area_map.tc_id";
            $data['where']          = array("tc_area_map.area_id[=]" => $options['areaID']);
            $where['tc_master.tc_id[=]'] = $this->select($data);

        }else if(isset($options['cityID']) && $options['cityID'] !== null){
            $join['[>]tc_area_map'] = array("tc_area_map.area_id", "areas.area_id");
            $join['[>]areas'] = "area_id";
            $join['[>]cities'] = array("cities.city_id", "areas.city_id");
        }
        
        if(isset($options['searchTerm']) && $options['searchTerm'] !== null){
            $where["OR"] = array('tc_master.tc_name[~]' => $options['searchTerm']);
        }

        $data = array();
        $data['tableName']  = "tc_master";
        $data['join']       = $join;
        $data['selectFields'] = $select;
        $data['where'] = $where;
        return $this->select($data);
    }

    private function insert($tableName, $data, $returnInsertID = false, $debug = false){
        $medoo = new medoo($this->db);
        if($debug)  $medoo->debug();
        $id = $medoo->insert($tableName, $data);
        return $id > 0 ? $returnInsertID === true ? $id : true : false;
    }

    private function select($data, $debug){
        $medoo = new medoo($this->db);
        if($debug)  $medoo->debug();
        return isset($data['join']) 
                ?
                $medoo->select($data['tableName'], $data['join'], $data['selectFields'], $data['where'])
                :
                $medoo->select($data['tableName'], $data['selectFields'], $data['where'])
                ;
    }

    private function update($data, $debug){
        $medoo = new medoo($this->db);
        if($debug)  $medoo->debug();
        //var_dump($medoo->update($data['tableName'], $data['data'], $data['where']));
        return  $medoo->update($data['tableName'], $data['data'], $data['where']) >= 1;
    }

}


// $obj = new DBBasic(null);
// var_dump($obj->getUser("21"));
