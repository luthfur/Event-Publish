<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.php');


$control_location = "manage";

/************ main page variables *******************************/

$Smarty->assign('today_date', $today_date);

$Smarty->assign('control_location', $control_location);

/****************************************************************/




/************** Setup Calendar objects ****************************/

$CalendarData = new CalendarData($mdb2);

$CalRes = $CalendarData->getList(null, "calendar_name", "ASC");

$Calendars = array();

while($caldata = $CalRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	
	$EventFilter = new EventFilter();
	$EventFilter->setCalendarId($caldata[calendar_id]);
	
	$GetEventData = new GetEventData($mdb2);

	$caldata["total_events"] = $GetEventData->getList($EventFilter, 1, $order_by, $order);
			
	$Calendars[] = new Calendar($caldata);
	
}

/******************************************************************/


// setup the mode text
$category_mode = "disabled";
if(EVENT_PUBLISH_MODE == PUBLISH_MODE_MULTI) {
	$system_mode = "Multiple Calendar";
	if(CATEGORY_ENABLE) $category_mode = "enabled";
} else if(EVENT_PUBLISH_MODE == PUBLISH_MODE_SINGLE) {
	$system_mode = "Single Calendar";
} else if(EVENT_PUBLISH_MODE == PUBLISH_MODE_LOCATION) {
	$system_mode = "Location Calendar";
}


$Smarty->assign('system_mode', $system_mode);
$Smarty->assign('category_mode', $category_mode);


// display the header




if(CATEGORY_ENABLE == 1) {
	
	$CategoryData = new CategoryData($mdb2);
	$CatRes = $CategoryData->getList("cat_name", "ASC");
	
	$Categories = array();
	
	while($catdata = $CatRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
		$Category = new Category($catdata);
		
		$CatCal = array();
		reset($Calendars);
		while(list($ind, $Calendar) = each($Calendars)) {
						
			if($Calendar->getCategoryId() == $Category->getId()) {
				$CatCal[] = $Calendar;
			}			
						
		}
		
		$Category->setCalendars($CatCal);
		$Categories[] = $Category;	
	}
	
	$Smarty->assign("js_calendar_control", "category");
	$Smarty->assign('Categories', $Categories);
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	$Smarty->display('nav.tpl');
	$Smarty->display('category.tpl');
} else {
	$Smarty->assign('js_calendar_control', "calendar");
	$Smarty->assign('Calendars', $Calendars);
	$Smarty->display('page_header.tpl');
	$Smarty->display('calendar_header.tpl');
	$Smarty->display('nav.tpl');
	$Smarty->display('calendar.tpl');
}

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');



?>