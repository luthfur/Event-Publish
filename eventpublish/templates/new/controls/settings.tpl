<div id="section_title">
	<h1>Settings</h1>
	
	<p>
	Customize Event Publish to your needs.
	</p>
</div>

<div id="settings">
			
			<form action="process/save_settings.php" method="post">
			
			<h3>Calendar Display Settings</h3>
			<div class="setting_set">
			<p>
				<label>Event publishing mode:</label>
				<input type="radio" name="event_publish_mode" value="multi" {if $setting_data.event_publish_mode == 'multi'}checked {/if}/>&nbsp;Multiple Calendars &nbsp;&nbsp;
				<input type="radio" name="event_publish_mode" value="single" {if $setting_data.event_publish_mode == 'single'}checked {/if} />&nbsp;Single Calendar &nbsp;&nbsp;
				<input type="radio" name="event_publish_mode" value="location" {if $setting_data.event_publish_mode == 'location'}checked {/if} />&nbsp;Location Calendars
			</p>
			
			<p>
				<label>Enable calendar categories:</label>
				<input type="radio" name="category_enable" value="1" {if $setting_data.category_enable == 1}checked {/if}/>&nbsp;Yes &nbsp;&nbsp;
				<input type="radio" name="category_enable" value="0" {if $setting_data.category_enable == 0}checked {/if} />&nbsp;No &nbsp;&nbsp;
				(Applies to Multiple Calendar Mode only.)
			</p>
			
			<p>
				<label>Default calendar view:</label>
				<select name="default_calendar_view">
					<option value="day" {if $setting_data.default_calendar_view == 'day'}selected {/if}>Day View</option>
					<option value="week" {if $setting_data.default_calendar_view == 'week'}selected {/if}>Week View</option>
					<option value="month" {if $setting_data.default_calendar_view == 'month'}selected {/if}>Month View</option>
					<option value="year" {if $setting_data.default_calendar_view == 'year'}selected {/if}>Year View</option>
				</select>
			</p>
			
			<p>
				<label>Month calendar display:&nbsp;&nbsp;</label>
				<input type="radio" name="month_view" value="list" {if $setting_data.month_view == 'list'}checked {/if} />&nbsp;List &nbsp;&nbsp;
				<input type="radio" name="month_view" value="block" {if $setting_data.month_view == 'block'}checked {/if} />&nbsp;Block &nbsp;&nbsp;
			</p>
			</div>
						
			
			<h3>Week Settings</h3>			
			
			
			<div class="setting_set">
			
			<p>
				<label>Start of the week:</label>
				<select name="start_week">
					<option value="6" {if $setting_data.start_week == 6}selected {/if}>Saturday</option>
					<option value="0" {if $setting_data.start_week == 0}selected {/if}>Sunday</option>
					<option value="1" {if $setting_data.start_week == 1}selected {/if}>Monday</option>
					<option value="2" {if $setting_data.start_week == 2}selected {/if}>Tuesday</option>
					<option value="3" {if $setting_data.start_week == 3}selected {/if}>Wednesday</option>
					<option value="4" {if $setting_data.start_week == 4}selected {/if}>Thursday</option>
					<option value="5" {if $setting_data.start_week == 5}selected {/if}>Friday</option>
				</select>
			</p>
			
			<p><label>Start of weekend:</label>
				
				<select name="weekend">
					<option value="6" {if $setting_data.weekend == 6}selected {/if}>Saturday</option>
					<option value="0" {if $setting_data.weekend == 0}selected {/if}>Sunday</option>
					<option value="1" {if $setting_data.weekend == 1}selected {/if}>Monday</option>
					<option value="2" {if $setting_data.weekend == 2}selected {/if}>Tuesday</option>
					<option value="3" {if $setting_data.weekend == 3}selected {/if}>Wednesday</option>
					<option value="4" {if $setting_data.weekend == 4}selected {/if}>Thursday</option>
					<option value="5" {if $setting_data.weekend == 5}selected {/if}>Friday</option>
				</select>
				
			</p>
					
			</div>
		
			<h3>Date Display Settings</h3>
			
			<div class="setting_set">
			<p>
			<label>Date format:</label>
				<select name="date_format">
					<option value="0" {if $setting_data.date_format == 0}selected {/if}>January 24, 2008</option>
					<option value="1" {if $setting_data.date_format == 1}selected {/if}>24 January, 2008</option>
					<option value="2" {if $setting_data.date_format == 2}selected {/if}>2008-1-24</option>
					
				</select>
				
			</p>
			
			<p>
				<label>Day of the week format:</label>
				<select name="week_format">
						<option value="0" {if $setting_data.week_format == 0}selected {/if}>Sunday, 24th</option>
						<option value="1" {if $setting_data.week_format == 1}selected {/if}>Sunday, 24</option>
						<option value="2" {if $setting_data.week_format == 2}selected {/if}>24, Sunday</option>
						<option value="3" {if $setting_data.week_format == 3}selected {/if}>24th, Sunday</option>
						
					</select>
			</p>
			</div>
		
	
		
		<h3>System Settings</h3>
		
		<div>
						
		<p>
		<label>Scheduling time intervals:</label>
		<select name="time_intreval">
			<option value="5" {if $setting_data.time_intreval == 5}selected {/if}>5 Minutes</option>
			<option value="15" {if $setting_data.time_intreval == 15}selected {/if}>15 Minutes</option>
			<option value="30" {if $setting_data.time_intreval == 30}selected {/if}>30 Minutes</option>	
			<option value="60" {if $setting_data.time_intreval == 60}selected {/if}>1 Hour</option>
		</select>	
		
		</p>
		
		<p>
			<label>System Time Zone:</label>
			<select name="time_zone">				
				{section name=tz loop=$timezone_identifiers}
					{assign var=tzone value=$timezone_identifiers[tz][1]}
					<option value="{$timezone_identifiers[tz][1]}" {if $tzone == $setting_data.time_zone}selected{/if}>{$timezone_identifiers[tz][1]}</option>
				{/section}
			</select>	
		
		</p>
		
		<p><label>Attachment Directory:</label><input type="text" name="attachment_dir" value="{$setting_data.attachment_dir}" size="40" /></p>
		
		<div style="clear: both"></div>
			
		</div>
		
		

</div>


	<div id="save_settings">
		<input type="hidden" name="url" value="{$setting_data.url}" />
		<input type="submit" value="Save Changes" />
	</div>
	
	</form>