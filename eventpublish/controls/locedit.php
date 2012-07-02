<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "manage";


/************ main page variables *******************************/

$Smarty->assign('method', "update");
$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);
/****************************************************************/

$id = intval($_GET['id']);


$LocationData = new LocationData($mdb2);
$LocResult = $LocationData->getSingle($id);

$data = $LocResult->fetchRow(MDB2_FETCHMODE_ASSOC);

$Smarty->assign('post_back', $data);

$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');
	
$Smarty->display('location_form.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');


?>