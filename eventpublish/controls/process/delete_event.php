<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_EVENT_DATA[event_id] = intval($_GET[event_id]);
/****************************************************/
		
$AttData = new AttachmentData($mdb2);
$AttData->removeAttachments($_EVENT_DATA[event_id]);

$ScheduleDbData = new ScheduleDbData($mdb2);
$ScheduleDbData->deleteByEvent($_EVENT_DATA[event_id]);

$EventData = new EventData($mdb2);
$EventData->delete($_EVENT_DATA[event_id]);

$redirect = "../eventlist.php";

$Smarty->assign('redirect', $redirect);

$Smarty->display('page_header.tpl');

$Smarty->display('delete_event_process.tpl');

$Smarty->display('redirect_footer.tpl');




?>