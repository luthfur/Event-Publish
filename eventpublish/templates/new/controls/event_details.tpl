<div id="section_title">
	<h1>Event Details</h1>
</div>


<div id="event_details_header"> 
	
	<div id="event_details_heading">
			<span id="event_details_cancelled" style="display:{if $Event->isPublished() && $Event->isCancelled()}inline{else}none{/if}">Status: Cancelled</span>
			<span id="event_details_published" style="display:{if $Event->isPublished() && !$Event->isCancelled()}inline{else}none{/if}">Status: Published to Calendar</span>
			<span id="event_details_draft" style="display:{if !$Event->isPublished()}inline{else}none{/if}">Status: Not Published (Draft)</span>
	</div>
	
	<div id="event_details_controls">
		
		<div id="event_action_process" style="display:none">
			&nbsp;Saving changes...
		</div>
		
		<a href="eventedit.php?id={$Event->getId()}" id="edit_event_link"><img src="{$template_dir}images/edit.gif" style="border: 0"  onmouseover="javascript: this.src='{$template_dir}images/edit_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/edit.gif'" /></a>
		<a href="javascript: setEventPublish({$Event->getId()}, 0)" id="draft_event_link" style="display:{if $Event->isPublished() && !$Event->isCancelled()}inline{else}none{/if}"><img src="{$template_dir}images/setdraft.gif" style="border: 0"  onmouseover="javascript: this.src='{$template_dir}images/setdraft_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/setdraft.gif'" /></a><a href="javascript: setEventCancel({$Event->getId()}, 0)" id="republish_event_link" style="display:{if $Event->isCancelled() && $Event->isPublished()}inline{else}none{/if}"><img src="{$template_dir}images/edit_event.gif" style="border: 0" /></a><a href="javascript: setEventCancel({$Event->getId()}, 1)" id="cancel_event_link" style="display:none"><img src="{$template_dir}images/publish.gif" style="border: 0"  onmouseover="javascript: this.src='{$template_dir}images/publish_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/publish.gif'" /></a>
		<a href="javascript: setEventPublish({$Event->getId()}, 1)" id="publish_event_link" style="display:{if $Event->isPublished()}none{else}inline{/if}"><img src="{$template_dir}images/publish.gif" style="border: 0"  onmouseover="javascript: this.src='{$template_dir}images/publish_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/publish.gif'" /></a>
		<a href="process/delete_event.php?event_id={$Event->getId()}" id="delete_event_link" onclick="javascript: return confirm('Are you sure you want to delete this event?')"><img src="{$template_dir}images/delete.gif" style="border: 0"  onmouseover="javascript: this.src='{$template_dir}images/delete_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/delete.gif'" /></a>
		
	</div>
	
	<div style="clear:both"></div>
	
</div>	

<div id="event_details">

	<div id="event_details_title">
			{if $Event->getTitle()}{$Event->getTitle()}{else}(No title Specified){/if}
	</div>
	
	
	{if $schedule_count}
	<div id="event_details_occ">
		
		
		{section name=sch loop=$ScheduleInfo}
		
			<p>{$ScheduleInfo[sch]->getRecurrenceString()}: {$ScheduleInfo[sch]->getRangeString()}</p>
			
	
		{/section}
		
			
			<div style="clear: both"></div>
			
	</div>
	{/if}
	
	{if $schedule_count}
	<div id="event_schedule_details">		
			
			<strong>Time:</strong> 
			{* Display Time *}
			{$event_time}
					
	</div>
	{/if}
	
	{if $Location->getId()}
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
		
	{assign var=ContactInfo value=$Contact->getContactInfo()}
	{if $Contact->getId()}
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
	
	
	
	{if $calendar_in_details == 1} {if count($Calendars)}
	<div id="event_calendar_details">
		
		
			
			
				<strong>Calendar(s):</strong> 
				{section name=cal loop=$Calendars}{if $smarty.section.cal.index > 0}, {/if}{$Calendars[cal]->getName()}{/section}
		
			
		
	</div>
	{/if}
	{/if}
	
	{if $Event->getTags()}
	
	{assign var=Tags value=$Event->getTags()}
	
	<div id="event_details_tags">
	
			<b>Tags:</b> {section name=tg loop=$Tags}{if $smarty.section.tg.index > 0}, {/if}{$Tags[tg]}{/section}
		
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
			{if $Event->getCapacity()}Capacity: {$Event->getCapacity()}{/if}
			</p>
			<p>
			0 Registrations so far. <a href="">(View)</a>
			</p>
		</div>
	
		
		<div id="reg_info_closed" style="display: {if $Event->allowRegistration()}none{else}block{/if}">
			Event Registration Closed <a href="javascript: toggleRegistration({$Event->getId()}, 1)">(Open Registration)</a>
			<p>
			{if $Event->getCapacity()}Capacity: {$Event->getCapacity()}{/if}
			</p>
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

</div>
