<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Add New Calendar ###########################################



$CalendarData = new CalendarData($mdb2);
$AttData = new AttachmentData($mdb2);
$ScheduleDbData = new ScheduleDbData($mdb2);
$EventData = new EventData($mdb2);


/*********************** Execute Query ***********************/
$res = $CalendarData->delete($_POST[calendar_id]);

if (PEAR::isError($res)) {
	echo 0;
}

// Delete all events in the calendar
$resEvent = $CalendarData->getEvents($_POST[calendar_id]);

while ($event_data = $resEvent->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
	$AttData->removeAttachments($event_data[event_id]);
	$ScheduleDbData->deleteByEvent($event_data[event_id]);
	$EventData->delete($event_data[event_id]);
	
}


/*************************************************************/



//################################################################################################


// Return true on success
echo $_POST[calendar_id];


?>