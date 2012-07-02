<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_CON_DATA = $_POST;
/****************************************************/


//include 'validate_location.php';

$error = array();

//########################################################## Add New Event #############################################################################//


if(in_array(true, $error)) {
	
	//############### Validation failed..redisplay form with error messages	###################//
	
	// parse the date string from client
	$Smarty->assign('post_back', $_CON_DATA);
	$Smarty->assign('error', $error);
	$Smarty->assign('method', "add");
	$Smarty->assign('main_path', "../");		// used to point back to this process
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
		
	$Smarty->display('contact_form.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');
	
	//###########################################################################################//
	
	
} else {
	
	$ContactData = new ContactData($mdb2);
	/**************** Set up the data objects ********************************/
	$Contact  = new Contact();
	
	$Address = new Address();
	$ContactInfo = new ContactInfo();
	
	if($_POST[contact_address1]) $Address->setAddressLine1(sanitize_input($_POST[contact_address1]));
	if($_POST[contact_address2]) $Address->setAddressLine2(sanitize_input($_POST[contact_address2]));
	
	if($_POST[contact_city]) $Address->setCity(sanitize_input($_POST[contact_city]));
	if($_POST[contact_state]) $Address->setState(sanitize_input($_POST[contact_state]));
	if($_POST[contact_zip]) $Address->setZip(sanitize_input($_POST[contact_zip]));
	if($_POST[contact_phone]) $Address->setPhone(sanitize_input($_POST[contact_phone]));
	if($_POST[contact_fax]) $Address->setFax(sanitize_input($_POST[contact_fax]));
	
	if($_POST[contact_name]) $ContactInfo->setName(sanitize_input($_POST[contact_name]));
	if($_POST[contact_email]) $ContactInfo->setEmail(sanitize_input($_POST[contact_email]));
	if($_POST[contact_cell]) $ContactInfo->setCell(sanitize_input($_POST[contact_cell]));
	
	$ContactInfo->setAddress($Address);
	$Contact->setContactInfo($ContactInfo);
	/***********************************************************************/
	
	
	/*********************** Execute Query ***********************/
	$res = $ContactData->add($Contact, $user_id);
	
	if (PEAR::isError($res)) {
		die($res->getMessage());
	}
	/*************************************************************/


	$control_location = "contact";
	$section_location = "new";
	
	/************ main page variables *******************************/
	
	$Smarty->assign('today_date', $today_date);
	$Smarty->assign('control_location', $control_location);
	$Smarty->assign('section_location', $section_location);
	/****************************************************************/
	
	$Smarty->assign('main_path', "../");
	
	$_CON_DATA['contact_name'] = clean_display($_CON_DATA['contact_name']);
	
	$Smarty->assign('post_back', $_CON_DATA);
	$Smarty->assign('method', "add");
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
		
	$Smarty->display('contact_details.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');
	
	

}




//#################################################################################################################################################//





?>