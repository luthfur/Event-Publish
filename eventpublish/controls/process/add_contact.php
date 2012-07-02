<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Add New Contact ###########################################



$ContactData = new ContactData($mdb2);

// get the new id
$new_id = $ContactData->getCurrentId() + 1;




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



//################################################################################################


// Return ID of the newly created contact
echo $ContactData->getCurrentId();


?>