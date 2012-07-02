<?php 

/**********************************************************************
month.php

Month Calendar View

***********************************************************************/



// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);



/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('curr_view', "month");
$Smarty->assign('enable_sidebar', "true");
/****************************************************************/



/****************** Get Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id);
if($location_id) $EventScheduleQuery->setLocation($location_id);
$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getMonth($month, $year);
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
$MonthSchedule =  new MonthSchedule($month, $year, $timezone, $weekend, $ScheduleData);

$SchedIterator = $MonthSchedule->getIterator();

$DateTimeSet = array();
$DateSet = array();
$ScheduleItems = array();


if($month_display_type == 2) {
	$ScheduleItems[0] = null;
	$DateTimeSet[0] = null;
	
	}



// setup date display format:
if(WEEK_FORMAT == 0) {
	$date_display_format = "l, jS";
} else if (WEEK_FORMAT == 1) {
	$date_display_format = "l, j";
} else if (WEEK_FORMAT == 2) {
	$date_display_format = "j, l";
}else if (WEEK_FORMAT == 3) {
	$date_display_format = "jS, l";
}

while($DaySchedule = $SchedIterator->next()) {
	
	// weed out spill ins
	$Items = $DaySchedule->getItems();
	$TimedItems = array();
	
	while(list($ind, $val) = each($Items)) {
		
		if($val->getStartTime()->compareDate($DaySchedule->getDate()) == 0 ) $TimedItems[] = $val;
		
	}
	
	// setup the schedule items for this day
	$ScheduleItem = array();
	
	$ScheduleItem = (($notime_arrange == 1) ? array_merge($DaySchedule->getNoTimeItems(), $TimedItems) : array_merge($TimedItems, $DaySchedule->getNoTimeItems()));

	if((count($ScheduleItem) != 0 && $month_display_type == 1) || $month_display_type == 2) {
	
		$DateTimeSet[] = $DaySchedule->getDate();
		$DateSet[] = $DaySchedule->getDate()->format($date_display_format);
		$ScheduleItems[] = $ScheduleItem;
		
	}
	
}


// month pointers for next and previous month
$month_array = $MonthSchedule->getMonth()->toArray($start_day);

$DatePointer = new SC_DateTime(1, $MonthSchedule->getMonth()->getMonthOfYear(), $MonthSchedule->getMonth()->getYear());

$DatePointer->addMonth(1);

$next_month = $DatePointer->getMonth();
$next_year = $DatePointer->getYear();

$DatePointer->removeMonth(2);

$prev_month = $DatePointer->getMonth();
$prev_year = $DatePointer->getYear();


// setup month header text
$month_header =  $_MONTH_NAMES[$MonthSchedule->getMonth()->getMonthOfYear()] . " (" . $MonthSchedule->getMonth()->getYear() . ")";		

/**********************************************************/



/****** Check publish mode: toggle calendar name in listing view ********/

$show_calendar_name = 0;

if(EVENT_PUBLISH_MODE == PUBLISH_MODE_MULTI) $show_calendar_name = 1;

/************************************************************************/


/************* Pass in data and variables ***********************/
$Smarty->assign("DateTimeSet", $DateTimeSet);
$Smarty->assign("DateSet", $DateSet);
$Smarty->assign_by_ref("ScheduleItems", $ScheduleItems);
$Smarty->assign("month_array", $month_array);
$Smarty->assign("week_names", $week_names);
$Smarty->assign("month_header", $month_header);

$Smarty->assign('next_day', 1);
$Smarty->assign('next_month', $next_month);
$Smarty->assign('next_year', $next_year);
$Smarty->assign('prev_day', 1);
$Smarty->assign('prev_month', $prev_month);
$Smarty->assign('prev_year', $prev_year);

$Smarty->assign("show_calendar_name", $show_calendar_name);

/****************************************************************/


$Smarty->assign('show_minical', (($month_display_type == 1) ? "true" : "false"));
$Smarty->assign('show_sidebar', (($month_display_type == 1) ? "true" : "false"));

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

if($month_display_type == 1) {
	$Smarty->display('month_list.tpl');
} else {
	$Smarty->display('month_block.tpl');
}

$Smarty->display('sidebar.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

?>