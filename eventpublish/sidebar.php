<?php

/***************************************************
sidebar.php

Setup and display the sidebar

****************************************************/


$location_filter_label = 0;
$show_calendar_filter = 1;
$category_in_filter = 1;

if(EVENT_PUBLISH_MODE != PUBLISH_MODE_MULTI) {
	
	$show_calendar_filter = 0;
	$category_in_filter = 0;
	
	// change location filter label from "Filter by Location" to "Select a location"
	if(EVENT_PUBLISH_MODE == PUBLISH_MODE_LOCATION) $location_filter_label = 1;
} else if(CATEGORY_ENABLE != 1) {
	$category_in_filter = 0;
}


$Smarty->assign('location_filter_label', $location_filter_label);
$Smarty->assign('show_calendar_filter', $show_calendar_filter);
$Smarty->assign('category_in_filter', $category_in_filter);


/***************************Side Bar Event Filters *******************************************************/
	$Smarty->assign('Calendars', $Calendars);
	$Smarty->assign('Categories', $Categories);
	$Smarty->assign('Locations', $Locations);
	
/******************************************************************************************************/





/***************************************** Mini Calendar *******************************************************/

// Set week link pointers

$DatePointer = new SC_DateTime(1,$month,$year);

while($DatePointer->getDayOfWeek() != $start_day) $DatePointer->removeDay(1);

$WeekPointers = array();

$WeekPointer[] = array($DatePointer->getDay(),$DatePointer->getMonth(),$DatePointer->getYear());

$DatePointer->addWeek(1);

while($DatePointer->getMonth() == $month) {
	
	$WeekPointer[] = array($DatePointer->getDay(),$DatePointer->getMonth(),$DatePointer->getYear());
	$DatePointer->addWeek(1);	
}




// Grab Month Schedule for Event Existence data
$MonthSchedule =  new MonthSchedule($month, $year, $timezone, $weekend, $SidebarData);

$EventExists = array();


$month_array = $MonthSchedule->getMonth()->toArray($start_day);

for($i=0; $i<count($month_array); $i++) {

	for($j=0; $j<count($month_array[$i]); $j++) {
				
		if($month_array[$i][$j]) {
			
			$DaySchedule = $MonthSchedule->getItemsByDate($month_array[$i][$j]);
			
			// weed out spill ins
			$Items = $DaySchedule->getItems();
			$TimedItems = array();
			
			while(list($ind, $val) = each($Items)) {
				
				if($val->getStartTime()->compareDate($DaySchedule->getDate()) == 0 ) $TimedItems[] = $val;
				
			}
			
			$EventExists[$i][$j] = ((count($TimedItems) || count($DaySchedule->getNoTimeItems()))? 1 : 0);
			
		} else {
			$EventExists[$i][$j] = 0;
		}
	}
}



// Set the previous and next pointers for the month
$DatePointer = new SC_DateTime(1, $MonthSchedule->getMonth()->getMonthOfYear(), $MonthSchedule->getMonth()->getYear());

$DatePointer->addMonth(1);

$mincal_next_month = $DatePointer->getMonth();
$mincal_next_year = $DatePointer->getYear();

$DatePointer->removeMonth(2);

$mincal_prev_month = $DatePointer->getMonth();
$mincal_prev_year = $DatePointer->getYear();

$minical_header =  $_MONTH_NAMES[$MonthSchedule->getMonth()->getMonthOfYear()];	


$Smarty->assign("WeekPointer", $WeekPointer);
$Smarty->assign_by_ref("EventExists", $EventExists);
$Smarty->assign("month_array", $month_array);
$Smarty->assign("week_abbr", $week_abbr);
$Smarty->assign("minical_header", $minical_header);
$Smarty->assign("show_calendar_filter", $show_calendar_filter);

$Smarty->assign('mincal_next_day', 1);
$Smarty->assign('mincal_next_month', $mincal_next_month);
$Smarty->assign('mincal_next_year', $mincal_next_year);
$Smarty->assign('mincal_prev_day', 1);
$Smarty->assign('mincal_prev_month', $mincal_prev_month);
$Smarty->assign('mincal_prev_year', $mincal_prev_year);

/****************************************************************************************************************/


?>