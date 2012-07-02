{* Smarty *}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >

<title>{$page_title}</title>


<link rel="stylesheet" href="{$template_dir}styles/layout/main.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/sidebar.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/layout/eventdisplay.css" type="text/css">


<link rel="stylesheet" href="{$template_dir}styles/appearance/sidebar.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/appearance/minicalendar.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/appearance/main.css" type="text/css">
<link rel="stylesheet" href="{$template_dir}styles/appearance/eventdisplay.css" type="text/css">


<script type="text/javascript" src="{$template_dir}js/global.js"></script>
<script type="text/javascript" src="{$template_dir}js/sidebar.js"></script>
<script type="text/javascript" src="{$template_dir}js/eventdrop.js"></script>
<script type="text/javascript" src="{$template_dir}js/minical.js"></script>
<script type="text/javascript" src="{$template_dir}js/search.js"></script>
<script type="text/javascript" src="{$template_dir}js/event-cache.js"></script>


<script type="text/javascript">
		
	{literal}
	function init() {
	
	var showBar = {/literal}{$show_sidebar}{literal};	
	var showMinCal = {/literal}{$show_minical}{literal};
		
		initSideBar(showBar, showMinCal);
	
	}

	addEvent(window, 'load', init, false);
	addEvent(window, 'unload', EventCache.flush, false);
		
	{/literal}
</script>



</head>

<body id="eventpublish_display">


