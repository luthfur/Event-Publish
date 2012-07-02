<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_EVENT_DATA = $_POST;
/****************************************************/
	
		
$EventData = new EventData($mdb2);
$EventData->setCancelled(1, $_EVENT_DATA[event_id]);
	

?>1