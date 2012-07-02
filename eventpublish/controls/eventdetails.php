<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);
require_once('common.' . PHP_EXT);

//section specific variables
$control_location = "events";



/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);

/****************************************************************/



/*****************************************************************/
$event_id = intval($_GET['id']);

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

$ResultSet = $AttachmentData->getEventAttachment($Event->getId());
	
while($data = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
	$Attachments[] = new Attachment($data);
		
}



	// set event time data
	if ($ScheduleInfo[0]->getTimeSpec() == 1) {
						
			$StartDate = $ScheduleInfo[0]->getStartDate();
			$StopDate = $ScheduleInfo[0]->getStopDate();
						
			$event_time  = $StartDate->format("g:i a") . " to " . $StopDate->format("g:i a");
	} else {
			$event_time  = $Event->getTextTime() ;
	}



$Smarty->assign('Event', $Event);
$Smarty->assign('Location', $Location);
$Smarty->assign('Calendars', $Calendars);
$Smarty->assign('Contact', $Contact);
$Smarty->assign('ScheduleInfo', $ScheduleInfo);
$Smarty->assign('Attachments', $Attachments);
if($Event->getTags()) $Smarty->assign('tags', explode("," , $Event->getTags()));
$Smarty->assign('att_count',  count($Attachments));
$Smarty->assign('schedule_count', count($ScheduleInfo));
$Smarty->assign('att_dir', $att_dir);
$Smarty->assign('event_time', $event_time);
/*******************************************************************/



$Smarty->display('page_header.tpl');

$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('event_details.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');


?>