<div id="event_display" class="event_display">
	
			
	<div class="section_title">Event Search</div>
	
	<form method="post" action="{$Smarty.server.SERVER_NAME}" id="adv_search_form">
		
	<table class="advsearch">
	
	<tr>
		
		<td>
			<p>Keywords in event title, description or tags:</p> <p><input type="text"  id="keywords" name="keywords" size="60" value="{$keywords}" /></p>
			
		</td>
	
	</tr>
	
	</table>
	
	
	<table class="advsearch_filters" id="search_filters" style="display: {if $post_back.show_filter}block{else}none{/if}">
	
	
	<tr>
		
		<td>
		
		Filters:
		
		</td>
		
		<td>
			<select name="lid" class="filter_select">
				<option value="0">All Locations</option>
				{section name=loc loop=$Locations}
					<option value="{$Locations[loc]->getId()}" {if $Locations[loc]->getId() == $post_back.lid}selected{/if}>{$Locations[loc]->getTitle()}</option>
				{/section}
			</select>
			{if $enable_calendar_search_filter == 1}
				
					&nbsp;&nbsp;
					<select id="cal_select" class="filter_select">
						<option value="0">All Calendars</option>
						{if $category_in_search_filter == 1}
						
						{section name=cat loop=$Categories}
									
							<option value="{$Categories[cat]->getId()}" id="cat_{$Categories[cat]->getId()}"{if $Categories[cat]->getId() == $post_back.catid } selected{/if}>{$Categories[cat]->getName()}</option>
							
							{assign var=Cals value=$Categories[cat]->getCalendars()}
							
							{section name=cal loop=$Cals}
							<option value="{$Cals[cal]->getId()}" id="cal_{$Cals[cal]->getId()}" {if $Cals[cal]->getId() == $post_back.cid}selected{/if}>&nbsp;&nbsp;-&nbsp;&nbsp;{$Cals[cal]->getName()}</option>
							{/section}
							
						{/section}
						
						{else}
						
							{section name=cal loop=$Calendars}
							<option value="{$Calendars[cal]->getId()}" id="cal_{$Calendars[cal]->getId()}" {if $Calendars[cal]->getId() == $post_back.cid}selected{/if}>&nbsp;&nbsp;-&nbsp;&nbsp;{$Calendars[cal]->getName()}</option>
							{/section}
																	
						{/if}
						
					</select>
				
				
			{/if}
		</td>
	
	</tr>
	
	
	<tr>
		
		<td>
		Date Range:				
		</td>
		
		<td>
		
		<span id="range_selector" style="display: none;">
		<select name="start_month">
			<option value="1" {if $post_back.start_month eq 1}selected{/if}>Jan</option>		
			<option value="2" {if $post_back.start_month eq 2}selected{/if}>Feb</option>	
			<option value="3" {if $post_back.start_month eq 3}selected{/if}>Mar</option>	
			<option value="4" {if $post_back.start_month eq 4}selected{/if}>Apr</option>	
			<option value="5" {if $post_back.start_month eq 5}selected{/if}>May</option>	
			<option value="6" {if $post_back.start_month eq 6}selected{/if}>Jun</option>	
			<option value="7" {if $post_back.start_month eq 7}selected{/if}>Jul</option>	
			<option value="8" {if $post_back.start_month eq 8}selected{/if}>Aug</option>	
			<option value="9" {if $post_back.start_month eq 9}selected{/if}>Sep</option>	
			<option value="10" {if $post_back.start_month eq 10}selected{/if}>Oct</option>	
			<option value="11" {if $post_back.start_month eq 11}selected{/if}>Nov</option>	
			<option value="12" {if $post_back.start_month eq 12}selected{/if}>Dec</option>	
		</select>
		
		
		<select name="start_day">
			{section name=start_day start=1 loop=32 step=1}
			  <option {if $post_back.start_day eq $smarty.section.start_day.index}selected{/if}>{$smarty.section.start_day.index}</option>
			{/section}
		</select>
		
		<select name="start_year">
			{section name=start_year start=2007 loop=2021 step=1}
			  <option {if $post_back.start_year eq $smarty.section.start_year.index}selected{/if}>{$smarty.section.start_year.index}</option>
			{/section}	
		</select>
				
		&nbsp;
		
		To
		
		&nbsp;
		
		
		<select name="stop_month">
			<option value="1" {if $post_back.stop_month eq 1}selected{/if}>Jan</option>		
			<option value="2" {if $post_back.stop_month eq 2}selected{/if}>Feb</option>	
			<option value="3" {if $post_back.stop_month eq 3}selected{/if}>Mar</option>	
			<option value="4" {if $post_back.stop_month eq 4}selected{/if}>Apr</option>	
			<option value="5" {if $post_back.stop_month eq 5}selected{/if}>May</option>	
			<option value="6" {if $post_back.stop_month eq 6}selected{/if}>Jun</option>	
			<option value="7" {if $post_back.stop_month eq 7}selected{/if}>Jul</option>	
			<option value="8" {if $post_back.stop_month eq 8}selected{/if}>Aug</option>	
			<option value="9" {if $post_back.stop_month eq 9}selected{/if}>Sep</option>	
			<option value="10" {if $post_back.stop_month eq 10}selected{/if}>Oct</option>	
			<option value="11" {if $post_back.stop_month eq 11}selected{/if}>Nov</option>	
			<option value="12" {if $post_back.stop_month eq 12}selected{/if}>Dec</option>		
		</select>
		
		
		<select name="stop_day">
			{section name=stop_day start=1 loop=32 step=1}
			  <option {if $post_back.stop_day eq $smarty.section.stop_day.index}selected{/if}>{$smarty.section.stop_day.index}</option>
			{/section}		
		</select>
		
		<select name="stop_year">
			{section name=stop_year start=2007 loop=2021 step=1}
			  <option {if $post_back.stop_year eq $smarty.section.stop_year.index}selected{/if}>{$smarty.section.stop_year.index}</option>
			{/section}		
		</select>
		&nbsp;
		<a href="javascript: disableDateRange()" id="disable_range" style="display: none;">Disable Date Range</a>
		</span>
		
		
		<span id="range_disable">
			All Dates.  <a href="javascript: enableDateRange()">Select Date Range</a>
			
				
		</span>
		
		</td>
	
	</tr>
	
	
	
	</table>
	
	<table class="search_button">
	<tr>
		
		
		<td align="left">
		<a href="javascript: toggleSearchFilters()" id="toggle_filters">{if $post_back.show_filter}Hide Options{else}Show Options{/if}</a>
			
			
		</td>
		
		
		<td align="right">
			
			<input type="hidden" name="search_dates" id="search_dates" value="{$post_back.search_dates}" />
			<input type="hidden" name="page" id="page" />
			<input type="hidden" name="cid" id="cid" />
			<input type="hidden" name="catid" id="catid" />
			<input type="hidden" name="order_by" id="order_by" />
			<input type="hidden" name="order" id="order" />
			<input type="hidden" name="show_filter" id="show_filter" value="{if $post_back.show_filter}1{else}0{/if}" />
		
			<input type="button" value="Search" onclick="javascript: refreshEventList(0)" />&nbsp;
			<input type="button" value="Reset" onclick="javascript: resetFilter()"/>&nbsp;
			
		</td>
		
		
		
	</tr>
	
	</table>
	
	</form>
	
	
	
	<table class="search_results" id="search_results">
		
		<tr>
			
			<td class="result_header">
				<i>{if $keywords != ""}Search Results for {$keywords}{else}All Events{/if}</i>		
			</td>
				
		</tr>
		
		<tr>
			
			<td>			
				
			<div id="event_order">
				Order by: 
				<select id="list_order_by" onchange="javascript: refreshEventList({$current_page})">
					<option value="1" {if $post_back.order_by == 1}selected{/if}>Event</option>
					<option value="2" {if $post_back.order_by == 2}selected{/if}>Location</option>
					<option value="3" {if $post_back.order_by == 3}selected{/if}>Calendar</option>
				</select>
				
				<select id="list_order" onchange="javascript: refreshEventList({$current_page})">
					<option value="1" {if $post_back.order == 1}selected{/if}>Ascending</option>
					<option value="2" {if $post_back.order == 2}selected{/if}>Descending</option>
				</select>
				
			</div>
			</td>
			
		</tr>
		
		<tr>
			
			<td class="search_event">
				{section name=ev loop=$EventList}
		
				{* Setup all display variables for the event *}
				{assign var=ScheduleInfo value=$EventList[ev]->getScheduleInfo()}
				{assign var=Event value=$EventList[ev]}
				{assign var=Location value=$EventList[ev]->getLocation()}
				{assign var=Calendar value=$EventList[ev]->getCalendar()}
				{assign var=Tags value=$Event->getTags()}
				{counter name=pointer assign=pointer}
				
						
				<div class="result_item">
							
					<div class="result_title"><a href="eventdetails.php?eid={$Event->getId()}">{$Event->getTitle()}</a></div>
					<div class="result_recurr">{section name=sch loop=$ScheduleInfo}<p>{$ScheduleInfo[sch]->getRecurrenceString()}: {$ScheduleInfo[sch]->getRangeString()}</p>{/section}</div>
					<div class="result_time">
					
					
					{assign var=StartDate value=$ScheduleInfo[0]->getStartDate()}
					{assign var=StopDate value=$ScheduleInfo[0]->getStopDate()}
					
					
					{* Display Time *}
					{if $ScheduleInfo[0]->getTimeSpec() eq 1}
						{$StartDate->format("g:i a")} 
						- 
						{$StopDate->format("g:i a")} 
					{else}
						{$Event->getTextTime()} 
					{/if}
								
					{if $Location->getTitle()} at <a href="{$curr_view}.{$PHP_EXT}?id=&z={$time_zone}&view=cat&lid={$Location->getId()}&pv={$private_mode}">{$Location->getTitle()}</a>{/if}{if $calendar_in_results == 1}(Calendar(s): {section name=cal loop=$Calendar}{if $smarty.section.cal.index > 0}, {/if}<a href="{$curr_view}.{$PHP_EXT}?id={$Calendar[cal]->getId()}&z={$time_zone}&view=cal&lid=0&pv={$private_mode}">{$Calendar[cal]->getName()}</a>{/section}){/if}
					
					{if count($Tags) > 0}
					<p>
						Tags: {section name=tg loop=$Tags}<a href="javascript: tagSearch('{$Tags[tg]}')">{$Tags[tg]}</a>{/section} 
					</p>
					{/if}
					
					</div> 	
					
				</div>		
				
			{/section}
			
			
			{if !$total_pages}
				
				<div class="result_item">
					<div class="result_title">No Events Found.</div>	
				</div>
				
				
			{/if}
			
			
			
			{if $total_pages}
			
				<div class="page_nav">
					
					{if $current_page != $total_pages}<a href="javascript: refreshEventList({$total_pages})" class="nav_link">&gt;&gt;</a>{/if}
					
					{if $next_page}<a href="javascript: refreshEventList({$next_page})" class="nav_link">&gt;</a>{/if}
					
					{if $jump_forward}<a href="javascript: refreshEventList({$jump_forward})" class="nav_link">...</a>{/if}
					
					{section name=pg loop=$page_nav start=-1 step=-1}
						
						<a href="javascript: refreshEventList({$page_nav[pg]})" class="nav_{if $page_nav[pg] eq $current_page}select_{/if}link">{$page_nav[pg]}</a>
					
					{/section}
					
					{if $jump_back}<a href="javascript: refreshEventList({$jump_back})" class="nav_link">...</a>{/if}
											
					{if $prev_page}<a href="javascript: refreshEventList({$prev_page})" class="nav_link">&lt;</a>{/if}
					
					{if $current_page != 1}<a href="javascript: refreshEventList(1)" class="nav_link">&lt;&lt;</a>{/if}
					
					<div class="page_nav_title">
					Page {$current_page} of {$total_pages}:
					</div>
					<div style="clear:both"></div>
				</div>
				
			{/if}
								
			</td>
			
		</tr>
		
		
		 
		
	</table>
</div>
