<?php

define(ROOT_DIR, "../");

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once(ROOT_DIR . 'main.' . PHP_EXT);

$mdb2 = MDB2::factory($dsn, $options);

$template = "new";

// sanitize input
$user_name = sanitize_input($_POST['user_name']);
$password =  sanitize_input($_POST['user_password']);


/************* Authenticate User ***************************/
$Auth = new AccountAuthentication($mdb2);

if($account_data = $Auth->check($user_name, $password)) {
	
	$Session = new Session();
		
	$Session->register(array("account_id" => $account_data[account_id], "account_type"=>$account_data[account_type], "user_name" => $account_data[user_name],"full_name" => $account_data[user_full_name]));
	
	//echo $account_id;
	
	header("Location: index.php");
	
} else {
	
	// template directory:
	$template_dir = ROOT_DIR . "templates/" . $template . "/controls/";
	
	$Smarty = new Smarty();
	$Smarty->template_dir = $template_dir;
	$Smarty->assign('template_dir', $template_dir);
	$Smarty->assign('page_title', EP_PAGE_TITLE);
	
	$Smarty->assign('show_login_error', 1);
	$Smarty->assign('show_login_message', 0);
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('login.tpl');
	$Smarty->display('page_footer.tpl');

}

/**********************************************************/





?>
