<?php 

/**********************************************************************
index.php

Lists the available calendars or locations (based on the publish mode).

Automatically redirects if single calendar mode is set.

***********************************************************************/

// Grab extension data
$extension = file("ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

// redirect to the default calendar view for single calendar mode
if(EVENT_PUBLISH_MODE == PUBLISH_MODE_SINGLE && ($view != "cal" && $view != "loc")) header("Location: $default_view");




/************ main page variables *******************************/
$Smarty->assign('calendar_title', $calendar_title);
$Smarty->assign('today_date', $today_date);
$Smarty->assign('default_view', $default_view);

$Smarty->assign('enable_sidebar', "false");
$Smarty->assign('show_sidebar', "false");
$Smarty->assign('show_minical', "false");


/****************************************************************/

// display the header
$Smarty->display('page_header.tpl');
$Smarty->display('calendar_header.tpl');


// page specifics
if(((!$view) && EVENT_PUBLISH_MODE == "multi") || $view == "cal") {
	
	
	if(CATEGORY_ENABLE == 1) {
				
		$Smarty->assign('select_type', "Calendar or a Category");
		$Smarty->assign('Categories', $Categories);
		
		// display the calendar list
		$Smarty->display('category_list.tpl');
	
	} else {
		
		$division = round(count($Calendars) / 2);
		
		$Smarty->assign('division', $division);
	
		$Smarty->assign('select_type', "Calendar");
		$Smarty->assign('Calendars', $Calendars);
		
		// display the calendar list
		$Smarty->display('calendar_list.tpl');
		
	}
		
	
	
} else if((!$view && EVENT_PUBLISH_MODE == PUBLISH_MODE_LOCATION) || $view == "loc") {
			
	$division = round(count($Locations) / 2);
		
	$Smarty->assign('division', $division);
	
	$Smarty->assign('select_type', "Location");
	
	$Smarty->assign('Locations', $Locations);
	
	// display the calendar list
	$Smarty->display('location_list.tpl');
	
	
}




$Smarty->display('calendar_footer.tpl');

$Smarty->display('page_footer.tpl');



?>