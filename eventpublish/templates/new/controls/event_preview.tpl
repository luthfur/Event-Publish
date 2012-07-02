<div id="section_title">
	<h1>Event Preview</h1>
</div>


<div id="event_details">

	<div id="event_details_title">
			{if $Event->getTitle()}{$Event->getTitle()}{else}(No title Specified){/if}
	</div>
	
	
	
	{if $schedule_count}
	<div id="event_details_occ">
					
			<strong>Event Schedule:</strong>
			
		
			{section name=sch loop=$ScheduleInfo}
			
				<p>{$ScheduleInfo[sch]->getRecurrenceString()}: {$ScheduleInfo[sch]->getRangeString()}</p>
		
			{/section}
		
			<div style="clear: both"></div>
		
	</div>
	{/if}
	
	{if $schedule_count}
	<div  id="event_schedule_details">	
			<strong>Time:</strong> 
			{* Display Time *}
			{$event_time}
		
	</div>
	{/if}
	
	{if $post_back.location_id}

		{assign var=LocationAddress value=$Location->getAddress()}
					
		<div id="event_location_details">
		
				<strong>Location:</strong> <a href="javascript: toggleLocConDetails('loc_details');">{$Location->getTitle()}</a>
				<div id="loc_details" style="display: none">
				
				<h2>{$Location->getTitle()}</h2>
				
				<p>
				{if $LocationAddress->getAddressLine1()}{$LocationAddress->getAddressLine1()}<br />{/if}
				{if $LocationAddress->getAddressLine2()}{$LocationAddress->getAddressLine2()}<br />{/if}
				{if $LocationAddress->getCity()}{$LocationAddress->getCity()}{/if}{if $LocationAddress->getState()}{if $LocationAddress->getCity()}, {/if}{$LocationAddress->getState()}{/if}<br />
				{if $LocationAddress->getZip()}{$LocationAddress->getZip()}{/if}
				</p>
				
				<p>
				{if $LocationAddress->getPhone()}Tel: {$LocationAddress->getPhone()}{/if}<br />
				{if $LocationAddress->getPhone()}Fax: {$LocationAddress->getFax()}{/if}<br />
				</p>
				
				<p>
					<a href="javascript: toggleLocConDetails('loc_details');">Close</a>
				</p>
						
				</div>
		</div>
			
	{/if}
	
	{if $post_back.contact_id}
			
		{assign var=ContactInfo value=$Contact->getContactInfo()}
		{assign var=ContactAddress value=$ContactInfo->getAddress()}
	
		
	<div id="event_contact_details">
			<b>Contact:</b> <a href="javascript: toggleLocConDetails('con_details');">{if $ContactInfo->getName()}{$ContactInfo->getName()}{else}{$ContactInfo->getEmail()}{/if}</a>
			
			<div id="con_details" style="display: none">
			
			<h2>{$ContactInfo->getName()}</h2>
						
			<p>
			{if $ContactAddress->getAddressLine1()}{$ContactAddress->getAddressLine1()}<br />{/if}
			{if $ContactAddress->getAddressLine2()}{$ContactAddress->getAddressLine2()}<br />{/if}
			{if $ContactAddress->getCity()}{$ContactAddress->getCity()}{/if}{if $ContactAddress->getState()}{if $ContactAddress->getCity()}, {/if}{$ContactAddress->getState()}{/if}<br />
			{if $ContactAddress->getZip()}{$ContactAddress->getZip()}{/if}
			</p>
			
			<p>
			Email: {$ContactInfo->getEmail()}<br />
			{if $ContactAddress->getPhone()}Tel: {$ContactAddress->getPhone()}{/if}<br />
			{if $ContactAddress->getPhone()}Fax: {$ContactAddress->getFax()}{/if}<br />
			{if $ContactInfo->getCell()}Cell: {$ContactInfo->getCell()}{/if}<br />
			</p>
			
			<p>
				<a href="javascript: toggleLocConDetails('con_details');">Close</a>
			</p>
				
		</div>
		
	
	</div>
	
	{/if}
	
	
	{if $att_count > 0}
	
	<div id="event_details_att">
		<strong>Attachments:</strong>		
		
		{section name=att loop=$Attachments}
			<p>
			<a href="{$att_dir}{$Attachments[att]->getFileName()}" target="_blank">{$Attachments[att]->getFileName()}</a>{if !$Attachments[att]->isApproved()} (Pending Approval){/if}{if $Attachments[att]->getDesc()}&nbsp;({$Attachments[att]->getDesc()}){/if}
			</p>
		{/section}
		
			
	</div>
	
	{/if}
	
	{if $calendar_in_preview == 1}
		{if count($Calendars)}
	<div id="event_calendar_details">
			<strong>Calendar(s):</strong> 
			{section name=cal loop=$Calendars}{if $smarty.section.cal.index > 0}, {/if}{$Calendars[cal]->getName()}{/section}
		
	</div>
	{/if}
	{/if}
	
	{if $Event->getTags()}
	
	{assign var=Tags value=$Event->getTags()}
	<div id="event_details_tags">
		
			<strong>Tags:</strong> {section name=tg loop=$Tags}{if $smarty.section.tg.index > 0}, {/if}{$Tags[tg]}{/section}
		
	</div>
	
	{/if}
	
	
	{if $Event->getDesc()}
	<div id="event_details_desc">
		<h1>
		<b>Description:</b>
		</h1>	
		
		<p>
			{$Event->getDesc()}
		</p>
	</div>
	{/if}
	
	
	
	
	
	<div id="reg_info" style="display:none">
	
		
		<div id="reg_info_open" style="display: {if $Event->allowRegistration()}block{else}none{/if}">
		Event Registration Open <a href="javascript: toggleRegistration({$Event->getId()}, 0)">(Close Registration)</a>
			<p>
			0 Registrations so far. <a href="">(View)</a>
			</p>
		</div>
	
		
		<div id="reg_info_closed" style="display: {if $Event->allowRegistration()}none{else}block{/if}">
			Event Registration Closed <a href="javascript: toggleRegistration({$Event->getId()}, 1)">(Open Registration)</a>
			<p>
			0 Registrations so far. <a href="">(View)</a>
			</p>
		</div>
	
		
		<div id="reg_close_process" style="display:none">
			<img src="{$template_dir}/images/process.gif" />&nbsp;Closing Registration
		</div>
		
		<div id="reg_open_process" style="display:none">
			<img src="{$template_dir}/images/process.gif" />&nbsp;Opening Registration
		</div>
		
	</div>
	
	<form id="event_form" method="post" action="process/add_event.php">
	
	<div id="button_set">
	
		<input type="hidden" name="event_title" value="{ $post_back.event_title }" />
		<input type="hidden" name="start_time" value="{ $post_back.start_time }" />
		<input type="hidden" name="stop_time" value="{ $post_back.stop_time }" />
		<input type="hidden" name="start_m" value="{ $post_back.start_m }" />
		<input type="hidden" name="stop_m" value="{ $post_back.stop_m }" />
		<input type="hidden" name="no_time" value="{ $post_back.no_time }" />
		<input type="hidden" name="text_time" value="{ $post_back.text_time }" />
		<input type="hidden" name="event_desc" value="{ $post_back.event_desc }" />
		{section name=cal loop=$post_back.calendar_id}<input type="hidden" name="calendar_id[]" value="{ $post_back.calendar_id[cal] }" />{/section}
		<input type="hidden" name="start_day" value="{ $post_back.start_day }" />
		<input type="hidden" name="start_month" value="{ $post_back.start_month }" />
		<input type="hidden" name="start_year" value="{ $post_back.start_year }" />
		<input type="hidden" name="stop_day" value="{ $post_back.stop_day }" />
		<input type="hidden" name="stop_month" value="{ $post_back.stop_month }" />
		<input type="hidden" name="stop_year" value="{ $post_back.stop_year }" />
		<input type="hidden" name="event_type" value="{ $post_back.event_type }" />
		<input type="hidden" name="location_id" value="{ $post_back.location_id }" />
		<input type="hidden" name="contact_id" value="{ $post_back.contact_id }" />
		<input type="hidden" name="attachment_ids" value="{ $post_back.attachment_ids }" />
		<input type="hidden" name="event_tags" value="{ $post_back.event_tags }" />
		<input type="hidden" name="allow_register" value="{ $post_back.allow_register }" />
		<input type="hidden" name="capacity" value="{ $post_back.capacity }" />
		<input type="hidden" name="date_string" value="{ $post_back.date_string }" />
		<input type="hidden" name="published" id="published" />
	<div style="float: left; clear: both;">
		
		<input type="button" class="action_button" value="Save as Draft" onclick ="javascript: submitEventData(0)" />
	</div>
	
	<div style="float: right; text-align: right">
		
		<input type="button" class="action_button" value="Publish Event" onclick ="javascript: submitEventData(1)" />
		<input type="button" class="action_button" value="Edit Event" onclick ="javascript: returnToEventForm()" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = 'eventlist.php'" />
	</div>
	
	</form>

</div>

</div>


