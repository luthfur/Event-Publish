<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Delete Category ###########################################



$CategoryData = new CategoryData($mdb2);
$CalendarData = new CalendarData($mdb2);
$AttData = new AttachmentData($mdb2);
$ScheduleDbData = new ScheduleDbData($mdb2);
$EventData = new EventData($mdb2);

/*********************** Execute Query ***********************/

$resCalendar = $CalendarData->getList($_POST[cat_id]);

// Delete all calendars in the category
while ($calendar_data = $resCalendar->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
	// Delete all events in the category
	$resEvent = $CalendarData->getEvents($calendar_data[calendar_id]);
	
	while ($event_data = $resEvent->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
		$AttData->removeAttachments($event_data[event_id]);
		$ScheduleDbData->deleteByEvent($event_data[event_id]);
		$EventData->delete($event_data[event_id]);
		
	}
	
	$res = $CalendarData->delete($calendar_data[calendar_id]);
}

$res = $CategoryData->delete($_POST[cat_id]);

if (PEAR::isError($res)) {
	echo 0;
}

/*************************************************************/



//################################################################################################

echo $_POST[cat_id];

?>