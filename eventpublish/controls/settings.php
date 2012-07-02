<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.php');


$control_location = "manage";

/************ main page variables *******************************/

$Smarty->assign('today_date', $today_date);

$Smarty->assign('control_location', $control_location);

/****************************************************************/

$TimeZoneData = new TimeZoneData($mdb2);

$timezone_identifiers = $TimeZoneData->getList();

$Smarty->assign('timezone_identifiers', $timezone_identifiers);


$SettingsData = new SettingsData($mdb2);
$Settings = $SettingsData->load();

$setting_data = $Settings->getAll();

$Smarty->assign('setting_data', $setting_data);


// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('settings.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');



?>