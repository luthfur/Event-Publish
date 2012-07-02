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

$_EVENT_DATA = $_POST;


include 'process/validate_event.php';



//################################ Set Date and Time #########################################//
	$start_hour = 0;
	$stop_hour = 0;
	
	$start_min = 0;
	$stop_min =  0;
	
	 $sch_data['timespec'] = 0;
	 
	if($_EVENT_DATA[no_time] != "on") {
		
		$start_time_array = explode(":", $_EVENT_DATA[start_time]);
		$stop_time_array = explode(":", $_EVENT_DATA[stop_time]);
		
		$start_hour = $start_time_array[0];
		$start_min = $start_time_array[1];
		
		$stop_hour = $stop_time_array[0];
		$stop_min =  $stop_time_array[1];
		
		
		if($_EVENT_DATA[start_m] == 1 && $start_hour != 12) {
			$start_hour = ($start_hour + 12) % 24;		
		} else if ($_EVENT_DATA[start_m] == 0 && $start_hour == 12) {
			$start_hour = 0;
		}
		
		
		if($_EVENT_DATA[stop_m] == 1 && $stop_hour != 12) {
			$stop_hour = ($stop_hour + 12) % 24;		
		} else if ($_EVENT_DATA[stop_m] == 0 && $stop_hour == 12) {
			$stop_hour = 0;
		}
		
		$sch_data['timespec'] = 1;
	
	}
	
	
// ############## Parse the date string from client ###########################################//

	
$date_set = explode(";", $_EVENT_DATA[date_string]);

$ScheduleInfo = array();

for($i=0; $i<count($date_set) - 1; $i++) {
	
	$date_item = explode(",", $date_set[$i]);
	
	$start_day = $date_item[2];
	$start_month = $date_item[3];
	$start_year = $date_item[4];
	
	$stop_day = ($date_item[1] == 1) ? $start_day : $date_item[5];
	$stop_month = ($date_item[1] == 1) ? $start_month : $date_item[6];
	$stop_year = ($date_item[1] == 1) ? $start_year : $date_item[7];
	
	$sch_data[schedule_type] = $date_item[1];
	
	$StartDate = new SC_DateTime($start_day, $start_month, $start_year, $start_hour, $start_min);
	$StopDate = new SC_DateTime($stop_day, $stop_month, $stop_year, $stop_hour, $stop_min);
	
	$sch_data['start_date'] = $StartDate->getTimeStamp();
	$sch_data['stop_date'] = $StopDate->getTimeStamp();
	
	
	
	$ScheduleInfo[] = new EventScheduleData($sch_data);
	
	
}
	
//################################################################################################//	
	


if(in_array(true, $error)) {
	
	
	//############### Validation failed..redisplay form with error messages	###################//
		
	$Smarty->assign('ScheduleInfo', $ScheduleInfo);
	$Smarty->assign('post_back', $_EVENT_DATA);
	$Smarty->assign('error', $error);
	$Smarty->assign('method', "add");
	$Smarty->assign('main_path', "");		// used to point back to this process
	
	include 'common/showeventform.php';
	
	//###########################################################################################//
	
	
} else {

	
	$_EVENT_DATA = $_POST;
	
	// clear up inputs for display:
	$_EVENT_DATA[event_title] = clean_display($_EVENT_DATA[event_title]);
	$_EVENT_DATA[text_time] = clean_display($_EVENT_DATA[text_time]);
	$_EVENT_DATA[event_desc] = clean_display($_EVENT_DATA[event_desc]);
	$_EVENT_DATA[event_tags] = clean_display($_EVENT_DATA[event_tags]);
	
	$LocationData = new LocationData($mdb2);
	$CalendarData = new CalendarData($mdb2);
	$ContactData = new ContactData($mdb2);
	$ScheduleDbData = new ScheduleDbData($mdb2);
	$AttachmentData = new AttachmentData($mdb2);
	
	
	// set data objects
	$Event = new Event($_EVENT_DATA);
	
	if($_EVENT_DATA[location_id]) {
	
		$LocationResult = $LocationData->getSingle($_EVENT_DATA[location_id]);
		$Location = new Location($LocationResult->fetchRow(MDB2_FETCHMODE_ASSOC));
	
	}
	
	
	if($_EVENT_DATA[contact_id]) {
	
		$ContactResult = $ContactData->getSingle($_EVENT_DATA[contact_id]);
		$Contact = new Contact($ContactResult->fetchRow(MDB2_FETCHMODE_ASSOC));
	
	}
	
	$Calendars = array();
	if($_EVENT_DATA[calendar_id]) {
		
		while(list($ind, $val) = each($_EVENT_DATA[calendar_id])) {
		
			$CalendarResult = $CalendarData->getSingle($val);
			$Calendars[] = new Calendar($CalendarResult->fetchRow(MDB2_FETCHMODE_ASSOC));
		}
	
	}
	
	
	
	//################################ Set Date and Time #########################################//
	
	$start_hour = 0;
	$stop_hour = 0;
	
	$start_min = 0;
	$stop_min =  0;
		
	if($_EVENT_DATA[no_time] == 0) {
		
		$start_time_array = explode(":", $_EVENT_DATA[start_time]);
		$stop_time_array = explode(":", $_EVENT_DATA[stop_time]);
		
		$start_hour = $start_time_array[0];
		$start_min = $start_time_array[1];
		
		$stop_hour = $stop_time_array[0];
		$stop_min =  $stop_time_array[1];
		
		
		if($_EVENT_DATA[start_m] == 1 && $start_hour != 12) {
			$start_hour = ($start_hour + 12) % 24;		
		} else if ($_EVENT_DATA[start_m] == 0 && $start_hour == 12) {
			$start_hour = 0;
		}
		
		
		if($_EVENT_DATA[stop_m] == 1 && $stop_hour != 12) {
			$stop_hour = ($stop_hour + 12) % 24;		
		} else if ($_EVENT_DATA[stop_m] == 0 && $stop_hour == 12) {
			$stop_hour = 0;
		}
	
	
	}
				
		
	//###########################################################################################//
		
			
	
	// set attachment data
	$Attachments = array();
	$idset = explode(",", $_EVENT_DATA[attachment_ids]);
	
		if(count($idset) != 0 && $idset[0] != "") {
		
		$ResultSet = $AttachmentData->getList($idset);
			
		while($data = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
				
			$Attachments[] = new Attachment($data);
				
		}
	
	}
	
	$attachment_ids = explode(",", $file_ids);
	
	
	
	
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
	$Smarty->assign('post_back', $_EVENT_DATA);
	$Smarty->assign('attachment_ids', $attachment_ids);
	$Smarty->assign('att_count',  count($Attachments));
	$Smarty->assign('schedule_count', count($ScheduleInfo));
	$Smarty->assign('att_dir', $att_dir);
	$Smarty->assign('event_time', $event_time);
	
	
	$Smarty->display('page_header.tpl');
	
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
	
	$Smarty->display('event_preview.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');


}

?>