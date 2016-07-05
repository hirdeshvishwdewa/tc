<?php

defined("__ACCESS__") or die ("Direct Access Not Allowed !");

class DBConfig {
	
	const properties = 
	array('database_type' => 'mysql',
    'database_name' => 'tc',
    'server' => 'localhost',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8'
    );
}