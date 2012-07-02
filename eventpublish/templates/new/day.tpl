{* Smarty *}

<div id="event_display" class="event_display">
	
	<!-- ###################### Main Header ###################### -->
	<div id="view_header">

		<div id="arrow_left"><a href="day.{$PHP_EXT}?d={$prev_day}&m={$prev_month}&y={$prev_year}&id={$id}&view=week&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Previous Day"><img src="{$template_dir}images/leftarrow.gif" alt="Go to Previous Day"></a></div>
		
		<div id="header_right">
		
			<div id="view_header_text">{$day_header}</div>
			
			<div id="arrow_right"><a href="day.{$PHP_EXT}?d={$next_day}&m={$next_month}&y={$next_year}&id={$id}&view=week&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Next Day"><img src="{$template_dir}images/rightarrow.gif" alt="Go to Next Day"></a></div>
			
		</div>
		
		<div class="clear"></div>

	</div>
	<!-- ############################################################ -->
	
	
	
	
	<!-- ############## Day box starts  ##################### -->
	<div class="daybox">
		
		{counter start=900 skip=-1 print=false}
		{counter start=200 skip=1 print=false name=pointer}
		
		{assign var=Items value=$ScheduleItems}
		
		{include file='event_list.tpl'}
				
			
	</div> 
	<!-- ############## Day box ends  ##################### -->
			
	
</div>