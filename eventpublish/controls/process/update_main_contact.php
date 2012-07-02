<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_CON_DATA = $_POST;
/****************************************************/

$error = array();

//include 'validate_contact.php';


//########################################################## Add New Event #############################################################################//


if(in_array(true, $error)) {
	
	//############### Validation failed..redisplay form with error messages	###################//
	
	// parse the date string from client
	$Smarty->assign('post_back', $_CON_DATA);
	$Smarty->assign('error', $error);
	$Smarty->assign('method', "update");
	$Smarty->assign('main_path', "../");		// used to point back to this process
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
		
	$Smarty->display('contact_form.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');
	
	//###########################################################################################//
	
	
} else {
	
	
	/**************** Set up the data objects ********************************/
	$Contact  = new Contact(0,$_CON_DATA['contact_id']);
	
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
	
	
	$ContactData = new ContactData($mdb2);

	
	/*********************** Execute Query ***********************/
	$res = $ContactData->update($Contact);
	
	if (PEAR::isError($res)) {
		die($res->getMessage());
	}
	/*************************************************************/

	
	$control_location = "contact";
	$section_location = "list";
	
	/************ main page variables *******************************/
	
	$Smarty->assign('today_date', $today_date);
	$Smarty->assign('control_location', $control_location);
	$Smarty->assign('section_location', $section_location);
	/****************************************************************/
	
	$_CON_DATA['contact_name'] = clean_display($_CON_DATA['contact_name']);
	
	$Smarty->assign('main_path', "../");
	$Smarty->assign('post_back', $_CON_DATA);
	$Smarty->assign('method', "update");
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
		
	$Smarty->display('contact_details.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');
	
	

}




//#################################################################################################################################################//





?>