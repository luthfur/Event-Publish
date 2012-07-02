<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_EVENT_DATA = $_POST;
/****************************************************/
		
$EventData = new EventData($mdb2);
$EventData->setPublished($_EVENT_DATA[published], $_EVENT_DATA[event_id]);
	
?><?php echo $_EVENT_DATA[published] ?>