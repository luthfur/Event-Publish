<?php 

/**********************************************************************
day.php

Day Calendar View

***********************************************************************/



// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);


/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('enable_sidebar', "true");
$Smarty->assign('show_sidebar', "true");
$Smarty->assign('show_minical', "true");
$Smarty->assign('curr_view', "day");
/****************************************************************/


/****************** Get Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id);
if($location_id) $EventScheduleQuery->setLocation($location_id);
$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getDay($day, $month, $year);
$SidebarData = $EventSchedule->getMonth($month, $year);

/************************************************************************/



/**************** Setup Week Grid ***************************/
$start_week = $start_day;
$week_abbr = array();

while(list($ind, $val) = each($_WEEK)) {
	$week_abbr[$ind] = $_WEEK_ABBR[$start_week];
	$start_week = ($start_week + 1) % 7; 	
}
/***************************************************************/


/*********************** Include Side Bar ****************************/
include 'sidebar.' . PHP_EXT;
/********************************************************************/


/*********** Scheduling ***********************************/

$DaySchedule =  new DaySchedule($day, $month, $year,  $weekend, $timezone, $ScheduleData);


// weed out spill in items
$Items = $DaySchedule->getItems();
$TimedItems = array();
	
while(list($ind, $val) = each($Items)) {
	
	if($val->getStartTime()->compareDate($DaySchedule->getDate()) == 0 ) $TimedItems[] = $val;
	
}

// create the schedule item array
$ScheduleItems = array();	
$thisDate = $DaySchedule->getDate();
$ScheduleItems = (($notime_arrange == 1)? array_merge($DaySchedule->getNoTimeItems(), $TimedItems) : array_merge($TimedItems, $DaySchedule->getNoTimeItems()));
	


// setup the next day and prev day pointers
$DatePointer = $DaySchedule->getDate();

$DatePointer->addDay(1);

$NextDay = new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear());

$DatePointer->removeDay(2);

$PrevDay = new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear());



if(DATE_FORMAT == 0) {
	$format = "l, M jS Y";
} else if (DATE_FORMAT == 1) {
	$format = "l, jS M Y";
} else if (DATE_FORMAT == 2) {
	$format = "l, Y-m-d";
}

$day_header = $thisDate->format($format);




/**********************************************************/



/****** Check publish mode: toggle calendar name in listing view ********/

$show_calendar_name = 0;

if(EVENT_PUBLISH_MODE == PUBLISH_MODE_MULTI) $show_calendar_name = 1;

/************************************************************************/

/************* Pass in data and variables ***********************/
$Smarty->assign("thisDate", $thisDate);
$Smarty->assign_by_ref("ScheduleItems", $ScheduleItems);

$Smarty->assign("day_header", $day_header);

$Smarty->assign('next_day', $NextDay->getDay());
$Smarty->assign('next_month', $NextDay->getMonth());
$Smarty->assign('next_year', $NextDay->getYear());
$Smarty->assign('prev_day', $PrevDay->getDay());
$Smarty->assign('prev_month', $PrevDay->getMonth());
$Smarty->assign('prev_year', $PrevDay->getYear());

$Smarty->assign("show_calendar_name", $show_calendar_name);

/****************************************************************/



//************ Display *********************************//

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

// week view display
$Smarty->display('day.tpl');

// sidebar display
$Smarty->display('sidebar.tpl');


$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

//*******************************************************//

?>