<!-- ##################### Event List Start ################################### -->
<div class="event_list">
	
	{if count($Items) == 0}
	
			<div class="event_item">
		
			There are no events scheduled for this day.
		
			</div>
			
	{/if}
	
						
	{section name=events loop=$Items}
	
		
		{* Setup all display variables for the event *}
		{assign var=Event value=$Items[events]->getDetails()}
		{assign var=Location value=$Event->getLocation()}
		{assign var=Calendar value=$Event->getCalendar()}
		{assign var=StartTime value=$Items[events]->getStartTime()}
		{assign var=StopTime value=$Items[events]->getStopTime()}
		{assign var=yesterday value=$thisDate->compareDate($StartTime)}
		{assign var=tomorrow value=$thisDate->compareDate($StopTime)}
		{counter name=pointer assign=pointer}
		
		
		
		<!-- ############ Event item starts  ################ -->
		<div class="event_item">

			<div class="event_icon"></div>

			<div class="event_title" id="event_{$Event->getId()}"><a href="eventdetails.{$PHP_EXT}?eid={$Event->getId()}&d={$StartTime->getDay()}&m={$StartTime->getMonth()}&y={$StartTime->getYear()}&pid={$id}&view={$view}&pview={$curr_view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">{$Event->getTitle()}</a><br /></div>
			
			<div class="event_details" style="z-index: {counter};">
										
				
				{* Display Time *}
				{if $Items[events]->getTimeSpec() eq 1}
					{$StartTime->format("g:i a")} 
					{if $yesterday neq 0} Yesterday {/if}
					 - 
					{$StopTime->format("g:i a")} 
					{if $tomorrow neq 0} Tomorrow {/if}
				
				{else}
					{$Event->getTextTime()} 
				{/if}
				
				{if $Location->getId()}at {$Location->getTitle()}{/if}
						
				{if $show_calendar_name == 1}
				&nbsp;&nbsp;|&nbsp;&nbsp;
				Calendar: <a href="{$curr_view}.{$PHP_EXT}?d={$StartTime->getDay()}&m={$StartTime->getMonth()}&y={$StartTime->getYear()}&id={$Calendar[0]->getId()}&z={$time_zone}&view=cal&lid={$location_id}&pv={$private_mode}" class="calendarlink">{$Calendar[0]->getName()}</a>
				{/if}
			<!--
				&nbsp;&nbsp;|&nbsp;&nbsp;
				
			
			  <ul class="eventdrop">
					
				<li><a href="javascript: ToggleItemMenu({$pointer});" class="event_options">Options</a>
					
					<div style="display: none;" id="div{$pointer}">						
					<ul>
							<li class="menuitemtop"><a href="javascript: showReminder({$Event->getId()});">Set Reminder</a></li>
							<li class="menuitem"><a href="">vCalendar</a></li>
							<li class="menuitem"><a href="javascript: showSignUp({$Event->getId()})">Register</a></li>
							<li class="menuitem"><a href="javascript: showEmailToFriends({$Event->getId()})">Email</a></li>
							
					</ul>
					</div>
					</li>
			</ul>
			-->
			
										
			</div> 

		</div>
		<!-- ############ Event item ends  ################ -->
									
		{/section} 
		
				
</div> 
<!-- #############  Event list ends ############### -->