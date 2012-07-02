<?php 

/**********************************************************************
year.php

Year Calendar View

***********************************************************************/


// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('enable_sidebar', "true");
$Smarty->assign('show_sidebar', "true");
$Smarty->assign('show_minical', "false");
$Smarty->assign('curr_view', "year");
/****************************************************************/


/****************** Get Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id);
if($location_id) $EventScheduleQuery->setLocation($location_id);
$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getYear($year);
$SidebarData = $ScheduleData;

/************************************************************************/



/**************** Setup Week Grid ***************************/
$start_week = $start_day;
$week_names = array();
$week_abbr = array();

while(list($ind, $val) = each($_WEEK)) {
	$week_names[$ind] = $_WEEK[$start_week];
	$week_abbr[$ind] = $_WEEK_ABBR[$start_week];
	$start_week = ($start_week + 1) % 7; 	
}
/***************************************************************/



/*********************** Include Side Bar ****************************/
include 'sidebar.' . PHP_EXT;
/********************************************************************/



/*********** Scheduling ***********************************/

$YearSchedule =  new YearSchedule($year, $timezone, $weekend, $ScheduleData);

$year_array = array();
$YearEventExists = array();

while(!$YearSchedule->isLastMonth()) {
	
	$MonthSchedule = $YearSchedule->getMonthSchedule();
	
	$temp_array = $MonthSchedule->getMonth()->toArray($start_day);
	
	for($i=0; $i<count($temp_array); $i++) {
		
		for($j=0; $j<count($temp_array[$i]); $j++) {
			
			if($temp_array[$i][$j]) {
				$DaySchedule = $MonthSchedule->getItemsByDate($temp_array[$i][$j]);
				
				// weed out spill ins
				$Items = $DaySchedule->getItems();
				$TimedItems = array();
				
				while(list($ind, $val) = each($Items)) {
					
					if($val->getStartTime()->compareDate($DaySchedule->getDate()) == 0 ) $TimedItems[] = $val;
					
				}
				
					if($DaySchedule != null) {
						$EventExists[$i][$j] = ((count($TimedItems) || count($DaySchedule->getNoTimeItems()))? 1 : 0);
					} else {
						$EventExists[$i][$j] = 0;
					}
			} else {
				$EventExists[$i][$j] = 0;
			}
		}
		
	}
	
	$YearEventExists[] = $EventExists;
	$year_array[] = $temp_array;
	
	$YearSchedule->nextMonth();
	
}
/*******************************************************************/



/************** Setup WeekPointer *****************************************************/

$WeekPointers = array();

for($i=1; $i<13; $i++) {

	$DatePointer = new SC_DateTime(1,$i,$year);
	$TempPointers = array();
	
	while($DatePointer->getDayOfWeek() != $start_day) $DatePointer->removeDay(1);
		
	$TempPointers[] = array($DatePointer->getDay(),$DatePointer->getMonth(),$DatePointer->getYear());
	
	$DatePointer->addWeek(1);
	
	while($DatePointer->getMonth() == $i) {
		
		$TempPointers[] = array($DatePointer->getDay(),$DatePointer->getMonth(),$DatePointer->getYear());
		$DatePointer->addWeek(1);	
	}
	
	$WeekPointers[$i - 1] = $TempPointers;
	
}


/**************************************************************************************/



/************* Pass in data and variables ***********************/

$Smarty->assign_by_ref("YearEventExists", $YearEventExists);
$Smarty->assign_by_ref("WeekPointers", $WeekPointers);
$Smarty->assign("year_array", $year_array);
$Smarty->assign("week_abbr", $week_abbr);
$Smarty->assign("_MONTH_NAMES", $_MONTH_NAMES);

/****************************************************************/




// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('year.tpl');

$Smarty->display('sidebar.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

?>