<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/

$settings_data = array();

if($_POST['event_publish_mode'] == "multi" || $_POST['event_publish_mode'] == "single" || $_POST['event_publish_mode'] == "location"){ 
		$settings_data['event_publish_mode'] = $_POST['event_publish_mode'];
	}

if($_POST['default_calendar_view'] == "week" || $_POST['default_calendar_view'] == "month" || $_POST['default_calendar_view'] == "day" || $_POST['default_calendar_view'] == "year") 
		$settings_data['default_calendar_view'] = $_POST['default_calendar_view'];

if($_POST['month_view'] == "list" || $_POST['month_view'] == "block") 
		$settings_data['month_view'] = $_POST['month_view'];

$settings_data['start_week'] = intval($_POST['start_week']);
$settings_data['weekend'] = intval($_POST['weekend']);
$settings_data['date_format'] = intval($_POST['date_format']);
$settings_data['week_format'] = intval($_POST['week_format']);
$settings_data['time_intreval'] = intval($_POST['time_intreval']);
$settings_data['category_enable'] = intval($_POST['category_enable']);

// perform further security test
$settings_data['time_zone'] = $_POST['time_zone'];
if(trim($_POST['url']) != "") $settings_data['url'] = trim($_POST['url']);
if(trim($_POST['attachment_dir']) != "") $settings_data['attachment_dir'] = trim($_POST['attachment_dir']);


//########### if no category mode (or is single calendar or location mode), create transition category ###################//

if($settings_data['event_publish_mode'] == "single" || $settings_data['event_publish_mode'] == "location" || $settings_data['category_enable'] == 0) {
	
	$data = array();
	$data[cat_name] = "Transition Category";
	
	
	$CategoryData = new CategoryData($mdb2);

	/**************** Set up the data objects ********************************/
	$Category  = new Category($data);
	/***********************************************************************/
	
	
	/*********************** Execute Query ***********************/
	$res = $CategoryData->add($Category);
	
	if (PEAR::isError($res)) {
		die($res->getMessage());
	}
	
	$settings_data['transition_category_id'] = $CategoryData->getCurrentId();
	/*************************************************************/
}


// if single calendar or location mode create transition calendar ################//
if($settings_data['event_publish_mode'] == "single" || $settings_data['event_publish_mode'] == "location") {
	
	$CalendarData = new CalendarData($mdb2);
	
	$data = array();
	$data[calendar_name] = "Transition Calendar";
	$data[category_id] =$settings_data['transition_category_id'];

	/**************** Set up the data objects ********************************/
	$Calendar  = new Calendar($data);
	/***********************************************************************/
	
	
	/*********************** Execute Query ***********************/
	$res = $CalendarData->add($Calendar);
	if (PEAR::isError($res)) {
		die($res->getMessage());
	}
	$settings_data['transition_calendar_id'] = $CalendarData->getCurrentId();
	/*************************************************************/
}



$SettingsData = new SettingsData($mdb2);
$SettingsData->save($settings_data);

$redirect = "../settings.php";

$Smarty->assign('redirect', $redirect);

$Smarty->display('page_header.tpl');

$Smarty->display('save_settings_process.tpl');

$Smarty->display('redirect_footer.tpl');

	


?>