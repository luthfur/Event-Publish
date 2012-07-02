<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_CON_DATA = $_GET;
/****************************************************/

$ids = explode(",", $_CON_DATA['ids']);
	
$ContactData = new ContactData($mdb2);
$ContactData->delete($ids);

$redirect = "../contactlist.php";

$Smarty->assign('redirect', $redirect);

$Smarty->display('page_header.tpl');

$Smarty->display('delete_contact_process.tpl');

$Smarty->display('redirect_footer.tpl');

?>