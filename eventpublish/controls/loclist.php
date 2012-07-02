<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$control_location = "manage";


$page = ($_POST['page']) ? $_POST['page'] : 1;

/************ main page variables *******************************/

$Smarty->assign('today_date', $today_date);
$Smarty->assign('control_location', $control_location);
$Smarty->assign('section_location', $section_location);
/****************************************************************/

/************* Get Event List *********************************************/

$_LOC_DATA = $_POST;

$search_type = array();

if($_LOC_DATA['search_name']) $search_type[0] = 1;
if($_LOC_DATA['search_address']) $search_type[1] = 1;
if($_LOC_DATA['search_city']) $search_type[2] = 1;
if($_LOC_DATA['search_state']) $search_type[3] = 1;
if($_LOC_DATA['search_zip']) $search_type[4] = 1;


$order_by = "location_title";
$order = "ASC";

if($_LOC_DATA['order'] && $_LOC_DATA['order_by'] ) {
	
	if($_LOC_DATA['order_by'] == 1) {
		$order_by = LOCATION_TABLE . ".location_title";
	} else if($_LOC_DATA['order_by'] == 2) {
		$order_by = LOCATION_TABLE . ".location_city";
	} else if($_LOC_DATA['order_by'] == 3) {
		$order_by = LOCATION_TABLE . ".location_state";
	}
	
	if($_LOC_DATA['order'] == 1) {
		$order = "ASC";
	} else if($_LOC_DATA['order'] == 2) {
		$order = "DESC";
	} 
	
	
}



$LocationData = new LocationData($mdb2);

if($is_admin) {
$LocationSet = $LocationData->getDetailedList(null, $_LOC_DATA['keywords'], $search_type, $order_by, $order);
} else {
$LocationSet = $LocationData->getDetailedList($user_id, $_LOC_DATA['keywords'], $search_type, $order_by, $order);
}

$Pager = new ResultPager($LocationSet, $page, PER_PAGE);

$LocationDataList = $Pager->getData();

$LocationList = array();

while(list($ind, $val) = each($LocationDataList)) {
	
	$LocationList[] = new Location($val);
	
}


/**************************************************************************/

$Smarty->assign('total_pages', $Pager->getTotalPages());
$Smarty->assign('current_page', $page);
$Smarty->assign('next_page', $Pager->getNextPage());
$Smarty->assign('prev_page', $Pager->getPrevPage());
$Smarty->assign('page_nav', $Pager->getNav());
$Smarty->assign('jump_forward', $Pager->jumpForward());
$Smarty->assign('jump_back', $Pager->jumpBack());

$Smarty->assign('post_back', $_LOC_DATA);


$Smarty->assign('LocationList', $LocationList);


$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');
$Smarty->display('nav.tpl');
$Smarty->display('location_list.tpl');
$Smarty->display('calendar_footer.tpl');
$Smarty->display('page_footer.tpl');


?>