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
    public function userAlreadyExists($user, $debug = false){
        $medoo = new medoo($this->db);
        if($debug)  $medoo->debug();
        $where = array('OR'=>array('email[=]'=>$user['email'], 'username[=]'=>$user['username']));
        return $medoo->count('users', $where) > 0;
    }
    public function initUserDetails($userNumber, $returnInsertID = false, $debug = false){
        $userData = array();
        $userData['user_number'] = $userNumber;
        return $this->insert('user_details', $userData, $returnInsertID, $debug);
    }
    public function createTC($TCData = array(), $returnInsertID = false, $debug = false){
		$TCExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
		$TCData = array_merge($TCData, $TCExtras);
		return $this->insert('tc_master', $TCData, $returnInsertID, $debug);
    }

    public function addReview($reviewData = array(), $returnInsertID = false, $debug = false){
        $reviewExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
        $reviewData = array_merge($reviewData, $reviewExtras);
        return $this->insert('tc_reviews', $reviewData, $returnInsertID, $debug);
    }

    public function addArea($areaData = array(), $returnInsertID = false, $debug = false){
        $areaExtras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
        $areaData = array_merge($areaData, $areaExtras);
        return $this->insert('areas', $areaData, $returnInsertID, $debug);
    }

    public function addAreaToTC($data = array(), $returnInsertID = false, $debug = false){
        $extras = array("#created_at"=>"NOW()", "#last_modified"=>"NOW()");
        $areaData = array_merge($data, $extras);
        return $this->insert('tc_area_map', $areaData, $returnInsertID, $debug);
    }

    public function createUserWallet($userNumber, $returnInsertID = false, $debug = false){
    	$data = array('user_number'=>$userNumber, '#last_modified'=>'NOW()');
        return $this->insert('user_wallet', $data, $returnInsertID, $debug);
    }

    public function createAddress($userNumber, $returnInsertID = false, $debug = false){
        
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
    
    public function updateUserAddress($addressData, $debug = false){
        $addressID = $addressData['address_id'];
        $data = array();
        $data['tableName']  = "user_addresses";
        $data['data']       = $addressData;
        return $this->replaceinto($data, $debug);
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

        /*If userNumber = null then we will check for other options*/
        if($options['userNumber'] !== null)
            $where["OR"] = array('user_number[=]'=>$options['userNumber']);
        
        if($options['order'] !== null){
        	$where['ORDER'] = "users.user_number ".$options['order'];
            $where["LIMIT"] = 10;
            $where["OFFSET"]= 0;
        }

        if($options['limit'] !== null)
            $where["LIMIT"] = $options['limit'];
        
        if($options['offset'] !== null)
            $where["OFFSET"] = $options['offset'];

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

    public function getTC($options = array(), $debug = false){
        $medoo = new medoo($this->db);

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
            $where['tc_master.tc_id[=]'] = $this->select($data, $debug);

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
        return $this->select($data, $debug);
    }

    private function insert($tableName, $data, $returnInsertID = false, $debug = false){
        $medoo = new medoo($this->db);
        if($debug)  $medoo->debug();
        $id = $medoo->insert($tableName, $data);
        return $id > 0 ? $returnInsertID === true ? $id : true : false;
    }

    private function replaceinto($data, $debug = false){
        $medoo = new medoo($this->db);
        if($debug)  $medoo->debug();
        return $medoo->replaceinto($data['tableName'], $data['data']);
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
        return  $medoo->update($data['tableName'], $data['data'], $data['where'], true);
    }

}


// $obj = new DBBasic(null);
// var_dump($obj->getUser("21"));
