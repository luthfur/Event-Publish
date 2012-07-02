<div id="section_title">
	<h1>Event Search</h1>
	
	<p>
	Use the filters to sort through and view events that you have created.
	</p>
</div>

<div id="filters">

	<h1>
		<a href="javascript: toggleFilter()">
		<img src="{$template_dir}images/uparrow.gif" style="padding-right: 6px; border: 0; display: {if $post_back.show_filter}inline{else}none{/if}" id="filter_up" /><img src="{$template_dir}images/downarrow.gif" style="padding-right: 6px; border: 0; display: {if $post_back.show_filter}none{else}inline{/if}" id="filter_down" /></a>Show events with: <i>(Click on arrow to view options.)</i>
		
	</h1>
	
	<form method="post" action="{$Smarty.server.SERVER_NAME}" id="filter_form">

	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
	Keywords in event title, description or tags: <input type="text" id="keywords" name="keywords" size="60" value="{$keywords}" />
	</p>
	
	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
	
	Location: 
	<select name="lid" class="filter_select">
		<option value="0">All Locations</option>
		{section name=loc loop=$Locations}
			<option value="{$Locations[loc]->getId()}" {if $Locations[loc]->getId() == $post_back.lid}selected{/if}>{$Locations[loc]->getTitle()}</option>
		{/section}
	</select>
	
	{if $show_calendar_filter == 1}
	&nbsp;&nbsp;
	Calendar: 
	<select id="cal_select" class="filter_select">
		<option value="0">(All Calendars)</option>
		{if $category_in_filter == 1}
		{section name=cat loop=$Categories}
					
			<option value="{$Categories[cat]->getId()}" id="cat_{$Categories[cat]->getId()}"{if $Categories[cat]->getId() == $post_back.catid } selected{/if}>{$Categories[cat]->getName()}</option>
			
			{assign var=Cals value=$Categories[cat]->getCalendars()}
			
			{section name=cal loop=$Cals}
			<option value="{$Cals[cal]->getId()}" id="cal_{$Cals[cal]->getId()}" {if $Cals[cal]->getId() == $post_back.cid}selected{/if}>&nbsp;&nbsp;-&nbsp;&nbsp;{$Cals[cal]->getName()}</option>
			{/section}
			
		{/section}
		{else}
			{section name=cal loop=$Calendars}
			<option value="{$Calendars[cal]->getId()}" id="cal_{$Calendars[cal]->getId()}" {if $Calendars[cal]->getId() == $post_back.cid}selected{/if}>{$Calendars[cal]->getName()}</option>
			{/section}
		{/if}
	</select>
	{/if}
	
	</p>
	
	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
	Recurrence: 
	<select name="type" class="filter_select">
		<option value="0">All Recurrence Types</option>
		<option value="1" {if $post_back.type eq 1}selected{/if}>No Repeat</option>
		<option value="2" {if $post_back.type eq 2}selected{/if}>Daily</option>
		<option value="3" {if $post_back.type eq 3}selected{/if}>Every Tue, Thu</option>
		<option value="4" {if $post_back.type eq 4}selected{/if}>Every Mon, Wed, Fri</option>
		<option value="5" {if $post_back.type eq 5}selected{/if}>Every Weekday</option>
		<option value="6" {if $post_back.type eq 6}selected{/if}>Every Weekend</option>
		<option value="7" {if $post_back.type eq 7}selected{/if}>Every Week</option>
		<option value="8" {if $post_back.type eq 8}selected{/if}>Every Other Week</option>
		<option value="9" {if $post_back.type eq 9}selected{/if}>Every Month</option>
		<option value="10" {if $post_back.type eq 10}selected{/if}>Every Year</option>
		<option value="11" {if $post_back.type eq 11}selected{/if}>Monthly Periodical</option>
		<option value="12" {if $post_back.type eq 12}selected{/if}>Yearly Periodical</option>
	</select>
	&nbsp;&nbsp;
		
	</p>
	
	
	
	
	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
		
		Event Date Range: 
	
		<span id="range_selector" style="display: {if $post_back.search_dates}inline{else}none{/if};">
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
		
		</span>
		
		
		<span id="all_dates" style="display: {if !$post_back.search_dates}inline{else}none{/if}">
			(All Dates)
		</span>
		
		&nbsp;&nbsp;
		
		<a href="javascript: toggleDateRange()" id="toggle_date">{if $post_back.search_dates}Search All Dates{else}Select Date Range{/if}</a>
	
	</p>
	
	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
	
	Show: 
	<select name="status" class="filter_select">
		<option value="1" {if $post_back.status eq 1}selected{/if}>Published and Draft Events</option>
		<option value="2" {if $post_back.status eq 2}selected{/if}>Published Events only</option>
		<option value="3" {if $post_back.status eq 3}selected{/if}>Draft Events only</option>
	</select>
	&nbsp;&nbsp;
	<input type="checkbox" name="show_myevents" {if $post_back.show_myevents eq 1}checked{/if} style="display: none"/><!--&nbsp;Show My Events Only -->
	&nbsp;&nbsp;
	<input type="checkbox" name="show_cancelled" {if $post_back.show_cancelled eq on}checked{/if} style="display: none" /><!--&nbsp;Show Cancelled Events -->
		
		<input type="hidden" name="search_dates" id="search_dates" value="{$post_back.search_dates}" />
		<input type="hidden" name="page" id="page" />
		<input type="hidden" name="cid" id="cid" />
		<input type="hidden" name="catid" id="catid" />
		<input type="hidden" name="order_by" id="order_by" />
		<input type="hidden" name="order" id="order" />
		<input type="hidden" name="show_filter" id="show_filter" value="{if $post_back.show_filter}1{else}0{/if}" />
		<input type="button" class="filter_button" value="Reset Filters" onclick="javascript: resetFilter()" />
		<input type="submit" class="filter_button" onclick="javascript: refreshEventList(1)" value="Refresh Event List" />
		
	
	</p>
	
	</form>
	<div style="clear: both"></div>

</div>


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


<div id="event_list">
	
	{section name=ev loop=$EventList}
		
		{* Setup all display variables for the event *}
		{assign var=ScheduleInfo value=$EventList[ev]->getScheduleInfo()}
		{assign var=Event value=$EventList[ev]}
		{assign var=Tags value=$Event->getTags()}
		{assign var=Location value=$EventList[ev]->getLocation()}
		{assign var=Calendar value=$EventList[ev]->getCalendar()}
	
		{counter name=pointer assign=pointer}
		
				
		<div class="result_item">
					
			<div class="result_title"><a href="eventdetails.php?id={$Event->getId()}">{$Event->getTitle()}</a></div>
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
						
			{if $Location->getTitle()} at <a href="../{$default_view}?lid={$Location->getId()}" target="_blank">{$Location->getTitle()}</a>{/if}{if $calendar_in_results == 1}(Calendar(s): {section name=cal loop=$Calendar}{if $smarty.section.cal.index > 0}, {/if}<a href="../{$default_view}?cid={$Calendar[cal]->getId()}" target="_blank">{$Calendar[cal]->getName()}</a>{/section}){/if}
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
	
	<div style="clear:both"></div>
	
</div>