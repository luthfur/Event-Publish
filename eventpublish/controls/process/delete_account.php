<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/


//################################## Delete Account ###########################################


/**###################### Extract passed data ######################**/

// TODO: Perform Security Tests
$account_id = intval($_POST[account_id]);
$user_id = intval($_POST[user_id]);
$assign_user = intval($_POST[assign_user]);
$current_page = intval($_POST[current_page]);
$order = intval($_POST[order]);
$order_by = intval($_POST[order_by]);
/**#################### Extract passed data #######################**/


$AccountData = new AccountData($mdb2);
$AccountData->delete($account_id, $user_id);
$AccountData->reassign($user_id, $assign_user);
// reassign location and contacts

$redirect = "../account.php?return=1&tsk=3&p=$current_page&order=$order&order_by=$order_by";

$Smarty->assign('redirect', $redirect);	

$Smarty->display('page_header.tpl');

$Smarty->display('delete_account_process.tpl');

$Smarty->display('redirect_footer.tpl');


//#############################################################################################

?>