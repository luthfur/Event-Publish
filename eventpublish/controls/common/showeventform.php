<?php 
// grab calendar list
$CalendarData = new CalendarData($mdb2);
$CalRes = $CalendarData->getList(null, "calendar_name", "ASC");

$Calendars = array();

while($caldata = $CalRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Calendars[] = new Calendar($caldata);
}


// grab location list
$Locations = array();

$LocationData = new LocationData($mdb2);

if(EVENT_PUBLISH_MODE == PUBLISH_MODE_LOCATION){
	$res = $LocationData->getList(null, "location_title", "ASC");
} else {
	$res = $LocationData->getList($user_id, "location_title", "ASC");
}
if (PEAR::isError($res)) die($res->getMessage());

while($data = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Locations[] = new Location($data);
}




// grab contact list
$Contacts = array();

$ContactData = new ContactData($mdb2);

$res = $ContactData->getList($user_id, "contact_name", "ASC");

if (PEAR::isError($res)) die($res->getMessage());

while($data = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Contacts[] = new Contact($data);
}




/*********** create time selection array ****************************/

$DateLooper = new SC_DateTime(1,1,2007, 1, 0,0);

$time_array = array();

while ($DateLooper->getHour() < 13) {
	$time_array[] = $DateLooper->getHour() . ":" . (($DateLooper->getMinute() < 10) ? "0" : "") . $DateLooper->getMinute();
	$DateLooper->addMinute($time_interval);

}

/********************************************************************/


$Smarty->assign('time_array', $time_array);
$Smarty->assign('Calendars', $Calendars);
$Smarty->assign('Locations', $Locations);
$Smarty->assign('Contacts', $Contacts);

$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');
	
$Smarty->display('event_form.tpl');


$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

?>