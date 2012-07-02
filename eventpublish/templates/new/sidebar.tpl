{* Smarty *}

<div id="sidebar">


<div id="minicalendar">

<table cellpadding="4" cellspacing="0" width="100%" class="minical">
	
	<tr class="minical_header">

		<td colspan="2" align="right">
			<a href="{$Smarty.server.SERVER_NAME}?d={$mincal_prev_day}&m={$mincal_prev_month}&y={$mincal_prev_year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" title="Go to Previous Month" id="prev_month" class="tableheaderlink"><img src="{$template_dir}images/leftarrow.gif" alt="Go to Previous Month"></a>
				
		</td>
		
		<td colspan="4" align="center" valign="middle">
			<a href="month.{$PHP_EXT}?d={$day}&m={$month}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">{$minical_header}</a>
		</td>
		
		<td colspan="2" align="left">
			<a href="{$Smarty.server.SERVER_NAME}?d={$mincal_next_day}&m={$mincal_next_month}&y={$mincal_next_year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" title="Go to Next Month" id="next_month" class="tableheaderlink"><img src="{$template_dir}images/rightarrow.gif" alt="Go to Next Month"></a>
		</td>
	
	</tr>
	
	<tr>
		<td colspan="1" class="weekday_cell" align="center">&nbsp;</td>
		
		{section name=day loop=$week_abbr}
			<td colspan="1" class="weekday_cell" align="center">{$week_abbr[day]}</td>
		{/section}



	</tr>

	{section name=row loop=$month_array}
	<tr>			
						
		<td colspan="1" align="center" class="minical_cell">
			<a href="week.{$PHP_EXT}?d={$WeekPointer[row][0]}&m={$WeekPointer[row][1]}&y={$WeekPointer[row][2]}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" title="Click to view this week"><img src="{$template_dir}images/rightsidearrow.gif" alt="View the week's events"></a>
		</td>
		
		{section name=date loop=$month_array[row]}
			<td class="{if $EventExists[row][date] != 0}event_cell{else}minical_cell{/if}" align="center" onMouseOver="javascript: highlightCell(this);" onMouseOut="javascript: resetCell(this, '{if $EventExists[row][date] neq 0}event_cell{else}minical_cell{/if}');">
				<a href="day.{$PHP_EXT}?d={$month_array[row][date]}&m={$month}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" class="datelink" title="View events for this date">{$month_array[row][date]}</a>
			</td>
		{/section}
		
	</tr>
	{/section}

	<tr class="minical_header">

		<td colspan="2" align="right">
			<a href="{$Smarty.server.SERVER_NAME}?d={$day}&m={$month}&y={math equation="x - 1" x=$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" title="Go to Previous Year"  id="prev_year"><img src="{$template_dir}images/leftarrow.gif" alt="Previous Year"></a>
				
		</td>
		
		<td colspan="4" align="center" valign="middle">
			<a href="year.{$PHP_EXT}?d={$day}&m={$month}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">{$year}</a>
		</td>
		
		<td colspan="2" align="left">
			
				<a href="{$Smarty.server.SERVER_NAME}?d={$day}&m={$month}&y={math equation="x + 1" x=$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}" title="Go to Next Year" id="next_year"><img src="{$template_dir}images/rightarrow.gif" alt="Next Year"></a>
					
		</td>
	
	</tr>

</table>

</div>




	<!-- ################## View Event Options ##################### -->

