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

$result = intval($_GET[result]);


$AccountData = new AccountData($mdb2);
$account_data = $AccountData->getSingle(USER_ID);

$Smarty->assign('account_data', $account_data);
$Smarty->assign('result', $result);

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('my_account.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');



?>