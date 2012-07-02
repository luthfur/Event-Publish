{* Smarty *}

<div id="event_display" class="event_display_wide">
	
	<!-- ######################### Main Header ################################### -->
	<div id="view_header">

		<div id="arrow_left"><a href="month.{$PHP_EXT}?d={$prev_day}&m={$prev_month}&y={$prev_year}&id={$id}&view={$view}&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Previous Month"><img src="{$template_dir}images/leftarrow.gif" border="0"></a></div>
		
		<div id="header_right">
		
			<div id="view_header_text">{$month_header}</div>
			
			<div id="arrow_right"><a href="month.{$PHP_EXT}?d={$next_day}&m={$next_month}&y={$next_year}&id={$id}&view={$view}&lid={$location_id}&pv={$private_mode}&z={$time_zone}" title="Go to Next Month"><img src="{$template_dir}images/rightarrow.gif" border="0"></a></div>
			
		</div>
		
		<div class="clear"></div>

	</div>
	<!-- ########################################################################## -->
	
		
	
		<table border="0" class="monthbox" cellpadding="0" cellspacing="0">
		
		{section name=row loop=$month_array}
							
				<tr>
				
				{section name=column1 loop=$month_array[row]}
		
					<td class="event_item_header" height="25">
						
						{if $month_array[row][column1] neq 0}{$week_names[column1]},{/if}
						{$month_array[row][column1]} 
						
					</td>
					<td class="event_item_header" height="25" align="right">&nbsp;</td>
				
				{/section}
			
				</tr>
				
				<tr>
				{section name=column2 loop=$month_array[row]}
						
						<td class="month_date_box" colspan="2" valign="top">
							
							{assign var=index_pointer value=$month_array[row][column2]}
							
							{assign var=thisDate value=$DateTimeSet[$index_pointer]}
							
							{assign var=Items value=$ScheduleItems[$index_pointer]}
							
							{section name=events loop=$Items}
								
								
								
								{* Setup all display variables for the event *}
								{assign var=Event value=$Items[events]->getDetails()}
								{assign var=StartTime value=$Items[events]->getStartTime()}
								{assign var=StopTime value=$Items[events]->getStopTime()}
								{assign var=yesterday value=$thisDate->compareDate($StartTime)}
								{assign var=tomorrow value=$thisDate->compareDate($StopTime)}
									
								
									<div class="event_item">
									{* Display Time *}
									{if $Items[events]->getTimeSpec() eq 1}
										
										{$StartTime->format("g:i a")} -<br />
										{if $yesterday neq 0} Yesterday {/if}
										  
										{$StopTime->format("g:i a")} 
										{if $tomorrow neq 0} <br />Tomorrow {/if}
									
									{else}
										{$Event->getTextTime()} 
									{/if}<br />
									<div class="event_title_month"><a href="eventdetails.{$PHP_EXT}?eid={$Event->getId()}&d={$StartTime->getDay()}&m={$StartTime->getMonth()}&y={$StartTime->getYear()}&pid={$id}&view={$view}&pview={$curr_view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">{$Event->getTitle()}</a></div>
									</div>
								
								
							{/section}
						</td>
		
				{/section}
				
				</tr>	
		{/section}
				
	</table>
</div>