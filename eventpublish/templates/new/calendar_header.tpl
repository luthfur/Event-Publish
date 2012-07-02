{* Smarty *}

<div id="calendar">

<div id="template_header">

	<div id="calendar_title">{$calendar_title}</div>
	<div id="calendar_title2">{$calendar_title2}</div>

	<div id="top_menu">
		{if $show_calendar_link == 1}<a href="index.{$PHP_EXT}?view=cal&pv={$private_mode}&z={$time_zone}">Calendars</a>{/if}
		<a href="index.{$PHP_EXT}?view=loc&pv={$private_mode}&z={$time_zone}">Locations</a>
			
	</div>

</div>


<div id="template_menu">

	<div id="calendar_menu">

		<a href="week.{$PHP_EXT}?d={$day}&m={$month}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">Weekly</a>
		<a href="month.{$PHP_EXT}?d=1&m={$month}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">Monthly</a>
		<a href="year.{$PHP_EXT}?y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">Yearly</a>
		<a href="day.{$PHP_EXT}?d={$this_day}&m={$this_month}&y={$this_year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">Today's Events</a>
		<a href="search.php">Search</a>
	</div>
		


	<div id="calendar_time">
		Today: <a href="day.{$PHP_EXT}?d={$this_day}&m={$this_month}&y={$this_year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">{$today_date}</a>
		{if $enable_sidebar eq "true"}
		&nbsp;&nbsp;
		<a href="javascript:void(null)" id="bar_toggle" class="bar_toggle">
			<img src="{$template_dir}images/hide.gif" id="hide_sidebar_icon" style="vertical-align: middle" />
			<img src="{$template_dir}images/show.gif" id="show_sidebar_icon" style="vertical-align: middle" />	
		</a>
		{/if}
	</div>
	
	<div class="clear"></div>
	
</div>


<div id="wrapper">
	
