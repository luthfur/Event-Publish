<div id="event_display" class="event_display">
	
			
	<div id="event_title">
		{$Event->getTitle()}			
	</div>		
			
	<div id="event_date">
		{$event_date}
	</div>
	
	{assign var=StartDate value=$ScheduleInfo[0]->getStartDate()}
	{assign var=StopDate value=$ScheduleInfo[0]->getStopDate()}
		
	<div id="event_time">
		{* Display Time *}
		{$event_time}
		{if $Location->getId()}
		at {$Location->getTitle()}
		{/if}
		
	</div>
	
	<div id="event_desc">
			{$Event->getDesc()} 
	</div>
	
	
	
	{if $att_count > 0}
	<div id="event_attachments">
		<strong>More Information:</strong>
		
		{section name=att loop=$Attachments}
		<p>					
			{if $Attachments[att]->getDesc()}{$Attachments[att]->getDesc()}:{/if} <a href="{$att_dir}{$Attachments[att]->getFileName()}" target="_blank">{$Attachments[att]->getFileName()}</a>
		</p>
		{/section}
	</div>	
	{/if}	
	
	
	
	<div id="event_details">
		
		{if $Location->getId()}
			<div id="event_loc_details">
						
				{assign var=Address value=$Location->getAddress()}
				
				<strong>Location: {$Location->getTitle()}</strong>
				<p>							
				{$Address->getAddressLine1()}<br />
				{$Address->getAddressLine2()}<br />
				{$Address->getCity()}{if $Address->getCity() && $Address->getState()},{/if} {$Address->getState()}<br />
				{$Address->getZip()}
				<br /><br />
				{if $Address->getPhone()}Tel: {$Address->getPhone()}<br />{/if}
				{if $Address->getFax()}Fax: {$Address->getFax()}<br />{/if}
				<br />
				{$Location->getDescription()}
				</p>
				<p>&nbsp;</p>
			</div>
		{/if}
			
		{if $Contact->getId()}
			<div id="event_con_details"> 
			{assign var=ContactInfo value=$Contact->getContactInfo()}
			{assign var=Address value=$ContactInfo->getAddress()}
				
				<strong>Contact: {$ContactInfo->getName()}</strong>
					<p>					
						{$Address->getAddressLine1()}<br />
						{$Address->getAddressLine2()}<br />
						{$Address->getCity()}{if $Address->getCity() && $Address->getState()},{/if} {$Address->getState()}<br />
						{$Address->getZip()}
						<br /><br />
						{if $ContactInfo->getEmail()}Email: {$ContactInfo->getEmail()}<br />{/if}
						{if $Address->getPhone()}Tel: {$Address->getPhone()}<br />{/if}
						{if $Address->getFax()}Fax: {$Address->getFax()}<br />{/if}
						{if $ContactInfo->getCell()}Cell: {$ContactInfo->getCell()}<br />{/if}
					</p>		
				<p>&nbsp;</p>	
			</div>
		{/if}
			
				
		</div>
		
		
		<div style="clear: both"></div>
		
		<div>
	<a href="{$curr_view}.{$PHP_EXT}?d={$day}&m={$month}&y={$year}&id={$id}&view={$view}&z={$time_zone}&lid={$location_id}&pv={$private_mode}">
		<img src="{$template_dir}images/backToCalendar.gif" onmouseover="javascript: this.src='{$template_dir}images/backToCalendar_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/backToCalendar.gif'" />
	</a>
	</div>
	
	</div>

