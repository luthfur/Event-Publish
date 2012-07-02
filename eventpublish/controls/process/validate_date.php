<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_EVENT_DATA = $_POST;
/****************************************************/



function validateDate($day, $month, $year) {
	
	if(!is_numeric($day) || !is_numeric($month) || !is_numeric($year)) return false;
		
	if(strlen($year) != 4) return false;
	
	if($year < 1970) return false;
	
	if($month > 13 || $month < 0) return false;
	
	$Month = new Month($month, $year);
	
	if($Month->getDaysInMonth() < $day) return false;
	
	return true;	

}




//################################################# Validate Event Data ################################################################//
$error = array();



/*********** Date Validation *************************/

$error["start_date"] = false;

if(!validateDate($_EVENT_DATA["start_day"], $_EVENT_DATA["start_month"], $_EVENT_DATA["start_year"]))  {
	
	$error["start_date"] = true;

} else {
	
	// start date is valid, continue validation	
	if($_EVENT_DATA["event_type"] > 1) {
		
		if(!validateDate($_EVENT_DATA["stop_day"], $_EVENT_DATA["stop_month"], $_EVENT_DATA["stop_year"]))  {
			$error["stop_date"] = true;
		} else {
			
			// stop date is valid, continue validation
			$error["stop_date"] = false;
			
			$StartDate = new SC_DateTime($_EVENT_DATA["start_day"], $_EVENT_DATA["start_month"], $_EVENT_DATA["start_year"]);
			$StopDate = new SC_DateTime($_EVENT_DATA["stop_day"], $_EVENT_DATA["stop_month"], $_EVENT_DATA["stop_year"]);
			
			if($StartDate->compareDate($StopDate) > 0) {
			
				$error["date_compare"] = true;	
			
			} else {
				$error["date_compare"] = false;
			}		
		}	
	
	}
}	

/******************************************************/


//####################################################################################################################################################//


//print_r($_EVENT_DATA);

header("Content-Type: application/xml");
echo "<?xml version='1.0' ?>";

if(in_array(true, $error)) {
	
	if($error["start_date"] == true) {
		$code = 1;
	} elseif($error["stop_date"] == true) { 
		$code = 2;
	} elseif($error["date_compare"] == true) { 
		$code = 3;
	}
	echo "<server>\n";
	echo "<response type='error'>\n";
	echo "<date_error code='" . $code . "'></date_error>\n";
	echo "</response>\n";
	echo "</server>\n";
	
} else {
	
	$start_day = $_EVENT_DATA[start_day];
	$start_month = $_EVENT_DATA[start_month];
	$start_year = $_EVENT_DATA[start_year];
	
	$stop_day = ($_EVENT_DATA[event_type] == 1) ? $start_day : $_EVENT_DATA[stop_day];
	$stop_month = ($_EVENT_DATA[event_type] == 1) ? $start_month : $_EVENT_DATA[stop_month];
	$stop_year = ($_EVENT_DATA[event_type] == 1) ? $start_year : $_EVENT_DATA[stop_year];
	
	$DataStartDate = new SC_DateTime($start_day, $start_month, $start_year, $start_hour, $start_min);
	$DataStopDate = new SC_DateTime($stop_day, $stop_month, $stop_year, $stop_hour, $stop_min);
	
	$data = array();
	
	$data['start_date'] =  $DataStartDate->getTimeStamp();
	$data['stop_date'] =  $DataStopDate->getTimeStamp();
	$data['schedule_type'] =  $_EVENT_DATA[event_type];
	
	$ScheduleData = new EventScheduleData($data);
	echo "<server>\n";
	echo "<response type='date'>\n";
	echo "<date>\n";
	echo "<recurrence>" .$ScheduleData->getRecurrenceString() . "</recurrence>\n";
	echo "<range>" .$ScheduleData->getRangeString() . "</range>\n";
	echo "</date>\n";
	echo "</response>\n";
	echo "</server>\n";
}
?>