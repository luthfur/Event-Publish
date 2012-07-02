<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Add New Location ###########################################



$LocationData = new LocationData($mdb2);

// get the new id
$new_id = $LocationData->getCurrentId() + 1;




/**************** Set up the data objects ********************************/
$Location  = new Location();

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


/*********************** Execute Query ***********************/
$res = $LocationData->add($Location, $user_id);

if (PEAR::isError($res)) {
	die($res->getMessage());
}
/*************************************************************/



//################################################################################################


// Return ID of the newly created locations
echo $LocationData->getCurrentId();


?>