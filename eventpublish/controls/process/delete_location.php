<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_LOC_DATA = $_GET;
/****************************************************/

$ids = explode(",", $_LOC_DATA['ids']);
	
$LocationData = new LocationData($mdb2);
$LocationData->delete($ids);

$redirect = "../loclist.php";

$Smarty->assign('redirect', $redirect);

$Smarty->display('page_header.tpl');

$Smarty->display('delete_location_process.tpl');

$Smarty->display('redirect_footer.tpl');

?>