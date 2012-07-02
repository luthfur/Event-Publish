<div id="section_title">
	<h1>Dashboard</h1>
	
	<p>
	Welcome, {$welcome_name}.
	</p>
</div>

<div id="dashboard">
	
	<div id="dash_events">
	
	<h1>Your events ocurring today:</h1>
	
	{section name=ev loop=$EventList}
		
		{* Setup all display variables for the event *}
		{assign var=Event value=$EventList[ev]->getDetails()}
		{assign var=ScheduleInfo value=$Event->getScheduleInfo()}
		{assign var=Location value=$Event->getLocation()}
		{assign var=Calendar value=$Event->getCalendar()}
	
		{counter name=pointer assign=pointer}
		
				
		<div class="result_item">
					
			<div class="result_title"><a href="eventdetails.php?id={$Event->getId()}">{$Event->getTitle()}</a></div>
			<div class="result_recurr">{section name=sch loop=$ScheduleInfo}<p>{$ScheduleInfo[sch]->getRecurrenceString()}: {$ScheduleInfo[sch]->getRangeString()}</p>{/section}</div>
			<div class="result_time">
			
			{assign var=StartDate value=$EventList[ev]->getStartTime()}
			{assign var=StopDate value=$EventList[ev]->getStopTime()}
			
			
			{* Display Time *}
			{if $EventList[ev]->getTimeSpec() eq 1}
				{$StartDate->format("g:i a")} 
				- 
				{$StopDate->format("g:i a")} 
			{else}
				{$Event->getTextTime()} 
			{/if}
			{if $Location->getTitle()} at <a href="../{$default_view}?lid={$Location->getId()}" target="_blank">{$Location->getTitle()}</a>{/if}{if $calendar_in_results == 1}(Calendar(s): {section name=cal loop=$Calendar}{if $smarty.section.cal.index > 0}, {/if}<a href="../{$default_view}?cid={$Calendar[cal]->getId()}" target="_blank">{$Calendar[cal]->getName()}</a>{/section}){/if}</div>
		</div>		
		
	{/section}
	
	{if $today_event_count == 0}
	<div class="result_item">
		(You have no events ocurring today.)
	</div>
	{/if}
	
	<h1>Your draft events:</h1>
	
	{section name=ev loop=$DraftEventList}
		
		{* Setup all display variables for the event *}
		{assign var=ScheduleInfo value=$DraftEventList[ev]->getScheduleInfo()}
		{assign var=Event value=$DraftEventList[ev]}
		{assign var=Location value=$DraftEventList[ev]->getLocation()}
		{assign var=Calendar value=$DraftEventList[ev]->getCalendar()}
	
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
			
			{if $Location->getTitle()} at <a href="../{$default_view}?lid={$Location->getId()}" target="_blank">{$Location->getTitle()}</a>{/if}{if $calendar_in_results == 1}(Calendar(s): {section name=cal loop=$Calendar}{if $smarty.section.cal.index > 0}, {/if}<a href="../{$default_view}?cid={$Calendar[cal]->getId()}" target="_blank">{$Calendar[cal]->getName()}</a>{/section}){/if}</div>
		</div>		
		
	{/section}
	
	{if $draft_count == 0}
	<div class="result_item">
		(You have no saved draft events right now.)
	</div>
	{/if}
	
	
	</div>
	
	
	<div id="dash_bars">

			<div>
				<a href="javascript: location.href='{$main_path}eventform.php'">
				<img src="{$template_dir}images/createNewEvent.gif" border="0" 
					onmouseover="javascript: this.src='{$template_dir}images/createNewEvent_R.gif'"  
					onmouseout="javascript: this.src='{$template_dir}images/createNewEvent.gif'" />
				</a>
				
			</div>
			
			<div id="dash_stats">
				<p>
				<strong>You have...</strong>	 
				</p>
								
				<p>
					{$published_total} Events Published
				</p>
				
				<p>
					{$draft_total} Draft Events
				</p>
			</div>
	</div>

</div>

