<?php

include 'common.php';


$error = array();

$db_hostname = trim($_POST['db_hostname']);
$db_username = trim($_POST['db_username']);
$db_password = trim($_POST['db_password']);
$db_name = trim($_POST['db_name']);

$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$confirm_password = trim($_POST['confirm_password']);

// validate data
if($db_hostname == "") $error['dbinfo'] = 1;
if($db_username == "") $error['dbinfo'] = 1;



if(!check_mail($email)) {
	$error['email'] = 1;
	$error['accounts'] = 1;
}

if($username == "") {
	$error['username'] = 1;
	$error['accounts'] = 1;
}

if($password == "") {
	$error['password'] = 1;
	$error['accounts'] = 1;
	}
	
if($confirm_password == "") {
	$error['confirm_password'] = 1;
	$error['accounts'] = 1;
} else if($confirm_password != $password) {
	$error['password_compare'] = 1;
	$error['accounts'] = 1;
}



$dsn = array(
    'phptype'  => 'mysql',
    'username' => $db_username,
    'password' => $db_password,
    'hostspec' => $db_hostname,
	'database' => $db_name
);


$options = array(
    'debug'       => 2,
    'portability' => MDB2_PORTABILITY_ALL,
);

// check db connectivity
$mdb2 = MDB2::connect($dsn, $options);

if (PEAR::isError($mdb2)) {
   	if($mdb2->getMessage() == "MDB2 Error: connect failed") {
		$error["db_connection"] = 1;
	
	} else if($mdb2->getMessage() == "MDB2 Error: no such database") {
		$error["db_selection"] = 1;
		
	} 

} else if($db_name == "") {
	$error["db_name"] = 1;
}



// error check
if(count($error) != 0) {
		
	$Smarty->assign('error', $error);
	$Smarty->assign('post_back', $_POST);
	
	// display form with error
	$Smarty->display("header.tpl");
	$Smarty->display("form.tpl");	
	$Smarty->display("footer.tpl");
	
} else {
	
	/************ Write to Config File ****************************/
	$fp = fopen(ROOT_DIR . "dbconfig.php", "w");
	
	$dump ="<?php
		
		/***************************************************
		dbconfig.php
		
		Table constant definitions and database connection
		settings.
		
		****************************************************/
		
		
		\$dsn = array(
			'phptype'  => 'mysql',
			'username' => '$db_username',
			'password' => '$db_password',
			'hostspec' => '$db_hostname',
			'database' => '$db_name'
		);
		
		\$options = array(
			'debug'       => 2,
			'portability' => MDB2_PORTABILITY_ALL,
		);
		
		define(\"ACCOUNT_TABLE\", \"epub_account\");
		define(\"USER_TABLE\", \"epub_user\");
		define(\"CALENDAR_TABLE\", \"epub_calendar\");
		define(\"CATEGORY_TABLE\", \"epub_category\");
		define(\"EVENT_TABLE\", \"epub_event\");
		define(\"CONTACT_TABLE\", \"epub_contact\");
		define(\"LOCATION_TABLE\", \"epub_location\");
		define(\"ATTACHMENT_TABLE\", \"epub_attachment\");
		define(\"SCHEDULE_TABLE\", \"epub_schedule\");
				
		define(\"EVCALENDAR_TABLE\", \"epub_eventcalendar\");
		define(\"EVCONTACT_TABLE\", \"epub_eventcontact\");
		define(\"EVTAG_TABLE\", \"epub_eventtag\");
		define(\"EVSCHEDULE_TABLE\", \"epub_eventschedule\");
		define(\"EVUSER_TABLE\", \"epub_eventuser\");	
		define(\"EVLOCATION_TABLE\", \"epub_eventlocation\");
		define(\"LOCUSER_TABLE\", \"epub_locationuser\");
		define(\"TIMEZONE_TABLE\", \"epub_timezone\");
		define(\"SETTINGS_TABLE\", \"epub_settings\");
		//define('USER_TIMEZONE', 2);
		
		?>";
	
	fwrite($fp, $dump);
	
	/***************************************************************/
	
	
	
	
	/************ Create Database Table ****************************/
	include(ROOT_DIR . 'dbconfig.php');
	include('tables.php');
	
	// Create tables
	while(list($ind, $val) = each($sql)) {
		
		$mdb2->exec($val);
		
	}
	/***************************************************************/
	
	
	
	
	/************ Create Administrator Table *************************/
	$AccountData = new AccountData($mdb2);
	
	// Add Account Info to Database
	$data = array("account_id" => 1,
					"user_id" => 1,
					"user_name" => $username, 
					"password" => $password, 
					"user_full_name" => $full_name, 
					"user_email" => $email, 
					"account_type" => ACCOUNT_ADMIN, 
					"account_date_set"=> time(), 		
					"account_active"=> 1,
					"account_timezone"=> 0,
					"account_perpage"=> 10);
	

	$User = new SystemUser($data);	
	$AccountData->add($User);
	/***************************************************************/
	
	
	
	
	/***************** Populate the defaults ***********************/
	include('defaults.php');
	
	// Create tables
	while(list($ind, $val) = each($defaults)) {
		
		$mdb2->exec($val);
		
	}
	
	
	/***************************************************************/
	
	
	/************************** Grab URL **********************************************/

	$current_path = $_SERVER['PHP_SELF'];
	$path_array = explode("/", $_SERVER['PHP_SELF']);
	$new_path = "";
	
	for($i=1; $i<count($path_array) - 2; $i++) {
		$new_path .= "/" . $path_array[$i];
	}
	
	$url = "http://" . $_SERVER['SERVER_NAME'] . $new_path;
	
	/**********************************************************************************/

	$Smarty->assign('url', $url);
	
	
	
	// forward to final page
	$Smarty->display("header.tpl");
	$Smarty->display("complete.tpl");	
	$Smarty->display("footer.tpl");
}




?>