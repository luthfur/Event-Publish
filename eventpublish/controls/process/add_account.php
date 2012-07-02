<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Add New Account ###########################################


/**###################### Extract passed data ######################**/

// TODO: Perform Security Tests
$user_name = sanitize_input(trim($_POST[user_name]));
$password = sanitize_input(trim($_POST[password]));
$auto_password = sanitize_input($_POST[auto_password]);
$user_full_name = sanitize_input(trim($_POST[user_full_name]));
$user_email = sanitize_input(trim($_POST[user_email]));
$is_admin = intval($_POST[is_admin]);
$page = intval($_POST[page]);
$order = intval($_POST[order]);
$order_by = intval($_POST[order_by]);

/**#################### Extract passed data #######################**/



/**###################### Validation ######################**/

$error = array();

$AccountData = new AccountData($mdb2);

// check the username
if($user_name == "") {
	$error['user_name'] = 1;
}else if($AccountData->checkUserName($user_name) == 1 || $user_name == "") {
	$error['user_name_exists'] = 1;
}


// no auto gen password...check if password is present
if($auto_password != 1 && $password == "") $error['password'] = 1;

// full name present
if($user_full_name == "") $error['user_full_name'] = 1;

// email present and valid
if(check_mail($user_email) != 1 || $user_email=="") $error['user_email'] = 1;

/**#################### Validation End ####################**/



if(count($error) == 0) {

/**#################### On Success ########################**/
		
	// Generate Password if necessary
	if($auto_password == 1) $password = generate_pass();
	
	// set account type
	$account_type = (($is_admin)? ACCOUNT_ADMIN : ACCOUNT_USER);
		
	// get account id
	$account_id = $AccountData->getCurrentAccountId();
		
	//get user id
	$user_id = $AccountData->getCurrentUserId();
	
	// Add Account Info to Database
	$data = array("account_id" => $account_id,
					"user_id" => $user_id,
					"user_name" => $user_name, 
					"password" => $password, 
					"user_full_name" => $user_full_name, 
					"user_email" => $user_email, 
					"account_type" => $account_type, 
					"account_date_set"=> time(), 		
					"account_active"=> 1,
					"account_timezone"=> 0,
					"account_perpage"=> PER_PAGE);
	
	
	$User = new SystemUser($data);	
	$AccountData->add($User);
	
	$control_url = EVENT_PUBLISH_URL . "/controls/";
	
	$admin_spec = (($is_admin)? "Administrator " : "");
	
	// Send welcome email
	$recipients = $user_email;

	$headers['From']    = EP_ADMIN_EMAIL;
	$headers['To']      = $user_email;
	$headers['Subject'] = 'New Event Publish Account';
	
	$body = "
Hello $user_full_name,

A new Event Publish " . $admin_spec . "account has been created for you.
			
You can access the control panel here: $control_url
	
Username: $user_name
Password: $password
					
	";
	
	$error_send_email = 0;
	
	// Create the mail object using the Mail::factory method
	$mail_object = Mail::factory('mail');
	//print_r($mail_object);
	
	if($mail_object->send($recipients, $headers, $body) != true) $error_send_email = 1;
	
	
	
	$redirect = "../account.php?return=1&tsk=1&emsl=$error_send_email&p=$page&order=$order&order_by=$order_by";
	
	$Smarty->assign('redirect', $redirect);	

	$Smarty->display('page_header.tpl');

	$Smarty->display('add_account_process.tpl');
	
	$Smarty->display('redirect_footer.tpl');
	

/**#################### Success End ####################**/

} else {

	//print_r($error);
	/**#################### Display List ########################**/

	$post_back = array("user_name" => $user_name,
						"password" => $password,
						"auto_password" => $auto_password,
						"user_full_name" => $user_full_name,
						"user_email" => $user_email,
						"is_admin" => $is_admin,
						"page" => $page,
						"order" => $order,
						"order_by" => $order_by);
	
	$Smarty->assign('error', $error);
	$Smarty->assign('post_back', $post_back);
	
	$Smarty->assign('main_path', "../");
	
	require_once('../common/showaccountlist.php');
	
	/**#################### Display List ######################**/

}







//#############################################################################################

?>