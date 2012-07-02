<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "manage";

$page = ($_POST['page']) ? $_POST['page'] : 1;

/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);

/****************************************************************/


$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');


?>