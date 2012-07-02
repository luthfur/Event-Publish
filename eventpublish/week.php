<?php 

/**********************************************************************
week.php

Weekly Calendar View

***********************************************************************/



// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);


/****************** Get Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id);

if($location_id) $EventScheduleQuery->setLocation($location_id);

$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getWeek($day, $month, $year, $start_day);
$SidebarData = $EventSchedule->getMonth($month, $year);

/************************************************************************/


/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('enable_sidebar', "true");
$Smarty->assign('show_sidebar', "true");
$Smarty->assign('show_minical', "true");
$Smarty->assign('curr_view', "week");
/****************************************************************/




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


/************************************************* Scheduling ****************************************************/

$WeekSchedule =  new WeekSchedule($day, $month, $year, $start_day, $timezone, $weekend, $ScheduleData);

$SchedIterator = $WeekSchedule->getIterator();

$DateTimeSet = array();
$DateSet = array();
$ScheduleItems = array();

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
	
	// setup the schedule items and date set
	$DateTimeSet[] = $DaySchedule->getDate();
	$DateSet[] = $DaySchedule->getDate()->format($date_display_format);
	$ScheduleItems[] = (($notime_arrange == 1)? array_merge($DaySchedule->getNoTimeItems(), $TimedItems) : array_merge($DaySchedule->getItems(), $TimedItems));
	
}


// set up the week pointers for next week and prev week
$WeekOf = $WeekSchedule->getWeek()->getWeekOf();

$WeekOf->addWeek(1);

$LastDayOfWeek = new SC_DateTime(0,0,0,0,0,0,$WeekOf->getTimeStamp());
$LastDayOfWeek->removeDay(1);


$NextWeekOf = new SC_DateTime($WeekOf->getDay(), $WeekOf->getMonth(), $WeekOf->getYear());

$WeekOf->removeWeek(1);

$PrevWeekOf = new SC_DateTime($WeekOf->getDay(), $WeekOf->getMonth(), $WeekOf->getYear());
$PrevWeekOf->removeDay(1);


// setup the header text
if($LastDayOfWeek->getYear() != $WeekOf->getYear()) {

	$week_header =  $WeekOf->getDay() . " " . $_MONTH_NAMES[$WeekOf->getMonth()] . ", " . $WeekOf->getYear() . " to " . $LastDayOfWeek->getDay() . " " . $_MONTH_NAMES[$LastDayOfWeek->getMonth()] . ", " . $LastDayOfWeek->getYear();		

} else if ($LastDayOfWeek->getMonth() != $WeekOf->getMonth()) {
	
	$week_header =  $WeekOf->getDay() . " " . $_MONTH_NAMES[$WeekOf->getMonth()]  . " to " . $LastDayOfWeek->getDay() . " " . $_MONTH_NAMES[$LastDayOfWeek->getMonth()] . " (" . $LastDayOfWeek->getYear() . ")";		

} else {

	$week_header =  $WeekOf->getDay() . " to " . $LastDayOfWeek->getDay() . " " . $_MONTH_NAMES[$LastDayOfWeek->getMonth()] . " (" . $LastDayOfWeek->getYear() . ")";		

}




/*********************************************************************************************************************/



/****** Check publish mode: toggle calendar name in listing view ********/

$show_calendar_name = 0;

if(EVENT_PUBLISH_MODE == PUBLISH_MODE_MULTI) $show_calendar_name = 1;

/************************************************************************/



/************* Pass in data and variables ***********************/
$Smarty->assign("DateTimeSet", $DateTimeSet);
$Smarty->assign("DateSet", $DateSet);
$Smarty->assign_by_ref("ScheduleItems", $ScheduleItems);

$Smarty->assign("week_header", $week_header);

$Smarty->assign('next_day', $NextWeekOf->getDay());
$Smarty->assign('next_month', $NextWeekOf->getMonth());
$Smarty->assign('next_year', $NextWeekOf->getYear());
$Smarty->assign('prev_day', $PrevWeekOf->getDay());
$Smarty->assign('prev_month', $PrevWeekOf->getMonth());
$Smarty->assign('prev_year', $PrevWeekOf->getYear());

$Smarty->assign("show_calendar_name", $show_calendar_name);

/****************************************************************/


//************ Display *********************************//

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

// week view display
$Smarty->display('week.tpl');

// sidebar display
$Smarty->display('sidebar.tpl');


$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

//*******************************************************//

?>