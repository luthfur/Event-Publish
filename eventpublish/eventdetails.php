<?php 

/**********************************************************************
eventdetails.php

Event Details Display

***********************************************************************/



// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);


/****************** Get Event ID ***************************************/
$event_id = $_GET['eid'];

if(isset($event_id)) settype($event_id, "integer");
if($event_id == 0) exit;



/****************** Get Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id);
if($location_id) $EventScheduleQuery->setLocation($location_id);
$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getDay($day, $month, $year);
$SidebarData = $EventSchedule->getMonth($month, $year);

/************************************************************************/


/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('enable_sidebar', "true");
$Smarty->assign('show_sidebar', "true");
$Smarty->assign('show_minical', "true");
$Smarty->assign('curr_view', "day");
$Smarty->assign('view_event_override', 1);
$Smarty->assign('default_view', $default_view);
/****************************************************************/



/**************** Setup Week Grid ***************************/
$start_week = $start_day;
$week_abbr = array();

while(list($ind, $val) = each($_WEEK)) {
	$week_abbr[$ind] = $_WEEK_ABBR[$start_week];
	$start_week = ($start_week + 1) % 7; 	
}
/***************************************************************/


/*********************** Include Side Bar ****************************/
include 'sidebar.' . PHP_EXT;
/********************************************************************/



/************* Setup the event details data ************************************/
$GetEventData = new GetEventData($mdb2);
$AttachmentData = new AttachmentData($mdb2);

// fetch event data
$EventResults = $GetEventData->getSingle($event_id);
$base_data = $EventResults->fetchRow(MDB2_FETCHMODE_ASSOC);

// set data objects
$Event = new Event($base_data);
$Location = new Location($base_data);
$Contact = new Contact($base_data);


// set calendar and schedule objects
$Calendars = array();
$cal_id = array();
$cal_id[] = $base_data['calendar_id'];
$Calendars[] = new Calendar($base_data);

$ScheduleInfo = array();
$sch_id = array();
$sch_id[] = $base_data['schedule_id'];
$ScheduleInfo[] = new EventScheduleData($base_data, 1, $timezone);


while($data = $EventResults->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	if(!in_array($data['calendar_id'], $cal_id)) {
		$Calendars[] = new Calendar($data);
		$cal_id[] = $data['calendar_id'];
	}
	
	if(!in_array($data['schedule_id'], $sch_id)) {
		$ScheduleInfo[] = new EventScheduleData($data, 1, $timezone);
		$sch_id[] = $data['schedule_id'];
	}
	
}


// set attachment data
$Attachments = array();

$ResultSet = $AttachmentData->getEventAttachment($Event->getId(), 1);
	
while($data = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
	$Attachments[] = new Attachment($data);
		
}



// Setup Date

$EventDate = new SC_DateTime($day, $month, $year);


if(DATE_FORMAT == 0) {
	$format = "l, F jS Y";
} else if (DATE_FORMAT == 1) {
	$format = "l, jS F Y";
} else if (DATE_FORMAT == 2) {
	$format = "l, Y-m-d";
}
$Smarty->assign('event_date', $EventDate->format($format));




			
// setup time
if ($ScheduleInfo[0]->getTimeSpec() == 1) {
			
			date_default_timezone_set("GMT");
			
			$EventStartDate = new SC_DateTime($day, $month, $year,$ScheduleInfo[0]->getStartDate()->getHour(), $ScheduleInfo[0]->getStartDate()->getMinute());
			$EventStopDate = new SC_DateTime($day, $month, $year, $ScheduleInfo[0]->getStopDate()->getHour(), $ScheduleInfo[0]->getStopDate()->getMinute());
			
			date_default_timezone_set(SYS_TIME_ZONE);
			
			$EventStartTime = new SC_DateTime(0,0,0,0,0,0,$EventStartDate->getTimeStamp());
			$EventStopTime = new SC_DateTime(0,0,0,0,0,0,$EventStopDate->getTimeStamp());
						
			$event_time  = $EventStartTime->format("g:i a") . " to " . $EventStopTime->format("g:i a");
} else {
			$event_time  = $Event->getTextTime() ;
	}
		
$Smarty->assign('event_time', $event_time);

$Smarty->assign('Event', $Event);
$Smarty->assign('Location', $Location);
//$Smarty->assign('Calendars', $Calendars);
$Smarty->assign('Contact', $Contact);
$Smarty->assign('ScheduleInfo', $ScheduleInfo);
$Smarty->assign('Attachments', $Attachments);
if($Event->getTags()) $Smarty->assign('tags', explode("," , $Event->getTags()));
$Smarty->assign('att_count',  count($Attachments));
$Smarty->assign('schedule_count', count($ScheduleInfo));
$Smarty->assign('att_dir', $att_dir);

/*******************************************************************/





//************ Display *********************************//

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

// event details display
$Smarty->display('event_details.tpl');

// sidebar display
$Smarty->display('sidebar.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

//*******************************************************//

?>