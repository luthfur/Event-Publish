<?php
/********************************************

Common.php

Library Inclusions and Object instantiations

*********************************************/

define(ROOT_DIR, "../");

require_once(ROOT_DIR . 'main.' . PHP_EXT);

$mdb2 = MDB2::factory($dsn, $options);

require_once('session_manager.php');



/************* extract settings ***************************/
$SettingsData = new SettingsData($mdb2);
$Settings = $SettingsData->load();

$setting_data = $Settings->getAll();

/**********************************************************/


/******************************* Settings ***************************************/
$time_zone = $setting_data[time_zone];
$start_day = $setting_data[start_week];
$weekend = $setting_data[weekend];
$time_interval = $setting_data['time_intreval'];
$att_dir = "../" . $setting_data['attachment_dir'] . "/";
$date_format = $setting_data[date_format];
$event_publish_mode = $setting_data[event_publish_mode];
$category_enable = $setting_data[category_enable];
$transition_calendar_id = $setting_data[transition_calendar_id];
$transition_category_id = $setting_data[transition_category_id];
$default_view = $setting_data[default_calendar_view] . "." . PHP_EXT;
$user_id = $Session->getSessionValue("account_id");
$account_type = $Session->getSessionValue("account_type");
$admin_email = $setting_data["superadmin_email"];
/***********************************************************************************/


/************************** Grab URL **********************************************/

$current_path = $_SERVER['PHP_SELF'];
$path_array = explode("/", $_SERVER['PHP_SELF']);
$new_path = "";

for($i=1; $i<count($path_array) - 2; $i++) {
	$new_path .= "/" . $path_array[$i];
}

$url = "http://" . $_SERVER['SERVER_NAME'] . $new_path;

/**********************************************************************************/



/******************************* System Constants *********************************/
define(PER_PAGE, 10);
define(ACCOUNT_ADMIN, 1);
define(ACCOUNT_USER, 2);
define(MAX_UPLOAD_SIZE, 600);

$_ALLOWED_UPLOAD_TYPE = array("txt", "jpg", "gif", "pdf", "doc", "png", "psd");


define(PUBLISH_MODE_MULTI, "multi");
define(PUBLISH_MODE_SINGLE, "single");
define(PUBLISH_MODE_LOCATION, "location");

define(CONTROL_MODE, "admin");

define(DATE_FORMAT, $date_format);
define(USER_ID, $user_id);
define(CATEGORY_ENABLE, $category_enable);
define(EVENT_PUBLISH_MODE, $event_publish_mode);
define(EVENT_PUBLISH_URL, $url);
define(DEFAULT_VIEW, $default_view);
define(SYS_TIME_ZONE, $time_zone);
define(ACCOUNT_TYPE, $account_type);
define(TRANSITION_CALENDAR, $transition_calendar_id);
define(TRANSITION_CATEGORY, $transition_category_id);
define(EP_ADMIN_EMAIL, $admin_email);
define(ATTACHMENT_DIR, $att_dir);
/*************************************************************************************/


/******************** System Defaults ************************************************/
$approved = 1;
$default_event_section = "eventlist.php";
$template = "new";
/**********************************************************************************/



// set the system time zone
date_default_timezone_set(SYS_TIME_ZONE);



// template directory:
$template_dir = ROOT_DIR . "templates/" . $template . "/controls/";

$Smarty = new Smarty();
$Smarty->template_dir = $template_dir;
$Smarty->assign('template_dir', $template_dir);
$Smarty->assign('default_event_section', $default_event_section);
$Smarty->assign('PHP_EXT', PHP_EXT);
$Smarty->assign('CONTROL_MODE', CONTROL_MODE);



$DateTime = new SC_DateTime(0,0,0,0,0,0,time());

$TodayDate = Utilities::shiftTime($DateTime,0, $timezone);

$this_day = $TodayDate->getDay();
$this_month = $TodayDate->getMonth();
$this_year = $TodayDate->getYear();

/*************** establish database driver *******************************/


$Smarty->assign('att_dir', $att_dir);
$Smarty->assign('page_title', EP_PAGE_TITLE);


/********************* Setup welcome message *********************/

$welcome_name = (($Session->getSessionValue("full_name") == "")? $Session->getSessionValue("user_name") : $Session->getSessionValue("full_name") );
$Smarty->assign('welcome_name', $welcome_name);

/****************************************************************/



/******************* MODE SETINGS ***************************************************/
$enable_calendar_control = 1;	// calendar control section enable/disable
$show_calendar_filter = 1;		// calendar filter for event search
$show_calendar_selector = 1;	// calendar selection in event form
$show_location_tab = 1;			// location tab in event form
$category_in_filter	= 1;		// category listing in calendar filter
$calendar_in_results = 1;		// display calendar name in results
$calendar_in_details = 1;		// display calendar name in details
$calendar_in_preview = 1;		// display calendar name in preivew
$show_location_selector = 0;	// show location selector in event form
$event_save_mode = "calendar";	// show location selector in event form
$enable_location_control = 1;
$is_admin = ((ACCOUNT_TYPE == ACCOUNT_ADMIN) ? 1 : 0);



if(EVENT_PUBLISH_MODE != PUBLISH_MODE_MULTI) {
	
	$show_calendar_filter = 0;
	$enable_calendar_control = 0;
	$calendar_in_results = 0;
	$calendar_in_details = 0;
	$calendar_in_preview = 0;
	$event_save_mode = "none";
	$show_calendar_selector = 0;
	
	if(EVENT_PUBLISH_MODE == PUBLISH_MODE_LOCATION) {
		$show_location_selector = 1;
		$show_location_tab = 0;
		$event_save_mode = "location";
		$enable_location_control = 0;
	}
	
} else if(CATEGORY_ENABLE != 1) {
	$category_in_filter = 0;
}


$Smarty->assign('enable_location_control', $enable_location_control);
$Smarty->assign('is_admin', $is_admin);

$Smarty->assign('default_view', DEFAULT_VIEW);
$Smarty->assign('category_in_filter', $category_in_filter);
$Smarty->assign('enable_calendar_control', $enable_calendar_control);
$Smarty->assign('show_calendar_filter', $show_calendar_filter);
$Smarty->assign('show_calendar_selector', $show_calendar_selector);
$Smarty->assign('show_location_tab', $show_location_tab);
$Smarty->assign('show_location_selector', $show_location_selector);
$Smarty->assign('calendar_in_results', $calendar_in_results);
$Smarty->assign('calendar_in_results', $calendar_in_results);
$Smarty->assign('calendar_in_details', $calendar_in_details);
$Smarty->assign('calendar_in_preview', $calendar_in_preview);
$Smarty->assign('event_save_mode', $event_save_mode);
$Smarty->assign('transition_calendar_id', $transition_calendar_id);
/**************************************************************************************/


?>