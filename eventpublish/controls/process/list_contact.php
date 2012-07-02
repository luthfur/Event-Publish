<?php 


/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Fetch Contact List ###########################################



$ContactData = new ContactData($mdb2);

$res = $ContactData->getList($user_id, "contact_name", "ASC");

if (PEAR::isError($res)) die($res->getMessage());



//################################################################################################

header("Content-Type: application/xml");
echo "<?xml version='1.0' ?>";
echo "<contact_list>\n";
while($data = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	echo "<contact id='$data[contact_id]'>\n";
	echo "<name>$data[contact_name]</name>\n";
	echo "<address_1>$data[contact_address1]</address_1>\n";
	echo "<address_2>$data[contact_address2]</address_2>\n";
	echo "<city>$data[contact_city]</city>\n";
	echo "<state>$data[contact_state]</state>\n";
	echo "<zip>$data[contact_zip]</zip>\n";
	echo "<email>$data[contact_email]</email>\n";
	echo "<phone>$data[contact_phone]</phone>\n";
	echo "<fax>$data[contact_fax]</fax>\n";
	echo "<cell>$data[contact_cell]</cell>\n";
	echo "</contact>\n";
	
}
echo "</contact_list>\n";
?>