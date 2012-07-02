<?php 


/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Fetch Location List ###########################################



$LocationData = new LocationData($mdb2);

$res = $LocationData->getList($user_id, "location_title", "ASC");

if (PEAR::isError($res)) die($res->getMessage());



//################################################################################################

header("Content-Type: application/xml");
echo "<?xml version='1.0' ?>";
echo "<location_list>\n";
while($data = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	echo "<location id='$data[location_id]'>\n";
	echo "<title>$data[location_title]</title>\n";
	echo "<address_1>$data[location_address1]</address_1>\n";
	echo "<address_2>$data[location_address2]</address_2>\n";
	echo "<city>$data[location_city]</city>\n";
	echo "<state>$data[location_state]</state>\n";
	echo "<zip>$data[location_zip]</zip>\n";
	echo "<phone>$data[location_phone]</phone>\n";
	echo "<fax>$data[location_fax]</fax>\n";
	echo "<image>$data[location_image]</image>\n";
	echo "<desc>$data[location_desc]</desc>\n";
	echo "</location>\n";
	
}
echo "</location_list>\n";
?>