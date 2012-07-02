<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/


//################################## New Password Generator ###########################################

$errors = 0;


/**###################### Extract passed data ######################**/

// TODO: Perform Security Tests
$account_id = intval($_POST[account_id]);
/**#################### Extract passed data #######################**/

$password = generate_pass();

	
$AccountData = new AccountData($mdb2);
$AccountData->changePassword($password, $account_id);
$acc_data = $AccountData->getSingle($account_id);
			
	// Send welcome email
	$recipients = $acc_data[user_email];
	
	$user_name = $acc_data['user_name'];
	$control_url = EVENT_PUBLISH_URL . "/controls/";

	$headers['From']    = EP_ADMIN_EMAIL;
	$headers['To']      = $acc_data[user_email];
	$headers['Subject'] = 'Event Publish Account - Password Recovery';
	
	$body = "

Hello " . $acc_data['user_full_name'] . ",

Below are your new Event Publish Account details.
				
Username: $user_name
Password: $password

You can access the control panel here: $control_url
					
	";

	
	// Create the mail object using the Mail::factory method
	$mail_object = Mail::factory('Mail');
		
	if($mail_object->send($recipients, $headers, $body) != true) $errors = 1;


//#############################################################################################
echo (($errors == 0)? 1: 0);
?>