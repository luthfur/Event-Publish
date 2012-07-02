{* Smarty *}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/transitional.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >

<title>{$page_title}</title>



<link rel="stylesheet" href="{$template_dir}styles/layout/eventform.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/minicalendar.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/main.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/account.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/dashboard.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/settings.css" type="text/css">


<script type="text/javascript" src="{$template_dir}../js/global.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event-cache.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/main.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/date_process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/event_process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/location_process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/contact_process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/attachment_process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_details/process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/picker.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_filter.js"></script>
<script type="text/javascript" src="{$template_dir}../js/content-loader.js"></script>
<script type="text/javascript" src="{$template_dir}../js/location_filter.js"></script>
<script type="text/javascript" src="{$template_dir}../js/contact_filter.js"></script>
<script type="text/javascript" src="{$template_dir}../js/location_form.js"></script>

<script type="text/javascript" src="{$template_dir}../js/lists.js"></script>
<script type="text/javascript" src="{$template_dir}../js/contact_form.js"></script>
<script type="text/javascript" src="{$template_dir}../js/nav.js"></script>


<script type="text/javascript" src="{$template_dir}../js/scriptaculous-js-1.7.0/prototype.js"></script> 
<script src="{$template_dir}../js/scriptaculous-js-1.7.0/scriptaculous.js" type="text/javascript"></script>

<!-- System Calendar Managment styles and scripts -->
<link rel="stylesheet" href="{$template_dir}styles/layout/manage_calendar.css" type="text/css">
{if $js_calendar_control == "category"}
<script type="text/javascript" src="{$template_dir}../js/manage_category.js"></script>
{else if $js_calendar_control == "calendar"}
<script type="text/javascript" src="{$template_dir}../js/manage_calendar.js"></script>
{/if}

<script type="text/javascript" src="{$template_dir}../js/manage_accounts.js"></script>

<script type="text/javascript">
		
	{literal}
		
	var template_dir = '{/literal}{$template_dir}{literal}';
	var StartDatePicker = new DatePicker('start_picker', 0 ,0);
	var StopDatePicker= new DatePicker('stop_picker', 0 ,0);
	var locationXML = null;
	var contactXML = null;
	
	function init() {
		
			preLoadLocationList();
			preLoadContactList();
	}
	
	
	function navToggle(change_to, icon) {
					
		var linkDiv = document.getElementById(icon + '_link');
		var img = document.getElementById(icon + '_icon');
								
		var type = ((change_to == 'highlight' || change_to == 'select') ? 'select' : 'icon');	
					
		img.src = template_dir + "/images/nav_icons/" + icon + "_" + type + ".gif";
		
		if(change_to == 'icon') {
			
			linkDiv.className = 'nav_link';
			
		} else  {
		
			linkDiv.className = change_to + '_nav_link'; 
			
		}
							
	}
	
	
	function subNavToggle(change_to, icon) {
				
		var img = document.getElementById(icon);
								
		var type = ((change_to == 'highlight') ? '_select' : '');	
					
		img.src = template_dir + "/images/subnav_icons/" + icon + type + ".gif";
									
	}
		
		

	addEvent(window, 'load', init, false);
	addEvent(window, 'unload', EventCache.flush, false);
	
	{/literal}
</script>


{if $redirect}
	
	<meta http-equiv="refresh" content="1;URL={$redirect}">
		
{/if}


</head>

<body>


