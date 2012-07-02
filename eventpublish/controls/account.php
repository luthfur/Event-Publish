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

require_once('common/showaccountlist.php');
?>