<?php
/********************************************

Common.php

Library Inclusions and Object instantiations

*********************************************/

define(ROOT_DIR, "../../");

require_once(ROOT_DIR . 'main.php');


/*************** establish database driver *******************************/
$mdb2 = MDB2::factory($dsn, $options);

require_once('../session_manager.php');

/************* extract settings ***************************/
$SettingsData = new SettingsData($mdb2);
$Settings = $SettingsData->load();

$setting_data = $Settings->getAll();

/**********************************************************/

/******************************* Settings ***************************************/
$time_zone = $setting_data['time_zone'];
$start_day = $setting_data['start_week'];
$weekend = $setting_data['week_end'];
$time_interval = $setting_data['time_intreval'];
$att_dir = "../../" . $setting_data['attachment_dir'] . "/";
$date_format = $setting_data[date_format];
$event_publish_mode = $setting_data[event_publish_mode];
$category_enable = $setting_data[category_enable];
$transition_calendar_id = $setting_data[transition_calendar_id];
$transition_category_id = $setting_data[transition_category_id];
$default_view = $setting_data[default_calendar_view] . "." . PHP_EXT;
$user_id = $Session->getSessionValue("account_id");
$account_type = $Session->getSessionValue("account_type");
$admin_email = $setting_data["superadmin_email"];
$url = $setting_data["url"];
/***********************************************************************************/


/******************************* System Constants *********************************/
define(PER_PAGE, 10);
define(ACCOUNT_ADMIN, 1);
define(ACCOUNT_USER, 2);

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
/*************************************************************************************/

/******************** System Defaults ************************************************/
$approved = 1;
$default_event_section = "eventlist.php";
$template = "new";
/**********************************************************************************/


date_default_timezone_set  ( SYS_TIME_ZONE );


// template directory:
$template_dir = ROOT_DIR . "templates/" . $template . "/controls/";

$Smarty = new Smarty();
$Smarty->template_dir = $template_dir;
$Smarty->assign('template_dir', $template_dir);

$Smarty->assign('default_event_section', $default_event_section);
$Smarty->assign('PHP_EXT', PHP_EXT);
$Smarty->assign('CONTROL_MODE', CONTROL_MODE);

$Smarty->assign('time_zone', $timezone);
$Smarty->assign('page_title', EP_PAGE_TITLE);

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