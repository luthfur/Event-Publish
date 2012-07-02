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

$id = intval($_GET[id]);
$current_page = intval($_GET['p']);
$order = intval($_GET['order']);
$order_by = intval($_GET['order_by']);

$Smarty->assign('id', $id);
$Smarty->assign('current_page', $current_page);
$Smarty->assign('order', $order);
$Smarty->assign('order_by', $order_by);


$AccountData = new AccountData($mdb2);
$User = new SystemUser($AccountData->getSingle($id));

$Smarty->assign('User', $User);

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('account_form.tpl');

$Smarty->display('calendar_footer.tpl');
$Smarty->display('page_footer.tpl');



?>