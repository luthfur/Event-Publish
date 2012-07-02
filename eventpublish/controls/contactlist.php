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

$_CON_DATA = $_POST;

$search_type = array();

if($_CON_DATA['search_name']) $search_type[0] = 1;
if($_CON_DATA['search_email']) $search_type[1] = 1;
if($_CON_DATA['search_address']) $search_type[2] = 1;
if($_CON_DATA['search_city']) $search_type[3] = 1;
if($_CON_DATA['search_state']) $search_type[4] = 1;



$order_by = "contact_name";
$order = "ASC";

if($_CON_DATA['order'] && $_CON_DATA['order_by'] ) {
	
	if($_CON_DATA['order_by'] == 1) {
		$order_by = CONTACT_TABLE . ".contact_name";
	} else if($_CON_DATA['order_by'] == 2) {
		$order_by = CONTACT_TABLE . ".contact_email";
	} else if($_CON_DATA['order_by'] == 3) {
		$order_by = CONTACT_TABLE . ".contact_city";
	} else if($_CON_DATA['order_by'] == 4) {
		$order_by = CONTACT_TABLE . ".contact_state";
	}
	
	if($_CON_DATA['order'] == 1) {
		$order = "ASC";
	} else if($_CON_DATA['order'] == 2) {
		$order = "DESC";
	} 
	
	
}



$ContactData = new ContactData($mdb2);

if($is_admin) {
	$ContactSet = $ContactData->getDetailedList(null, $_CON_DATA['keywords'], $search_type, $order_by, $order);
} else {
	$ContactSet = $ContactData->getDetailedList($user_id, $_CON_DATA['keywords'], $search_type, $order_by, $order);
}

$Pager = new ResultPager($ContactSet, $page, PER_PAGE);

$ContactDataList = $Pager->getData();

$ContactList = array();

while(list($ind, $val) = each($ContactDataList)) {
	
	$ContactList[] = new Contact($val);
	
}


/**************************************************************************/

$Smarty->assign('total_pages', $Pager->getTotalPages());
$Smarty->assign('current_page', $page);
$Smarty->assign('next_page', $Pager->getNextPage());
$Smarty->assign('prev_page', $Pager->getPrevPage());
$Smarty->assign('page_nav', $Pager->getNav());
$Smarty->assign('jump_forward', $Pager->jumpForward());
$Smarty->assign('jump_back', $Pager->jumpBack());

$Smarty->assign('post_back', $_CON_DATA);

$Smarty->assign('ContactList', $ContactList);

$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');
$Smarty->display('nav.tpl');
$Smarty->display('contact_list.tpl');
$Smarty->display('calendar_footer.tpl');
$Smarty->display('page_footer.tpl');


?>