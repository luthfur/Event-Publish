<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "dashboard";
$Smarty->assign('control_location', $control_location);

/************ main page variables *******************************/

$Smarty->assign('today_date', $today_date);

/****************************************************************/


/****************** Get Todays Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id, $user_id);
$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getDay($this_day, $this_month, $this_year);

$DaySchedule =  new DaySchedule($this_day, $this_month, $this_year,  $weekend, $timezone, $ScheduleData);

$Items = $DaySchedule->getItems();
$TimedItems = array();
	
while(list($ind, $val) = each($Items)) {
	
	if($val->getStartTime()->compareDate($DaySchedule->getDate()) == 0 ) $TimedItems[] = $val;
	
}


$EventList = array_merge($DaySchedule->getNoTimeItems(), $TimedItems);


/************************************************************************/




/********** Create Filters for draft events *********************************************/

$EventFilter = new EventFilter();

$EventFilter->setTimeZone($timezone);
$EventFilter->setPublished(0);
$EventFilter->setUserId($user_id);

$order_by = EVENT_TABLE . ".event_title";
$order = "ASC";

$GetEventData = new GetEventData($mdb2);

$DraftEventList = $GetEventData->getList($EventFilter, 2, $order_by, $order);

$draft_total = count($DraftEventList);

/*****************************************************************************************/




/********** Create Filters for all published events *********************************************/

$EventFilter = new EventFilter();

$EventFilter->setTimeZone($timezone);
$EventFilter->setPublished(1);

$order_by = EVENT_TABLE . ".event_title";
$order = "ASC";

$GetEventData = new GetEventData($mdb2);

$PublishEventList = $GetEventData->getList($EventFilter, 2, $order_by, $order);

$published_total = count($PublishEventList);

/*****************************************************************************************/


$Smarty->assign('EventList', $EventList);
$Smarty->assign('DraftEventList', $DraftEventList);

$Smarty->assign('draft_count', count($DraftEventList));
$Smarty->assign('today_event_count', count($EventList));

$Smarty->assign('draft_total', $draft_total);
$Smarty->assign('published_total', $published_total);

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');
$Smarty->display('nav.tpl');
$Smarty->display('dashboard.tpl');
$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');



?>