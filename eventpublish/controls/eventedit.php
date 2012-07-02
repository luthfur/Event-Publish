<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "events";


// set the data container and grab the event it
$data = array();
$event_id = $_GET['id'];		

// setup all data objects
$GetEventData = new GetEventData($mdb2);
$AttachmentData = new AttachmentData($mdb2);

// grab event data
$EventResults =$GetEventData->getSingle($event_id);
$base_data = $EventResults->fetchRow(MDB2_FETCHMODE_ASSOC);
$data = array_merge($data, $base_data);



// setup the calendar id and schedule objects
$data['calendar_id'] = array();
$data['calendar_id'][] = $base_data['calendar_id'];


//##################### Setup ScheduleInfo, Date String and Calendar ###########################################################//
$ScheduleInfo = array();
$sch_id = array();
$sch_id[] = $base_data['schedule_id'];
$ScheduleInfo[] = new EventScheduleData($base_data, 1);

	
// set time spec
$data[no_time] = ($ScheduleInfo[0]->getTimeSpec() == 1) ? "off" : "on";

// create the date string
$counter = 1;
$StartDate = $ScheduleInfo[0]->getStartDate();
$StopDate = $ScheduleInfo[0]->getStopDate();
$date_string = "$counter," . $ScheduleInfo[0]->getType() . "," . $StartDate->getDay() . "," . $StartDate->getMonth() . "," . $StartDate->getYear() . ",";
$date_string .= $StopDate->getDay() . "," . $StopDate->getMonth() . "," . $StopDate->getYear() . ";";
	

while($row = $EventResults->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	// calendar setup
	if(!in_array($row['calendar_id'], $data['calendar_id'])) {
		$data['calendar_id'][] = $row['calendar_id'];
	}
	
	if(!in_array($row['schedule_id'], $sch_id)) {
		
		$ScheduleInfo[] = new EventScheduleData($row, 1);
		$sch_id[] = $row['schedule_id'];
		
		// create the date string
		$StartDate = $ScheduleInfo[$counter]->getStartDate();
		$StopDate = $ScheduleInfo[$counter]->getStopDate();
		$event_type = $ScheduleInfo[$counter]->getType();
		
		$counter++;
		$date_string .= "$counter," . $event_type . "," . $StartDate->getDay() . "," . $StartDate->getMonth() . "," . $StartDate->getYear() . ",";
		$date_string .= $StopDate->getDay() . "," . $StopDate->getMonth() . "," . $StopDate->getYear() . ";";
		
	}
	
}

// set date string and current id
$data[date_string] = $date_string;
$data[curr_date_id] = $counter + 1;



// ############################ Setup Time ################################################//

if($data[no_time] != "on") {

	$data[start_time] = $ScheduleInfo[0]->getStartDate()->format("g:i");
	$data[start_m] =  (($ScheduleInfo[0]->getStartDate()->format("a") == "am") ? 0 : 1 );
	
	$data[stop_time] = $ScheduleInfo[0]->getStopDate()->format("g:i");
	$data[stop_m] =  (($ScheduleInfo[0]->getStopDate()->format("a") == "am") ? 0 : 1 );

}



// ############################ Setup Attachments ################################################//
$att = array();

$ResultSet = $AttachmentData->getEventAttachment($event_id);
	
while($att_data = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
	$att[] = $att_data[attachment_id];
		
}
$data['attachment_ids'] = implode(",", $att);


/************ main page variables *******************************/

$Smarty->assign('method', "update");
$Smarty->assign('post_back', $data);
$Smarty->assign('ScheduleInfo', $ScheduleInfo);
$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);
/****************************************************************/


// display the event form
include 'common/showeventform.' . PHP_EXT;


?>