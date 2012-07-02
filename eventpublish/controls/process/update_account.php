<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/


//################################## Update Account ###########################################


/**###################### Extract passed data ######################**/

$user_full_name = sanitize_input($_POST[user_full_name]);
$user_email = sanitize_input($_POST[user_email]);
$current_user_email = sanitize_input($_POST[current_user_email]);
$is_admin = intval($_POST[is_admin]);
$account_id = intval($_POST[account_id]);
$user_id = sanitize_input($_POST[user_id]);
$page = intval($_POST[current_page]);
$order = intval($_POST[order]);
$order_by = intval($_POST[order_by]);

/**#################### Extract passed data #######################**/



/**#################### On Success ########################**/
			
	// set account type
	
	$account_type = (($is_admin == 1)? ACCOUNT_ADMIN: ACCOUNT_USER);
	
	$AccountData = new AccountData($mdb2);
		
	if(!$user_email) $user_email = $current_user_email;
	
	// Add Account Info to Database
	$data = array("account_id" => $account_id,
					"user_id" => $user_id,
					"user_full_name" => $user_full_name, 
					"user_email" => $user_email, 
					"account_type" => $account_type 
					);
	
		
	$User = new SystemUser($data);	
	$AccountData->update($User);
	

/**#################### Success End ####################**/




$redirect = "../account.php?return=1&tsk=2&p=$page&order=$order&order_by=$order_by";

$Smarty->assign('redirect', $redirect);	

$Smarty->display('page_header.tpl');

$Smarty->display('update_account_process.tpl');

$Smarty->display('redirect_footer.tpl');




//#############################################################################################

?>