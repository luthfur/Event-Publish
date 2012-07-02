<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_EVENT_DATA = $_POST;
/****************************************************/


include 'validate_event.php';


//########################################################## Add New Event #############################################################################//


if(in_array(true, $error)) {
	
	//############### Validation failed..redisplay form with error messages	###################//
	
	// parse the date string from client
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
		
		$StartDate = new SC_DateTime($start_day, $start_month, $start_year);
		$StopDate = new SC_DateTime($stop_day, $stop_month, $stop_year);
		
		$sch_data['start_date'] = $StartDate->getTimeStamp();
		$sch_data['stop_date'] = $StopDate->getTimeStamp();
		
		$ScheduleInfo[] = new EventScheduleData($sch_data);
		
		
	}
	
	$Smarty->assign('ScheduleInfo', $ScheduleInfo);
	$Smarty->assign('post_back', $_EVENT_DATA);
	$Smarty->assign('error', $error);
	$Smarty->assign('method', "add");
	$Smarty->assign('main_path', "../");		// used to point back to this process
	include '../common/showeventform.php';
	
	//###########################################################################################//
	
	
} else {
	
	
	//################################ Set Date and Time #########################################//
	$start_hour = 0;
	$stop_hour = 0;
	
	$start_min = 0;
	$stop_min =  0;
		
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
	
	
	}
	
	
	// schedule id collector
	$schedule_id = array();
	
	// parse the date string from client string
	$date_set = explode(";", $_EVENT_DATA[date_string]);
	
	$ScheduleDbData = new ScheduleDbData($mdb2);
	
	for($i=0; $i<count($date_set) - 1; $i++) {
		
		$date_item = explode(",", $date_set[$i]);
		
		$start_day = $date_item[2];
		$start_month = $date_item[3];
		$start_year = $date_item[4];
		
		$stop_day = ($date_item[1] == 1) ? $start_day : $date_item[5];
		$stop_month = ($date_item[1] == 1) ? $start_month : $date_item[6];
		$stop_year = ($date_item[1] == 1) ? $start_year : $date_item[7];
		
		$event_type = $date_item[1];
		
		$DataStartDate = new SC_DateTime($start_day, $start_month, $start_year, $start_hour, $start_min);
		$DataStopDate = new SC_DateTime($stop_day, $stop_month, $stop_year, $stop_hour, $stop_min);
		
		// initialize time specification
		$timespec = 0;
		
		if($_EVENT_DATA[no_time] != "on") {
		
			$timespec = 1;	
			
		}
		
		//###########################################################################################//
		
		
		
		//################################ Add Schedule Data #########################################//
		
		$ScheduleData = new ScheduleData($event_type, $DataStartDate->getTimeStamp(), $DataStopDate->getTimeStamp(), $timespec,  0, null);
						
		$ScheduleDbData->add($ScheduleData);
		$schedule_id[] = $ScheduleDbData->getCurrentId();
		
		//#############################################################################################//
	
	
	}
	
	
	
	//################################ Add Event Data #########################################//
	$Event = new Event();
		
	$Event->setTitle($_EVENT_DATA["event_title"]);	
	$Event->setTextTime($_EVENT_DATA["text_time"]);	
	$Event->setDesc($_EVENT_DATA["event_desc"]);	
	$Event->setCapacity($_EVENT_DATA["capacity"]);
	$Event->setApproved($approved);
	$Event->setPublished($_EVENT_DATA["published"]);
	$Event->setCancelled(0);
	$Event->SetAllowRegistration($_EVENT_DATA["allow_register"]);	
	$Event->setTags($_EVENT_DATA["event_tags"]);	
	
		
	$EventData = new EventData($mdb2);
	$EventData->add($Event, $_EVENT_DATA["calendar_id"], $user_id, $_EVENT_DATA["location_id"], $_EVENT_DATA["contact_id"], $schedule_id);
	
	$event_id = $EventData->getCurrentId();
	
	//#################################################################################################//
	
	
	
	
	//################################ Add Attachment Data #########################################//
	
	$AttachmentData = new AttachmentData($mdb2);
	
	if($_EVENT_DATA[attachment_ids]) {
		
		$file_array = explode(",", $_EVENT_DATA[attachment_ids]);
				
		while(list($ind, $val) = each($file_array)) {
			
			$AttachmentData->updateEvent($val, $event_id);
			
		}
	}
	
	//#################################################################################################//
	
	$redirect = "../eventdetails.php?id=$event_id";
	
	$Smarty->assign('redirect', $redirect);
	
	$Smarty->display('page_header.tpl');

	$Smarty->display('add_event_process.tpl');
	
	$Smarty->display('redirect_footer.tpl');
	

}




//#################################################################################################################################################//





?>