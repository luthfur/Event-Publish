<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/


$current_password = sanitize_input(trim($_POST['current_password']));
$new_password = sanitize_input(trim($_POST['new_password']));
$confirm_password = sanitize_input(trim($_POST['confirm_password']));
$account_id = intval($_POST['account_id']);

$AccountData = new AccountData($mdb2);
$Account = new SystemAccount($AccountData->getSingle($account_id));

$error = array();

if($current_password == "") {
	$error[current_password] = 1;
} else if($new_password == "") {
	$error[new_password] = 1;
} else if($confirm_password == "") {
	$error[confirm_password] = 1;
}else if($confirm_password != $new_password) {
	$error[compare] = 1;
}else if(!$Account->checkPassword($current_password)) {
	$error[invalid_password] = 1;
}

if(count($error) == 0){

	$AccountData->changePassword($new_password, $account_id);
	
	$redirect = "../my_account.php?result=1";

	$Smarty->assign('redirect', $redirect);
	
	$Smarty->display('page_header.tpl');
	
	$Smarty->display('my_account_process.tpl');
	
	$Smarty->display('redirect_footer.tpl');

} else {
	
	$redirect = "../my_account.php?result=2";

	$Smarty->assign('redirect', $redirect);
	
	$Smarty->display('page_header.tpl');
	
	$Smarty->display('my_account_process.tpl');
	
	$Smarty->display('redirect_footer.tpl');
	
}


?>