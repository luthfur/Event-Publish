<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$_LOC_DATA = $_POST;
/****************************************************/


include 'validate_location.php';


//########################################################## Add New Event #############################################################################//


if(in_array(true, $error)) {
	
	//############### Validation failed..redisplay form with error messages	###################//
	
	// parse the date string from client
	$Smarty->assign('post_back', $_LOC_DATA);
	$Smarty->assign('error', $error);
	$Smarty->assign('method', "update");
	$Smarty->assign('main_path', "../");		// used to point back to this process
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
		
	$Smarty->display('location_form.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');
	
	//###########################################################################################//
	
	
} else {
	
	
	/**************** Set up the data objects ********************************/
	$Location  = new Location(0,$_LOC_DATA['location_id']);
	
	$Address = new Address();
	
	if($_POST[location_address1]) $Address->setAddressLine1(sanitize_input($_POST[location_address1]));
	if($_POST[location_address2]) $Address->setAddressLine2(sanitize_input($_POST[location_address2]));
	
	if($_POST[location_city]) $Address->setCity(sanitize_input($_POST[location_city]));
	if($_POST[location_state]) $Address->setState(sanitize_input($_POST[location_state]));
	if($_POST[location_zip]) $Address->setZip(sanitize_input($_POST[location_zip]));
	if($_POST[location_phone]) $Address->setPhone(sanitize_input($_POST[location_phone]));
	if($_POST[location_fax]) $Address->setFax(sanitize_input($_POST[location_fax]));
	if($_POST[location_title]) $Location->setTitle(sanitize_input($_POST[location_title]));
	if($_POST[location_desc]) $Location->setDescription(sanitize_input($_POST[location_desc]));
	
	$Location->setAddress($Address);
	/***********************************************************************/
	
	
	$LocationData = new LocationData($mdb2);

	
	/*********************** Execute Query ***********************/
	$res = $LocationData->update($Location);
	
	if (PEAR::isError($res)) {
		die($res->getMessage());
	}
	/*************************************************************/

	
	$control_location = "location";
	$section_location = "list";
	
	/************ main page variables *******************************/
		
	$Smarty->assign('today_date', $today_date);
	$Smarty->assign('control_location', $control_location);
	$Smarty->assign('section_location', $section_location);
	/****************************************************************/
	
	$_LOC_DATA['location_title'] = clean_display($_LOC_DATA['location_title']);
	
	$Smarty->assign('main_path', "../");
	$Smarty->assign('post_back', $_LOC_DATA);
	$Smarty->assign('method', "update");
	
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	
	$Smarty->display('nav.tpl');
		
	$Smarty->display('location_details.tpl');
	
	$Smarty->display('calendar_footer.tpl');
	
	$Smarty->display('page_footer.tpl');
	
	

}




//#################################################################################################################################################//





?>