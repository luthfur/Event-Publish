<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Add New Calendar ###########################################



$CalendarData = new CalendarData($mdb2);

$data = array();
$data[calendar_name] = sanitize_input($_POST[calendar_name]);
$data[calendar_id] = intval($_POST[calendar_id]);
$data[category_id] = intval($_POST[category_id]);

/**************** Set up the data objects ********************************/
$Calendar  = new Calendar($data);
/***********************************************************************/


/*********************** Execute Query ***********************/
$res = $CalendarData->updateName($Calendar);

if (PEAR::isError($res)) {
	echo 0;
}
$res = $CalendarData->getSingle($_POST[calendar_id]);

/*************************************************************/



//################################################################################################


// Return updated calendar data
header("Content-Type: application/xml");
echo "<?xml version='1.0' ?>";
echo "<calendars>\n";
while($data = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	echo "<calendar id='$data[calendar_id]'>\n";
	echo "<category>$data[category_id]</category>\n";
	echo "<name>$data[calendar_name]</name>\n";
	echo "</calendar>\n";
	
}
echo "</calendars>\n";


?>