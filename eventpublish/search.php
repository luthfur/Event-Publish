<?php 

/**********************************************************************
search.php

Display the search results

***********************************************************************/


// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);


/****************** Toggle calendar filter based on display *******************************/
$enable_calendar_search_filter = 1;
$category_in_search_filter = 1;
$calendar_in_results = 1;

if(EVENT_PUBLISH_MODE != PUBLISH_MODE_MULTI) {
	
	$enable_calendar_search_filter = 0;
	$calendar_in_results = 0;
	
} else if(CATEGORY_ENABLE != 1) {
	$category_in_search_filter = 0;
}

$Smarty->assign('calendar_in_results', $calendar_in_results);
$Smarty->assign('enable_calendar_search_filter', $enable_calendar_search_filter);
$Smarty->assign('category_in_search_filter', $category_in_search_filter);
/******************************************************************************************/



/****************** Get Event Data **************************************/

$EventScheduleQuery = new EventScheduleQuery($mdb2, $timezone, $cat_id, $cal_id);
if($location_id) $EventScheduleQuery->setLocation($location_id);
$EventSchedule = new EventSchedule($EventScheduleQuery);
$ScheduleData = $EventSchedule->getDay($day, $month, $year);
$SidebarData = $EventSchedule->getMonth($month, $year);

/************************************************************************/


/************ main page variables *******************************/
$Smarty->assign('today_date', $today_date);
$Smarty->assign('enable_sidebar', "true");
$Smarty->assign('show_sidebar', "true");
$Smarty->assign('show_minical', "true");
$Smarty->assign('view_event_override', 1);
$Smarty->assign('default_view', $default_view);
$Smarty->assign('curr_view', "day");
/****************************************************************/



/**************** Setup Week Grid ***************************/
$start_week = $start_day;
$week_abbr = array();

while(list($ind, $val) = each($_WEEK)) {
	$week_abbr[$ind] = $_WEEK_ABBR[$start_week];
	$start_week = ($start_week + 1) % 7; 	
}
/***************************************************************/


/*********************** Include Side Bar ****************************/
include 'sidebar.' . PHP_EXT;
/********************************************************************/


/********************* Filter passed data **************************/

if(isset($_POST['keywords'])) {
	$_POST['keywords'] = sanitize_input($_POST['keywords']);
}

if(isset($_POST['lid'])) settype($_POST['lid'], "integer");
if(isset($_POST['cid'])) settype($_POST['cid'], "integer");
if(isset($_POST['catid'])) settype($_POST['catid'], "integer");
if(isset($_POST['page'])) settype($_POST['page'], "integer");
if(isset($_POST['search_dates'])) settype($_POST['search_dates'], "integer");
if(isset($_POST['order'])) settype($_POST['order'], "integer");
if(isset($_POST['order_by'])) settype($_POST['order_by'], "integer");

if(isset($_POST['start_day'])) settype($_POST['start_day'], "integer");
if(isset($_POST['start_month'])) settype($_POST['start_month'], "integer");
if(isset($_POST['start_year'])) settype($_POST['start_year'], "integer");
if(isset($_POST['stop_day'])) settype($_POST['stop_day'], "integer");
if(isset($_POST['stop_month'])) settype($_POST['stop_month'], "integer");
if(isset($_POST['stop_year'])) settype($_POST['stop_year'], "integer");

/********************************************************************/



/********** Create Filters *********************************************/

$EventFilter = new EventFilter();


$EventFilter->setTimeZone($timezone);


if($keywords = $_POST['keywords']) {
	$EventFilter->setKeywords($keywords);
	$EventFilter->setKeywordSearch(1,1,1);	
}

if($lid = $_POST['lid']) $EventFilter->setLocationId($lid);
if($cid = $_POST['cid']) $EventFilter->setCalendarId($cid);
if($catid = $_POST['catid']) $EventFilter->setCategoryId($catid);

if($_POST['search_dates'] && $_POST['start_day'] != 0 && $_POST['start_month'] != 0 && $_POST['start_year'] != 0 && $_POST['stop_day'] != 0 && $_POST['stop_month'] != 0 && $_POST['stop_year'] != 0) {
	
	$StartDate = new SC_DateTime($_POST[start_day], $_POST[start_month], $_POST[start_year]);
	$StopDate = new SC_DateTime($_POST[stop_day], $_POST[stop_month], $_POST[stop_year], 23, 59);
	
	$EventFilter->setDateRange($StartDate->getTimeStamp(), $StopDate->getTimeStamp());
		
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

$page = ($_POST['page']) ? $_POST['page'] : 1;

$GetEventData = new GetEventData($mdb2);

$EventSet = $GetEventData->getList($EventFilter, 2, $order_by, $order);

$Pager = new EventPager($EventSet, $page, PER_PAGE);

$EventList = $Pager->getData();



/**************************************************************************/

$Smarty->assign('post_back', $_POST);
$Smarty->assign('keywords', clean_display($_POST[keywords]));

$Smarty->assign('total_pages', $Pager->getTotalPages());
$Smarty->assign('current_page', $page);
$Smarty->assign('next_page', $Pager->getNextPage());
$Smarty->assign('prev_page', $Pager->getPrevPage());
$Smarty->assign('page_nav', $Pager->getNav());
$Smarty->assign('jump_forward', $Pager->jumpForward());
$Smarty->assign('jump_back', $Pager->jumpBack());

$Smarty->assign('EventList', $EventList);



//************ Display *********************************//

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

// event details display
$Smarty->display('search.tpl');

// sidebar display
$Smarty->display('sidebar.tpl');

$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');

//*******************************************************//

?>