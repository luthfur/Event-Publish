<?php
/********************************************

common.php

Library Inclusions and Object instantiations

*********************************************/

define(ROOT_DIR, "");

require_once(ROOT_DIR . 'main.php');


/*************** establish database driver *******************************/

$mdb2 = MDB2::factory($dsn, $options);


/************* extract settings ***************************/
$SettingsData = new SettingsData($mdb2);
$Settings = $SettingsData->load();

$setting_data = $Settings->getAll();

/**********************************************************/


/******************************* Settings ***************************************/
$default_view = $setting_data[default_calendar_view] . "." . PHP_EXT;
$start_day = $setting_data[start_week];
$weekend = $setting_data[weekend];
$att_dir = $setting_data[attachment_dir] . "/";
$month_display_type = (($setting_data[month_view] == "list") ? 1 : 2); //month display type (1-> list, 2 -> block)
$time_zone = $setting_data[time_zone];
$date_format = $setting_data[date_format];
$week_format = $setting_data[week_format];
$event_publish_mode = $setting_data[event_publish_mode];
$category_enable = $setting_data[category_enable];
/********************************************************************************/


/*************************** System Constants ********************************/
define(ACCOUNT_ADMIN, 1);
define(ACCOUNT_USER, 2);
define(PER_PAGE, 10);


define(PUBLISH_MODE_MULTI, "multi");
define(PUBLISH_MODE_SINGLE, "single");
define(PUBLISH_MODE_LOCATION, "location");


define(SYS_TIME_ZONE, $time_zone);
define(DATE_FORMAT, $date_format);
define(WEEK_FORMAT, $week_format);
define(SYS_TIME_ZONE, $time_zone);
define(CATEGORY_ENABLE, $category_enable);
define(EVENT_PUBLISH_MODE, $event_publish_mode);

$_MONTH_NAMES = array(1=>"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

$_WEEK = array(0=>"Sun", 1=>"Mon", 2=>"Tue", 3=>"Wed", 4=>"Thu", 5=>"Fri", 6=>"Sat");

// setup week names based on the start of the week
$_WEEK_ABBR = array(0=>"S", 1=>"M", 2=>"T", 3=>"W", 4=>"T", 5=>"F", 6=>"S");

$template = "new";

$notime_arrange = "1";	// before the timed events
/**************************************************************************/


date_default_timezone_set(SYS_TIME_ZONE);



// template directory:
$template_dir = "templates/" . $template . "/";
$Smarty = new Smarty();
$Smarty->template_dir = $template_dir;
$Smarty->assign('template_dir', $template_dir);


$Smarty->assign('PHP_EXT', PHP_EXT);



/************ Parse Query String *********************/
$day = $_GET["d"];
$month = $_GET["m"];
$year = $_GET["y"];
$id = $_GET["id"];
$location_id = $_GET["lid"];

if(isset($day)) settype($day, "integer"); 
if(isset($month)) settype($month, "integer");
if(isset($year)) settype($year, "integer");
if(isset($id)) settype($id, "integer");
if(isset($location_id)) settype($location_id, "integer");

$view = $_GET["view"];

//$private_mode = $_GET["pv"];
//$timezone_ptr = ((isset($_GET["z"])) ? $_GET["z"] : $default_time_zone);
//$timezone = $timezone_vals[$timezone_ptr];

/*****************************************************/




/************** set defaults *************************/

//if($timezone == null) $timezone = $default_time_zone; 

$DateTime = new SC_DateTime(0,0,0,0,0,0,time());

$TodayDate = Utilities::shiftTime($DateTime,0, $timezone);

$this_day = $TodayDate->getDay();
$this_month = $TodayDate->getMonth();
$this_year = $TodayDate->getYear();

if((!isset($day) || $day == 0) || (!isset($year) || $year == 0) || (!isset($month) || $month == 0)) {
	$day = $this_day;
	$month = $this_month;
	$year = $this_year;
}

/*********************************************/



// Pass in query string vals
$Smarty->assign('day', $day);
$Smarty->assign('month', $month);
$Smarty->assign('year', $year);

$Smarty->assign('this_day', $this_day);
$Smarty->assign('this_month', $this_month);
$Smarty->assign('this_year', $this_year);

$Smarty->assign('id', $id);
$Smarty->assign('view', $view);


$Smarty->assign('location_id', $location_id);
$Smarty->assign('private_mode', $private_mode);
$Smarty->assign('display_mode', DISPLAY_MODE);

$Smarty->assign('time_zone', $timezone_ptr);
$Smarty->assign('timezone_list', $timezone_list);







/*************** setup id for data fetch ***************************/

if($view == "cal") {
	$cal_id = $id;
} elseif($view == "cat") {
	$cat_id = $id;
}




$calendar_title = "All Events";
$calendar_title2 = "";




/************** Setup Category objects ****************************/

$CategoryData = new CategoryData($mdb2);
$CalendarData = new CalendarData($mdb2);

$CalRes = $CalendarData->getList(null, "calendar_name", "ASC");
$CatRes = $CategoryData->getList("cat_name", "ASC");

$Calendars = array();
$Categories = array();

while($caldata = $CalRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Calendars[] = new Calendar($caldata);
	if($view == "cal" && $caldata["calendar_id"] == $id) $calendar_title = $caldata["calendar_name"];		
}
	
		
while($catdata = $CatRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	$Category = new Category($catdata);
	
	$CatCal = array();
	reset($Calendars);
	while(list($ind, $Calendar) = each($Calendars)) {
					
		if($Calendar->getCategoryId() == $Category->getId()) {
			$CatCal[] = $Calendar;
		}			
					
	}
	
	$Category->setCalendars($CatCal);
	$Categories[] = $Category;	
	
	if($view == "cat" && $catdata["cat_id"] == $id) $calendar_title = $catdata["cat_name"];			
}


/******************************************************************/





/********************** Location Objects *************************/

$LocationData = new LocationData($mdb2);

$LocRes = $LocationData->getList(null, "location_title", "ASC");

while($locdata = $LocRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Locations[] = new Location($locdata);		
	
	if(!$id && $locdata["location_id"] == $location_id) {
	
		$calendar_title = "Events at " . $locdata["location_title"];	
		
	} elseif ($locdata["location_id"] == $location_id) {
	
		$calendar_title2 = "Events at " . $locdata["location_title"];
		
	}
	
}

/*******************************************************************/



$Smarty->assign('calendar_title', $calendar_title);
$Smarty->assign('calendar_title2', $calendar_title2);




/****************** set todays date ***********************************/
if(DATE_FORMAT == 0) {
	$format = "F j, Y";
} else if (DATE_FORMAT == 1) {
	$format = "j F, Y";
} else if (DATE_FORMAT == 2) {
	$format = "Y-m-d";
}

$today_date = $TodayDate->format($format);

/***********************************************************************/



$Smarty->assign('page_title', EP_PAGE_TITLE);



$show_calendar_link = 0;

if(EVENT_PUBLISH_MODE == PUBLISH_MODE_MULTI) {
 $show_calendar_link = 1;
}
$Smarty->assign('show_calendar_link', $show_calendar_link);



?>