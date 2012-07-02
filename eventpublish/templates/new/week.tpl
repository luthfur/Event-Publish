{* Smarty *}

<div id="event_display" class="event_display">
	
	<!-- ###################### Main Header ###################### -->
	<div id="view_header">

		<div id="arrow_left"><a href="week.{$PHP_EXT}?d={$prev_day}&m={$prev_month}&y={$prev_year}&id={$id}&view={$view}&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Previous Week"><img src="{$template_dir}images/leftarrow.gif" alt="Go to Previous Week"></a></div>
		
		<div id="header_right">
		
			<div id="view_header_text">Week of {$week_header}</div>
			
			<div id="arrow_right"><a href="week.{$PHP_EXT}?d={$next_day}&m={$next_month}&y={$next_year}&id={$id}&view={$view}&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Next Week"><img src="{$template_dir}images/rightarrow.gif" alt="Go to Next Week"></a></div>
			
		</div>
		
		<div class="clear"></div>

	</div>
	<!-- ############################################################ -->
	
	
	
	
	<!-- ############## Week box starts  ##################### -->
	<div class="weekbox">
		
		{counter start=900 skip=-1 print=false}
		{counter start=200 skip=1 print=false name=pointer}
			
		{section name=week_dates loop=$DateSet}
		
		{assign var=Items value=$ScheduleItems[week_dates]}
		{assign var=thisDate value=$DateTimeSet[week_dates]}
				
		<div class="event_item_header">
			<!-- Sunday, 8th -->
			<div class="event_date_display">{$DateSet[week_dates]}</div>
			
			<div class="event_item_control"></div>
			
		</div>
		
			
		{include file='event_list.tpl'}
		
		{/section}
			
	</div> 
	<!-- ############## Week box ends  ##################### -->
			
	
</div>