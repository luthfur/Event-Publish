<?php 

//################################################# Validate Event Data ################################################################//

$error = array();

// check if an event title was specified
if($_LOC_DATA[location_title] && trim($_LOC_DATA[location_title]) != "") {
	$error["location_title"] = false;
} else  {	
	$error["location_title"] = true;
}
//####################################################################################################################################################//

?>