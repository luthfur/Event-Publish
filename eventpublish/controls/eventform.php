<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "events";


/************ main page variables *******************************/
$Smarty->assign('method', "add");
$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);
/****************************************************************/


// check if data returned from event preview
if(count($_POST)) {
	
	$_EVENT_DATA = $_POST;
	
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
	
}

include 'common/showeventform.' . PHP_EXT;


?>