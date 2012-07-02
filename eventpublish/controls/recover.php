<?php

define(ROOT_DIR, "../");

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once(ROOT_DIR . 'main.' . PHP_EXT);

$mdb2 = MDB2::factory($dsn, $options);


/************* extract settings ***************************/
$SettingsData = new SettingsData($mdb2);
$Settings = $SettingsData->load();

$setting_data = $Settings->getAll();

/**********************************************************/


/************************** Grab URL **********************************************/

$current_path = $_SERVER['PHP_SELF'];
$path_array = explode("/", $_SERVER['PHP_SELF']);
$new_path = "";

for($i=1; $i<count($path_array) - 2; $i++) {
	$new_path .= "/" . $path_array[$i];
}

$url = "http://" . $_SERVER['SERVER_NAME'] . $new_path;

/**********************************************************************************/


$admin_email = $setting_data["superadmin_email"];

define(EP_ADMIN_EMAIL, $admin_email);
define(EVENT_PUBLISH_URL, $url);

$template = "new";

// sanitize input
$user_name = sanitize_input($_POST['user_name']);
$user_email = sanitize_input($_POST['user_email']);


/************* Authenticate User ***************************/
$Auth = new AccountAuthentication($mdb2);

if($account_id = $Auth->checkEmail($user_name, $user_email)) {
	
	$password = generate_pass();

	
	$AccountData = new AccountData($mdb2);
	$AccountData->changePassword($password, $account_id);
	
	$control_url = EVENT_PUBLISH_URL . "/controls/";		
	
	// Send welcome email
	$recipients = $user_email;

	$headers['From']    = EP_ADMIN_EMAIL;
	$headers['To']      = $user_email;
	$headers['Subject'] = 'Event Publish Account - Password Recovery';
	
	$body = "Below are your new Event Publish Account details.
			
Username: $user_name
Password: $password

You can access the control panel here: $control_url
					
	";
	
	// Create the mail object using the Mail::factory method
	$mail_object = Mail::factory('Mail');
		
	if($mail_object->send($recipients, $headers, $body) != true) $errors = 1;
	
	
	// template directory:
	$template_dir = ROOT_DIR . "templates/" . $template . "/controls/";
	
	$Smarty = new Smarty();
	$Smarty->template_dir = $template_dir;
	$Smarty->assign('template_dir', $template_dir);
	$Smarty->assign('page_title', EP_PAGE_TITLE);
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('password_sent.tpl');
	$Smarty->display('page_footer.tpl');
	
} else {
	
	// template directory:
	$template_dir = ROOT_DIR . "templates/" . $template . "/controls/";
	
	$Smarty = new Smarty();
	$Smarty->template_dir = $template_dir;
	$Smarty->assign('template_dir', $template_dir);
	$Smarty->assign('page_title', EP_PAGE_TITLE);
	
	$Smarty->assign('show_default_message', 0);
	$Smarty->assign('show_recovery_error', 1);
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('password_recovery.tpl');
	$Smarty->display('page_footer.tpl');

}

/**********************************************************/





?>
