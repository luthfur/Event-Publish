<?php 

//################################################# Validate Event Data ################################################################//

$error = array();

// check if a calendar was selected

if($_EVENT_DATA[calendar_id]) {
	$error["calendar_id"] = false;
} else {
	$error["calendar_id"] = true;
}


if(EVENT_PUBLISH_MODE == PUBLISH_MODE_LOCATION) {
	if(!$_EVENT_DATA[location_id]) {
		$error["location_id"] = true;
	} else {
		$error["location_id"] = false;
	}
}
// check if an event title was specified
if($_EVENT_DATA[event_title] && trim($_EVENT_DATA[event_title]) != "") {
	$error["event_title"] = false;
} else  {	
	$error["event_title"] = true;
}

if(!$_EVENT_DATA[date_string]) $error["date_string"] = true;


$_EVENT_DATA[event_title] = sanitize_input($_EVENT_DATA[event_title]);
$_EVENT_DATA[text_time] = sanitize_input($_EVENT_DATA[text_time]);
$_EVENT_DATA[event_desc] = sanitize_input($_EVENT_DATA[event_desc]);
$_EVENT_DATA[event_tags] = sanitize_input($_EVENT_DATA[event_tags]);

//####################################################################################################################################################//

?>