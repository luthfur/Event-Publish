{* Smarty *}

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/transitional.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >

<title>{$page_title}</title>



<link rel="stylesheet" href="{$template_dir}styles/layout/eventform.css" type="text/css">




<script type="text/javascript" src="{$template_dir}../js/global.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event-cache.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/main.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_form/attachment_process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/event_details/process.js"></script>
<script type="text/javascript" src="{$template_dir}../js/content-loader.js"></script>


<script type="text/javascript">
		
	{literal}
		
	var template_dir = '{/literal}{$template_dir}{literal}';
	
	addEvent(window, 'load', init, false);
	addEvent(window, 'unload', EventCache.flush, false);
	
	{/literal}
</script>


{if $redirect}
	
	<meta http-equiv="refresh" content="1;URL={$redirect}">
		
{/if}


</head>

<body>


