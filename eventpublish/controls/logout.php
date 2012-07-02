<?php

define(ROOT_DIR, "../");

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once(ROOT_DIR . 'main.' . PHP_EXT);

$template = "new";



/************* Log user out ***************************/
	$Session = new Session();
		
	$Session->destroy();
	
	//echo $account_id;
	
	header("Location: login.php");
	

/**********************************************************/





?>
