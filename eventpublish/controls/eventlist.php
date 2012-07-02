<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "events";

$_POST['order'] = intval($_POST['order']);
$_POST['page'] = intval($_POST['page']);
$_POST['order_by'] = intval($_POST['order_by']);
$_POST['keywords'] = sanitize_input($_POST['keywords']);

$page = ($_POST['page']) ? $_POST['page'] : 1;

/************ main page variables *******************************/

$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);

/****************************************************************/


/************** Setup Category objects ****************************/

$CategoryData = new CategoryData($mdb2);
$CalendarData = new CalendarData($mdb2);

$CalRes = $CalendarData->getList(null, "calendar_name", "ASC");
$CatRes = $CategoryData->getList("cat_name", "ASC");

$Calendars = array();
$Categories = array();

while($caldata = $CalRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Calendars[] = new Calendar($caldata);
	if($view == "cal" && $caldata["calendar_id"] == $id) $calendar_title = $caldata["calendar_name"];		
}
	
		
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
	
	if($view == "cat" && $catdata["cat_id"] == $id) $calendar_title = $catdata["cat_name"];			
}


/******************************************************************/



/********************** Location Objects *************************/

$LocationData = new LocationData($mdb2);

$LocRes = $LocationData->getList(null, "location_title", "ASC");

while($locdata = $LocRes->fetchRow(MDB2_FETCHMODE_ASSOC)) {
	$Locations[] = new Location($locdata);		
	
	if(!$id && $locdata["location_id"] == $location_id) {
	
		$calendar_title = "Events at " . $locdata["location_title"];	
		
	} elseif ($locdata["location_id"] == $location_id) {
	
		$calendar_title2 = "Events at " . $locdata["location_title"];
		
	}
	
}

/*******************************************************************/



/********** Create Filters *********************************************/

$EventFilter = new EventFilter();


$EventFilter->setTimeZone($timezone);

if(ACCOUNT_TYPE != ACCOUNT_ADMIN) $EventFilter->setUserId($user_id);

if($keywords = $_POST['keywords']) {
	$EventFilter->setKeywords($keywords);
	$EventFilter->setKeywordSearch(1,1,1);	
}

if($lid = $_POST['lid']) $EventFilter->setLocationId($lid);
if($cid = $_POST['cid']) $EventFilter->setCalendarId($cid);
if($catid = $_POST['catid']) $EventFilter->setCategoryId($catid);
if($type = $_POST['type']) $EventFilter->setEventType($type);

if($_POST['search_dates']) {
	
	$StartDate = new SC_DateTime($_POST[start_day], $_POST[start_month], $_POST[start_year]);
	$StopDate = new SC_DateTime($_POST[stop_day], $_POST[stop_month], $_POST[stop_year], 23, 59);
	
	$EventFilter->setDateRange($StartDate->getTimeStamp(), $StopDate->getTimeStamp());
		
}
if($show_cancelled = $_POST['show_cancelled']) $EventFilter->setCancelled($show_cancelled);

if($status = $_POST['status']) {

	if($status == 2) $EventFilter->setPublished(1);
	if($status == 3) $EventFilter->setPublished(0);
}


$order = "";
$order_by = "";

if($_POST['order'] && $_POST['order_by'] ) {
	
	if($_POST['order_by'] == 1) {
		$order_by = EVENT_TABLE . ".event_title";
	} else if($_POST['order_by'] == 2) {
		$order_by = LOCATION_TABLE . ".location_title";
	} else if($_POST['order_by'] == 3) {
		$order_by = CALENDAR_TABLE . ".calendar_name";
	}
	
	if($_POST['order'] == 1) {
		$order = "ASC";
	} else if($_POST['order'] == 2) {
		$order = "DESC";
	} 
	
	
}



/**************************************************************************/


/************* Get Event List *********************************************/

$GetEventData = new GetEventData($mdb2);

$EventSet = $GetEventData->getList($EventFilter, 2, $order_by, $order);

$Pager = new EventPager($EventSet, $page, PER_PAGE);

$EventList = $Pager->getData();



/**************************************************************************/





$Smarty->assign('total_pages', $Pager->getTotalPages());
$Smarty->assign('current_page', $page);
$Smarty->assign('next_page', $Pager->getNextPage());
$Smarty->assign('prev_page', $Pager->getPrevPage());
$Smarty->assign('page_nav', $Pager->getNav());
$Smarty->assign('jump_forward', $Pager->jumpForward());
$Smarty->assign('jump_back', $Pager->jumpBack());

$Smarty->assign('EventList', $EventList);
$Smarty->assign('Categories', $Categories);
$Smarty->assign('Calendars', $Calendars);
$Smarty->assign('Locations', $Locations);

$Smarty->assign('post_back', $_POST);
$Smarty->assign('keywords', clean_display($_POST['keywords']));

$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('event_list.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');


?>