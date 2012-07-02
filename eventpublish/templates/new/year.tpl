{* Smarty *}

<div id="event_display" class="event_display">
	
	<!-- ######################### Main Header ################################### -->
	<div id="view_header">

		<div id="arrow_left"><a href="year.{$PHP_EXT}?d=1&m=1&y={math equation="x - 1" x=$year}&id={$id}&view={$view}&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Previous Month"><img src="{$template_dir}images/leftarrow.gif" border="0"></a></div>
		
		<div id="header_right">
		
			<div id="view_header_text">{$year}</div>
			
			<div id="arrow_right"><a href="year.{$PHP_EXT}?d=1&m=1&y={math equation="x + 1" x=$year}&id={$id}&view={$view}&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Next Month"><img src="{$template_dir}images/rightarrow.gif" border="0"></a></div>
			
		</div>
		
		<div class="clear"></div>

	</div>
	<!-- ########################################################################## -->
	
	
	
	
	<!-- ############## Year mini-calendars starts  ##################### -->
	<table border="0" class="yearbox" cellpadding="0" cellspacing="0">
	

		{counter start=0 skip=1 print=false}
		{section name=month loop=$year_array}
		
		{counter assign=month_num}
			
		{cycle values="<tr>,," name="begin_row"}
		<td valign="top">
		
			<table border="0" cellpadding="4" cellspacing="0" width="100%" class="yearcal">
			
			<tr>
					
				<td colspan="8" align="center" valign="middle" class="yearcal_header">
					<a href='month.{$PHP_EXT}?d=1&m={$month_num}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}'>{$_MONTH_NAMES[$month_num]}</a>
				</td>
			
			</tr>
			
			<tr>
			<td colspan="1" class="weekday_cell" align="center">&nbsp;</td>
				{section name=day loop=$week_abbr}
					<td colspan="1" class="weekday_cell" align="center">{$week_abbr[day]}</td>
				{/section}
			</tr>
	
			{section name=row loop=$year_array[month]}
			<tr>			
								
				<td colspan="1" align="center" class="minical_cell">
					<a href="week.{$PHP_EXT}?d={$WeekPointers[month][row][0]}&m={$WeekPointers[month][row][1]}&y={$WeekPointers[month][row][2]}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" title="Click to view this week"><img src="{$template_dir}images/rightsidearrow.gif" alt="View the week's events"></a>
				</td>
				
				{section name=date loop=$year_array[month][row]}
					<td class="{if $YearEventExists[month][row][date] != 0}event_cell{else}minical_cell{/if}" align="center" onMouseOver="javascript: highlightCell(this);" onMouseOut="javascript: resetCell(this, '{if $YearEventExists[month][row][date] neq 0}event_cell{else}minical_cell{/if}');">
						<a href="day.{$PHP_EXT}?d={$year_array[month][row][date]}&m={$month_num}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" class="datelink" title="View events for this date">{$year_array[month][row][date]}</a>
					</td>
				{/section}
				
			</tr>
			{/section}
			
			</table>
			
			</td>
			
			{cycle values=",,</tr>" name="end_row"}		
		{/section}
		
		</table>
		 
	<!-- ############## Year mini-calendars starts  ##################### -->
			
	
</div>