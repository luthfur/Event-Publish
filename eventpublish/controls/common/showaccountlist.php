<?php 

$page = intval($_GET['p']);
$order = intval($_GET['order']);
$order_by = intval($_GET['order_by']);
$tsk = intval($_GET['tsk']);
$return = intval($_GET['return']);

if(!$page) $page = 1;
if(!$order) $order = 1;
if(!$order_by) $order_by = 1;

// derive the order
switch($order_by){
	case 1:
		$list_order = "user_name";
		break;
	
	case 2:
		$list_order = "user_full_name";
		break;
	
	case 3:
		$list_order = "user_email";
		break;
}


switch($order){
	case 1:
		$list_order_by = "ASC";
		break;
	
	case 2:
		$list_order_by = "DESC";
		break;
	
}



$Users = array();
$AccountData = new AccountData($mdb2);
$Result = $AccountData->getList($list_order, $list_order_by);

$Pager = new ResultPager($Result, $page, 12);

$DataList = $Pager->getData();

while(list($ind, $val) = each($DataList)) {
	
	$Users[] = new SystemUser($val);
	
}

$division = round(count($Users) / 3);

$row_1 = $division;
$row_2 = $division + $row_1;
$row_3 = count($Users);

$Smarty->assign('row_1', $row_1);
$Smarty->assign('row_2', $row_2);
$Smarty->assign('row_3', $row_3);



$Smarty->assign('total_pages', $Pager->getTotalPages());
$Smarty->assign('current_page', $page);
$Smarty->assign('next_page', $Pager->getNextPage());
$Smarty->assign('prev_page', $Pager->getPrevPage());
$Smarty->assign('page_nav', $Pager->getNav());
$Smarty->assign('jump_forward', $Pager->jumpForward());
$Smarty->assign('jump_back', $Pager->jumpBack());

$Smarty->assign('order', $order);
$Smarty->assign('order_by', $order_by);

$Smarty->assign('tsk', $tsk);
$Smarty->assign('return', $return);

$Smarty->assign('Users', $Users);

$Smarty->assign('total_users',  count($Users));

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');

$Smarty->display('nav.tpl');

$Smarty->display('account.tpl');

$Smarty->display('calendar_footer.tpl');
$Smarty->display('page_footer.tpl');



?>