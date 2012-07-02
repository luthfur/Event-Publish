<?php 

/************* includes *****************************/
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);
/****************************************************/



//################################## Update Category ###########################################



$CategoryData = new CategoryData($mdb2);


$data = array();
$data[cat_name] = sanitize_input($_POST[cat_name]);
$data[cat_id] = intval($_POST[cat_id]);

/**************** Set up the data objects ********************************/
$Category  = new Category($data);
/***********************************************************************/


/*********************** Execute Query ***********************/
$res = $CategoryData->update($Category);

if (PEAR::isError($res)) {
	echo 0;
}

$res = $CategoryData->getSingle($_POST[cat_id]);
/*************************************************************/



//################################################################################################


// Return new category data
header("Content-Type: application/xml");
echo "<?xml version='1.0' ?>";
echo "<categories>\n";
while($data = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	echo "<category id='$data[cat_id]'>\n";
	echo "<name>$data[cat_name]</name>\n";
	echo "</category>\n";
	
}
echo "</categories>\n";

?>