<div id="view_event">

	<!-- ######################### View Events header ######################### -->
	<div id="view_event_header">
			
			<div id="view_event_caption">
				View Events 
			</div>
			
			
			<div id="select_toggle">
				<img src="{$template_dir}images/uparrow.gif" width="20" height="14" id="select_minus"  alt="Hide" >
				<img src="{$template_dir}images/downarrow.gif" width="20" height="14" id="select_plus" style="display: none;" alt="Show" >
			</div>
		
		
	</div>
	<!-- ######################################################################################### -->


	
	<!-- ################################3 View Events body  ##################################### -->
	<div id="view_event_body">
		
		{if $show_calendar_filter == 1}
		<!-- ################ Calendar Selector ################# -->
		<form action="{if $view_event_override == 1}{$default_view}{else}{$Smarty.server.SERVER_NAME}{/if}" method="get" id="calfilter">
		<div id="view_by_calendar">
					
			<div id="calendar_header">Select a Calendar:</div>
					
			<div class="selector">
			
			
			<select name="id" id="cal_select" class="selectbox">
				<option value="0">All Events</option>
				{if $category_in_filter == 1}
				{section name=cat loop=$Categories}
					
					<option value="{$Categories[cat]->getId()}" id="cat_{$Categories[cat]->getId()}"{if $Categories[cat]->getId() == $id && $view=='cat'} selected{/if}>{$Categories[cat]->getName()}</option>
					
					{assign var=Cals value=$Categories[cat]->getCalendars()}
					
					{section name=cal loop=$Cals}
					<option value="{$Cals[cal]->getId()}" id="cal_{$Cals[cal]->getId()}" {if $Cals[cal]->getId() == $id && $view=='cal'}selected{/if}>&nbsp;&nbsp;-&nbsp;&nbsp;{$Cals[cal]->getName()}</option>
					{/section}
				{/section}
				{else}
					{section name=cal loop=$Calendars}
					<option value="{$Calendars[cal]->getId()}" id="cal_{$Calendars[cal]->getId()}" {if $Calendars[cal]->getId() == $id && $view=='cal'}selected{/if}>&nbsp;&nbsp;-&nbsp;&nbsp;{$Calendars[cal]->getName()}</option>
					{/section}
				
				{/if}
			</select>
			
			
			</div>
			
			<input type="hidden" name="d" value="{$day}" />
			<input type="hidden" name="m" value="{$month}" />
			<input type="hidden" name="y" value="{$year}" />
			<input type="hidden" name="z" value="{$time_zone}" />
			<input type="hidden" name="lid" value="{$location_id}" />
			<input type="hidden" name="pv" value="{$private_mode}" />
			<input type="hidden" id="calselect_view" name="view" value="" />
			
			<div class="button">
				<input type="button" onclick="javascript: goToCalendar()" value="Go" class="button">
			</div>
			
			&nbsp;
			
		</div>
		</form>
		<!-- ############### Calendar Selector End ############### -->
		{/if}



		<!-- ############### Location Selector ################# -->
		<form action="{if $view_event_override == 1}{$default_view}{else}{$Smarty.server.SERVER_NAME}{/if}" method="get" id="locfilter">
		<div id="view_by_location">
					
		<div id="location_header">{if $location_filter_label == 1}Select a Location:{else}Filter by Location:{/if}</div>
		
			
			<div class="selector">
			<select name="lid" class="selectbox">
				<option value="0">All Locations</option>
				{section name=loc loop=$Locations}
					<option value="{$Locations[loc]->getId()}" {if $Locations[loc]->getId() == $location_id}selected{/if}>{$Locations[loc]->getTitle()}</option>
				{/section}
			</select>
			</div>
			<input type="hidden" name="d" value="{$day}" />
			<input type="hidden" name="m" value="{$month}" />
			<input type="hidden" name="y" value="{$year}" />
			<input type="hidden" name="z" value="{$time_zone}" />
			<input type="hidden" name="pv" value="{$private_mode}" />
			<input type="hidden" name="view" value="{$view}" />
			<input type="hidden" name="id" value="{$id}" />
			
			<div class="button"><input type="submit" value="Go" class="button" /></div>
			
			&nbsp;
			
		</div>
		</form>
		<!-- ################# Location Selector Ends ################## -->


		
		


	</div>
	<!-- ######################## View Event Options Ends ########################### -->

</div>


<div id="options" style="display: none">

	<div id="option_header">
			
		
			<div id="option_caption">
				Subscribe to Calendars
			</div>
			
			<div id="option_toggle">
					<img src="{$template_dir}images/uparrow.gif" width="20" height="14" id="option_minus"  alt="Hide">
					<img src="{$template_dir}images/downarrow.gif" width="20" height="14" id="option_plus" style="display: none;"  alt="Show">
			</div>

			
			
		
	</div>

	<div id="option_body">
		
		<div id="optionlinks">
			<a href="">iCalendar</a><br /><br />
			<a href="">RSS Feed</a><br /><br />
		</div>
		
	</div>


</div>



<div id="search">


	<div id="search_header">
			
		
			<div id="search_caption">
				Search Calendars
			</div>
			
			<div id="search_toggle">
					<img src="{$template_dir}images/uparrow.gif" width="20" height="14" id="search_minus"  alt="Hide">
					<img src="{$template_dir}images/downarrow.gif" width="20" height="14" id="search_plus" style="display: none;"  alt="Show">
			</div>

			
			
		
	</div>

	<div id="search_body">
		<div id="searchbox">
			<form method="post" action="search.php" id="basic_search_form">
			<input type="text" name="keywords" value="search for..." class="field" size="31" onclick="javascript: this.value='';">
			<input type="hidden" name="cid" value="{if $view == 'cal'}{$id}{/if}" />
			<input type="hidden" name="catid" value="{if $view == 'cat'}{$id}{/if}" />
			<input type="hidden" name="lid" value="{$location_id}" />
			<br /><br />
			<div id="advsearch"><a href="search.php">Advanced Search</a></div><input type="submit" value="Search" class="button">
			</form>
		</div>
		
	</div>


</div>

</div><!-- ########################### End of Div RightBar ###################3############ -->
