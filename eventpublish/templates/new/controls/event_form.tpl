<div id="section_title">
	<h1>{if $method == update}Update Event{else}Create A New Event{/if}</h1>
	
	<p>
	{if $method == update}
	Use the form below to edit this event. Click Cancel to return to Event Details.
	{else}
	Use the form below to create a new event. You can publish your new event directly to a calendar, or save it as draft for later.
	{/if}
	</p>
</div>

<div id="new_event">

<form id="event_form" method="post" action="{$main_path}process/{$method}_event.php">

<fieldset>


<p>
	<label for="event_title">Event Title: <i>(Required)</i></label>
	
	 <div class="field_error" id="event_title_error" style="display: {if $error.event_title}inline{else}none{/if}">
			<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
			Event title is required.
		 </div>
	
	<br />
	<input type="text" size="45" class="field" id="event_title" name="event_title" value="{$post_back.event_title}">
	<span class="field_desc">
		
		
	</span>
</p>
	

<p>
			
	<label for="start_time">Time:</label>

	<select id="start_time" name="start_time" class="field" {if $post_back.no_time eq on}style="display: none"{/if}>
		{section name=time loop=$time_array}
			<option value="{$time_array[time]}" {if $post_back.start_time eq $time_array[time]}selected{/if}>{$time_array[time]}</option>
		{/section}
	</select>
			
	<select id="start_m" name="start_m" class="field" {if $post_back.no_time eq on}style="display: none"{/if}>
		<option value="0" {if $post_back.start_m eq 0}selected{/if}>am</option>
		<option value="1" {if $post_back.start_m eq 1}selected{/if}>pm</option>
	</select>

		<span id="time_to" {if $post_back.no_time eq on}style="display: none"{/if}>&nbsp;to&nbsp;</span>

	<select id="stop_time" name="stop_time" class="field" {if $post_back.no_time eq on}style="display: none"{/if}>
		{section name=time loop=$time_array}
			<option value="{$time_array[time]}" {if $post_back.stop_time eq $time_array[time]}selected{/if}>{$time_array[time]}</option>
		{/section}
	</select>
	
	<select id="stop_m" name="stop_m" class="field" {if $post_back.no_time eq on}style="display: none"{/if}>
		<option value="0" {if $post_back.stop_m eq 0}selected{/if}>am</option>
		<option value="1" {if $post_back.stop_m eq 1}selected{/if}>pm</option>
	</select>
	&nbsp;&nbsp;
	<input type="checkbox" name="no_time" id="no_time" onclick="toggleTime()"  {if $post_back.no_time eq on}checked{/if} />&nbsp;No Specific Time

</p>

<p>

	<label for="text_time">Text Time:</label>
	<input type="text" size="45" class="field" name="text_time" value="{$post_back.text_time}">
	

</p>


<p>

	<label for="event_desc">Description:</label>
	<textarea cols="60" rows="8" class="field" name="event_desc">{$post_back.event_desc}</textarea>

</p>

{if $show_calendar_selector == 1}
<p>
	<label for="calendar_id">Publish to Calendar(s):<br /><i>(Required)</i></label>
	
	<select name="calendar_id[]" MULTIPLE class="field" id="calendar_id" size="5">
		{section name=cal loop=$Calendars}
			<option value="{$Calendars[cal]->getId()}" {if $post_back.calendar_id}{if in_array($Calendars[cal]->getId(), $post_back.calendar_id)}selected{/if}{elseif count($Calendars) == 1}selected{/if}>{$Calendars[cal]->getName()}</option>
		{/section}
	</select>
	
	<span class="field_desc">
		
		 <div class="field_error" id="calendar_id_error" style="display: {if $error.calendar_id}inline{else}none{/if}">
			<img src="{$template_dir}/images/warning.gif"  alt="warning icon" />
			Select a calendar.
		 </div>
	</span>
</p>
{/if}


{if $show_location_selector == 1}
<p>
	<label for="location_id">Location:<br /><i>(Required)</i></label>
	
	<select name="location_id" id="location_id">
					<option value="0">None Selected</option>
					{section name=loc loop=$Locations}
						<option value="{$Locations[loc]->getId()}" {if $post_back.location_id}{if $Locations[loc]->getId() eq $post_back.location_id}selected{/if}{elseif count($Locations) == 1}selected{/if}>{$Locations[loc]->getTitle()}</option>
					{/section}
	</select>
	
	<span class="field_desc">
		
		 <div class="field_error" id="location_id_error" style="display: {if $error.location_id}inline{else}none{/if}">
			<img src="{$template_dir}/images/warning.gif"  alt="warning icon" />
			Select a location.
		 </div>
	</span>
	
</p>
{/if}

</fieldset>

<div id="tab_nav">
	<ul>
		<li class="select" id="date_select" onClick="javascript: tabSwitch(this)" onMouseOut="javascript: toggleHighlight(this)" onMouseOver="javascript: toggleHighlight(this)"><a href="javascript: void(0)">Date</a></li>
		{if $show_location_tab == 1}
			<li class="basic" id="location_select" onClick="javascript: tabSwitch(this)" onMouseOut="javascript: toggleHighlight(this)" onMouseOver="javascript: toggleHighlight(this)"><a href="javascript: void(0)">Location</a></li>
		{/if}
		<li class="basic" id="contact_select" onClick="javascript: tabSwitch(this)" onMouseOut="javascript: toggleHighlight(this)" onMouseOver="javascript: toggleHighlight(this)"><a href="javascript: void(0)">Contact</a></li>
		<li class="basic"id="attach_select"  onclick="javascript: tabSwitch(this)" onMouseOut="javascript: toggleHighlight(this)" onMouseOver="javascript: toggleHighlight(this)"><a href="javascript: void(0)">Attachments</a></li>
		<li class="basic" id="tag_select" onClick="javascript: tabSwitch(this)" onMouseOut="javascript: toggleHighlight(this)" onMouseOver="javascript: toggleHighlight(this)"><a href="javascript: void(0)">Tags</a></li>
		<li class="basic" id="option_select" style="display: none" onClick="javascript: tabSwitch(this)" onMouseOut="javascript: toggleHighlight(this)" onMouseOver="javascript: toggleHighlight(this)"><a href="javascript: void(0)">Options</a></li>
	</ul>
</div>

<div id="tab_body">
	
	<div id="date_body" style="display: block;">
			
		<div id="date_selection_area">
		
		<fieldset>
				
				<h3 id="date_selection_header">
					Select and Add New Dates:
				</h3>
				
				<p>
				 <div id="date_string_error" style="display: {if $error.date_string eq 1}inline{else}none{/if}">
					<img src="{$template_dir}/images/warning.gif" alt="warning icon" /> Please select a date for this event
				 </div>
				 
				 <div id="start_date_error" style="display: {if $error.start_date eq 1}inline{else}none{/if}">
					Invalid event date.
				 </div>
				 
				  <div id="stop_date_error" style="display: {if $error.stop_date eq 1}inline{else}none{/if}">
					Invalid repeat until date. 
				 </div>
				 
				 
				  <div id="date_compare_error" style="display: {if $error.date_compare eq 1}inline{else}none{/if}">
					Repeat until date must be later than event date.
				 </div>
				 
				 
				</p>
				
				<p>
				<label for="start_day">Event Date: <i>(Required)</i></label>
											
					
					<input type="text" id="start_day" name="start_day" size="2" class="field" value="{if $post_back.start_day}{$post_back.start_day}{else}dd{/if}" maxlength="2">
					<input type="text" id="start_month" name="start_month" size="2" class="field" value="{if $post_back.start_month}{$post_back.start_month}{else}mm{/if}" maxlength="2">
					<input type="text" id="start_year" name="start_year" size="4" class="field" value="{if $post_back.start_year}{$post_back.start_year}{else}yyyy{/if}" maxlength="4">
					<a href="javascript: togglePicker('start_picker')"><img src="{$template_dir}/images/date_picker.gif" style="border: 0; vertical-align: bottom" /></a>
						<span class="field_desc">
							 <div class="field_error" id="start_date_error_symb" style="display: {if $error.start_date eq 1}inline{else}none{/if}">
								<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
							 </div>
						</span>
						<br />						
						
						<div id="start_picker" style="display: none; position: absolute; margin-left: 180px; z-index: 1000">
						
							<!-- ############################### Date Picker ############################## -->

							<table cellpadding="2" cellspacing="0" class="minical">
		
							<tr class="minical_header">
								<td align="right" colspan="1">
									<a href="javascript:StartDatePicker.prevMonth()" title="Go to Previous Month"  id="start_picker_prev_month"><img src="{$template_dir}/images/minical_left.gif" /></a>
									<a href="javascript:StartDatePicker.nextMonth()" title="Go to Next Month" id="start_picker_next_month"><img src="{$template_dir}/images/minical_right.gif" /></a>
								</td>
		
								<td align="left" colspan="1">
									
								</td>
		
								<td align="center" colspan="3" id="start_picker_cal_display" align="center">&nbsp;</td>
									
		
								<td align="center" colspan="1">
									
								</td>
		
								<td align="center" colspan="1">
									<a href="javascript:StartDatePicker.prevYear()" title="Go to Previous Year"  id="start_picker_prev_year"><img src="{$template_dir}/images/minical_left.gif" /></a>
									<a href="javascript:StartDatePicker.nextYear()" title="Go to Next Year" id="start_picker_next_year"><img src="{$template_dir}/images/minical_right.gif" /></a>
								</td>
		
							</tr>
		
							<tr>
								
								<td class="weekday_cell" align="center"><b>S</b></td>
		
								<td class="weekday_cell"  align="center"><b>M</b></td>
		
								<td class="weekday_cell" align="center"><b>T</b></td>
		
								<td class="weekday_cell" align="center"><b>W</b></td>
		
								<td class="weekday_cell" align="center"><b>T</b></td>
		
								<td class="weekday_cell" align="center"><b>F</b></td>
		
								<td class="weekday_cell" align="center"><b>S</b></td>
		
		
		
							</tr>
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
		
							</tr>
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
							</tr>
		
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
		
							</tr>
		
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
		
							</tr>
		
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
		
							</tr>
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'start')">&nbsp;</td>
		
		
		
							</tr>
		
						</table>
						
						<!-- ############################################################################################ -->
						
						
					</div>
				</p>
						
		<p style="z-index: 500">	
	
			<label for="event_type">Repeat Event:</label>
			
				<select name="event_type" id="event_type" class="field" onChange="toggleRepeat(this)">
					<option value="1" {if $post_back.event_type eq 1}selected{/if}>No Repeat</option>
					<option value="2" {if $post_back.event_type eq 2}selected{/if}>Daily</option>
					<option value="3" {if $post_back.event_type eq 3}selected{/if}>Every Tue, Thu</option>
					<option value="4" {if $post_back.event_type eq 4}selected{/if}>Every Mon, Wed, Fri</option>
					<option value="5" {if $post_back.event_type eq 5}selected{/if}>Every Weekday</option>
					<option value="6" {if $post_back.event_type eq 6}selected{/if}>Every Weekend</option>
					<option value="7" {if $post_back.event_type eq 7}selected{/if}>Every Week</option>
					<option value="8" {if $post_back.event_type eq 8}selected{/if}>Every Other Week</option>
					<option value="9" {if $post_back.event_type eq 9}selected{/if}>Every Month</option>
					<option value="10" {if $post_back.event_type eq 10}selected{/if}>Every Year</option>
					<option value="11" {if $post_back.event_type eq 11}selected{/if}>Monthly Periodical</option>
					<option value="12" {if $post_back.event_type eq 12}selected{/if}>Yearly Periodical</option>
					
				</select>
		
		</p>	
		
				
			
		<p style="display: {if $post_back.event_type neq 1 && $post_back.event_type}block{else}none{/if};" id="repeat_until">
					<label for="stop_day">Repeat Until: <i>(Required)</i></label>
		
					<input type="text" id="stop_day" name="stop_day" size="2" class="field" value="{if $post_back.stop_day}{$post_back.stop_day}{else}dd{/if}" maxlength="2">
					<input type="text" id="stop_month" name="stop_month" size="2" class="field"value="{if $post_back.stop_month}{$post_back.stop_month}{else}mm{/if}" maxlength="2">
					<input type="text" id="stop_year" name="stop_year" size="4" class="field" value="{if $post_back.stop_year}{$post_back.stop_year}{else}yyyy{/if}" maxlength="4">
			
					<a href="javascript: togglePicker('stop_picker')"><img src="{$template_dir}/images/date_picker.gif" style="border: 0; vertical-align: bottom" /></a>
						
						<span class="field_desc">
							 <div class="field_error" id="stop_date_error_symb" style="display: {if $error.stop_date eq 1}inline{else}none{/if}">
								<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
							 </div>
							 
							 <div class="field_error" id="date_compare_error_symb" style="display: {if $error.date_compare eq 1}inline{else}none{/if}">
								<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
							 </div>
						</span>
						<br />
						<div id="stop_picker" style="display: none; position: absolute; margin-left: 180px">
						
							<table cellpadding="2" cellspacing="0" class="minical" >
		
							<tr class="minical_header">
								<td align="center" colspan="1">
									<a href="javascript:StopDatePicker.prevMonth()" title="Go to Previous Month"  id="stop_picker_prev_month"><img src="{$template_dir}/images/minical_left.gif" /></a>
									<a href="javascript:StopDatePicker.nextMonth()" title="Go to Next Month" id="stop_picker_next_month"><img src="{$template_dir}/images/minical_right.gif" /></a>
								</td>
		
								<td align="center" colspan="1">
									
								</td>
		
								<td align="center" colspan="3" id="stop_picker_cal_display" align="center">&nbsp;</td>
									
		
								<td align="center" colspan="1">
									
								</td>
		
								<td align="center" colspan="1">
		
									<a href="javascript:StopDatePicker.prevYear()" title="Go to Previous Year"  id="stop_picker_prev_year"><img src="{$template_dir}/images/minical_left.gif" /></a>
									<a href="javascript:StopDatePicker.nextYear()" title="Go to Next Year" id="stop_picker_next_year"><img src="{$template_dir}/images/minical_right.gif" /></a>
								</td>
		
							</tr>
							
									
							<tr>
								
								<td class="weekday_cell" align="center"><b>S</b></td>
		
								<td class="weekday_cell"  align="center"><b>M</b></td>
		
								<td class="weekday_cell" align="center"><b>T</b></td>
		
								<td class="weekday_cell" align="center"><b>W</b></td>
		
								<td class="weekday_cell" align="center"><b>T</b></td>
		
								<td class="weekday_cell" align="center"><b>F</b></td>
		
								<td class="weekday_cell" align="center"><b>S</b></td>
		
		
		
							</tr>
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
		
							</tr>
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
							</tr>
		
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
		
							</tr>
		
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
		
							</tr>
		
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
		
							</tr>
		
		
							<tr>
								
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
								<td class="minical_cell" align="center" onMouseOver="javascript: toggleMiniCalHighlight(this)" onMouseOut="javascript: toggleMiniCalHighlight(this)" onClick="javascript: pickDate(this, 'stop')">&nbsp;</td>
		
		
		
							</tr>
		
						</table>
						</div>
				
		</p>
		
		<div>
			<input type="hidden" name="date_string" id="date_string" value="{$post_back.date_string}" />
			<input type="hidden" id="curr_date_id" value="{if $post_back.curr_date_id}{$post_back.curr_date_id}{else}1{/if}" />
			<input type="hidden" id="date_id" />
			
			<input type="button" onclick="updateDates()" value="Save Changes" style="float: right; margin-right: 5px; display: none" id="save_dates" />
			<input type="button" onclick="deleteDates()" value="Delete" style="float: right; margin-right: 5px; display: none" id="delete_dates" />	
			<input type="button" onclick="showDateAddForm()" value="Add New Dates" style="float: right; margin-right: 5px; display: none" id="add_new_dates" />		
			<input type="button" onclick="addNewDates('{$main_path}')" value="Add Dates" style="float: right; margin-right: 5px;" id="add_dates" />
		
		</div>
		
		
		</fieldset>	
		
		</div>
		
		<div id="selected_dates">
		
			<h1>Event Dates</h1>
			
			{counter start=0 skip=1 print=no}
			{section name=sch loop=$ScheduleInfo}
			<div onclick="javascript: showDateEditForm(this, 1);">
				<p onclick="javascript: showDateEditForm(this, 1);" style="display: none">{counter}</p>
				
				<p onclick="javascript: showDateEditForm(this, 1);">
					{$ScheduleInfo[sch]->getRecurrenceString()}
				</p>
				
				<p onclick="javascript: showDateEditForm(this, 1);">
					{$ScheduleInfo[sch]->getRangeString()}
				</p>			
			</div>
			{/section}
					
		</div>		
		
		<div style="clear: both"></div>
		
	</div>
	
	
	<div id="location_body" style="display: none">
		
		<fieldset>
			<p>
			<label for="location_id">Location: <i>(Optional)</i></label>
				<select id="loc_select" {if $show_location_tab == 1}name="location_id"{/if} onChange="javascript: showLocationDetails()">
					<option value="0">None Selected</option>
					{section name=loc loop=$Locations}
						<option value="{$Locations[loc]->getId()}" {if $post_back.location_id}{if $Locations[loc]->getId() eq $post_back.location_id}selected{/if}{/if}>{$Locations[loc]->getTitle()}</option>
					{/section}
				</select>
				
				<span class="field_desc">
					<a href="javascript: toggleLocationForm()">Add a new Location</a>
				</span>
			</p>
		</fieldset>
		
				
		
		<div id="location_added_message" style="display: none">
			<img src="{$template_dir}/images/notify_info.gif" alt="notification icon" />Location Successfully Added.
		</div>
		
		
		<div id="location_error_message" style="display: none">
			<img src="{$template_dir}/images/error.gif" alt="error icon" />Server Error: Please Try Again.
		</div>
		
		<div id="location_details" style="display: none">
			
			<h2>Orange Bowl</h2>
			
			<p>
			540 Proudfoot Lane<br />
			Apartment 706<br />
			London, ON<br />
			N5J 1D4
			</p>
			
			<p>
			Tel: (519) 564-2345<br />
			Fax: (519) 765-3421<br />
			</p>
					
		</div>
						
		<div id="new_location" style="display: none">
		
				
				<h2>Add a New Location</h2>
				
				<fieldset>
				
					<p>	
					<label for="location_title">Location Title:</label>

					<input type="text" size="30" name="location_title">
					

					<span class="field_desc">
						 <i>(required)</i>
						 <div class="field_error" id="location_title_error" style="display: none">
						 	<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
							Title is required.
						 </div>
					</span>
					</p>
					
					
					
					<p>	
					<label for="location_address1">Address 1:</label>

					<input type="text" size="30" name="location_address1">


					</p>
					
					<p>	
					<label for="location_address2">Address 2:</label>

					<input type="text" size="30" name="location_address2">
															
					</p>
					
					
					<p>	
					
					<label for="location_city">City:</label>

					<input type="text" size="25" name="location_city">
					
										
					</p>
					
					
					<p>
					<label for="location_state">State/Province:</label>

					<input type="text" size="25" name="location_state">
					
										
					</p>
					
					
					<p>

					<label for="location_zip">Zip:</label>

					<input type="text" size="10" name="location_zip">
					
										
					</p>
					
					
					<p>
					<label for="location_phone">Phone:</label>

					<input type="text" size="15" name="location_phone">
					
										
					</p>
					
					<p>

					<label for="location_fax">Fax:</label>

					<input type="text" size="15" name="location_fax">
					
					</p>
								
					
					
					<p>

					<label for="location_desc">Description:</label>

					<textarea cols="40" rows="6" class="field"  name="location_desc"></textarea>
									
						
					</p>
					
								
				</fieldset>
				
				<div class="buttons" id="location_buttons"  style="display:block">
					<input type="button" value="Add Location" onclick="javascript: addLocation()">&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: toggleLocationForm()">
				</div>
				
				<div id="location_process" style="display:none">
						Adding Location...
				</div>
				
				
		</div>	
		
		
		<div style="clear:both"></div>
		
	</div>
	
	
	<div id="contact_body" style="display: none">
		
			<fieldset>
			<p>
			<label for="contact_id">Contact: <i>(Optional)</i></label>
					
			<select id="con_select" name="contact_id" onChange="javascript: showContactDetails()">
				<option value="0">None Selected</option>
				{section name=con loop=$Contacts}
						{assign var=ContactInfo value=$Contacts[con]->getContactInfo()}
						<option value="{$Contacts[con]->getId()}" {if $post_back.location_id}{if $Contacts[con]->getId() eq $post_back.contact_id}selected{/if}{/if}>{$ContactInfo->getName()}</option>
					{/section}
			</select>
			
			<span class="field_desc">
				<a href="javascript: toggleContactForm()">Add a new Contact</a>
			</span>
			
			</p>
			</fieldset>
			
			<div id="contact_added_message" style="display: none">
				<img src="{$template_dir}/images/notify_info.gif" alt="notification icon" />Contact Successfully Added.
			</div>
			
			
			<div id="contact_error_message" style="display: none">
				<img src="{$template_dir}/images/error.gif" alt="error icon" />Server Error: Please Try Again.
			</div>
		
				
		<div id="contact_details" style="display: none">
			
			<h2>John Locke</h2>
			
			<p>
			540 Proudfoot Lane<br />
			Apartment 706<br />
			London, ON<br />
			N5J 1D4
			</p>
			
			<p>
			Email: john@locke.com<br />
			Tel: (519) 564-2345<br />
			Fax: (519) 564-2345<br />
			Cell: (519) 765-3421<br />
			</p>
					
		</div>
		
		
		<div id="new_contact" style="display: none">
		
				
				<h2>Add New Contact</h2>
				
				
				<fieldset>
				
					<p>	
					<label for="contact_name">Full Name:</label>

					<input type="text" size="30" name="contact_name">
					

					<span class="field_desc">
						<i>(required)</i>
						 <div class="field_error" id="contact_name_error" style="display: none">
						 	<img src="{$template_dir}/images/warning.gif"  alt="warning icon" />
							Full name is required.
						 </div>
					</span>
					</p>
					
					<p>	
					<label for="contact_name">Email Address:</label>

					<input type="text" size="30" name="contact_name">
					
					<span class="field_desc">
						<div class="field_error" id="contact_email_error" style="display: none">
						 	<img src="{$template_dir}/images/warning.gif"  alt="warning icon" />
							Invalid email address.
						 </div>
					</span>
					</p>
					
					<p>	
					<label for="contact_address2">Address 1:</label>

					<input type="text" size="30" name="contact_address2">

					<span class="field_desc">
				
					</span>

					</p>
					
					<p>	
					<label for="contact_address1">Address 2:</label>

					<input type="text" size="30" name="contact_address1">
					
					<span class="field_desc">
				
					</span>
										
					</p>
					
					
					<p>	
					
					<label for="contact_city">City:</label>

					<input type="text" size="25" name="contact_city">
					
					<span class="field_desc">
				
					</span>
										
					</p>
					
					
					<p>
					<label for="contact_state">State/Province:</label>

					<input type="text" size="25" name="contact_state">
					
					<span class="field_desc">
				
					</span>
										
					</p>
					
					
					<p>

					<label for="contact_zip">Zip:</label>

					<input type="text" size="10" name="contact_zip">
					
					<span class="field_desc">
				
					</span>
										
					</p>
					
					
					<p>
					<label for="contact_phone">Phone:</label>

					<input type="text" size="15" name="contact_phone">
					
					<span class="field_desc">
				
					</span>
										
					</p>
					
					<p>

					<label for="contact_fax">Fax:</label>

					<input type="text" size="15" name="contact_fax">
					
					<span class="field_desc">
				
					</span>
					</p>
					
					
					<p>

					<label for="contact_cell">Cell:</label>

					<input type="text" size="15" name="contact_cell">
					
					<span class="field_desc">
				
					</span>
					</p>
										
				</fieldset>
				
				
				<div class="buttons" id="contact_buttons">
						<input type="button" value="Add Contact" onclick="javascript: addContact()">&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: toggleContactForm()">
					</div>
					
				
				<div id="contact_process" style="display:none">
						Adding Contact...
				</div>
		
		</div>
				
		<div style="clear:both"></div>
	</div>
	
	
	
	<div id="attach_body" style="display: none;">
		<iframe src="{$main_path}attachmentform.php?file_ids={$post_back.attachment_ids}" style="border: 0; width:100%; height: 318px; margin: 0; padding: 0" frameborder="0" name="attachment_frame" id="attachment_frame">
		</iframe>		
	</div>
	
	
	
	<div id="tag_body" style="display: none">
		
		<fieldset>
		<p>
		<label for="event_tags">Tags: <i>(Optional)</i></label>
		
			<textarea cols="40" rows="4" class="field" name="event_tags">{$post_back.event_tags}</textarea>
			
			<span class="field_desc">
				<div style="clear: both">
				Enter comma separated tags for this event.
				<br /><br />
				
				</div>
			</span>
		
		</p>
		</fieldset>
		
		
		
		<div style="clear:both"></div>
	</div>
	
	
	
	
	<div id="option_body" style="display: none">
		<fieldset>
		
		<p>
		Select to allow attendees to register for this event:				
		</p>
		
		<p>
			<label for="allow_register">Allow Registration:</label>
			<input type="radio" name="allow_register" value="1" {if $post_back.allow_register eq 1}checked{/if}>Yes
			<input type="radio" name="allow_register" value="0" {if $post_back.allow_register eq 0}checked{/if}>No
			
		</p>
		
		<p>
			<label for="capacity">Venue Capacity:</label>
			<input type="text" name="capacity" size="10" value="{$post_back.capacity}">	
			<span class="field_desc">
				Leave blank if there are no capacity constraints.
			</span>		
		</p>
		
		
		
		</fieldset>
		<div style="clear:both"></div>
	</div>
				
</div>





<div id="button_set">
	
	<input type="hidden" id="attachments" name="attachment_ids" />
	
	{if $method == add}
	
	<div style="float: left; clear: both;">
		
		<input type="button" class="action_button" value="Save as Draft" onclick ="javascript: saveEvent('{$event_save_mode}')" />
	</div>
	
	<div style="float: right; text-align: right">
		{if $show_calendar_selector == 0}<input type="hidden" name="calendar_id[]" value="{ $transition_calendar_id }" />{/if}
		<input type="hidden" name="published" id="published" value="{ $post_back.published }" />
		<input type="hidden" name="allow_register" value="0" />
		<input type="button" class="action_button" value="Publish Event" onclick ="javascript: publishEvent('{$event_save_mode}')" />
		<input type="button" class="action_button" value="Preview" onclick ="javascript: previewEvent('{$main_path}','{$event_save_mode}')" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = '{$main_path}eventlist.php'" />
	</div>
	
	{/if}
	
	{if $method == update}
		
	<div style="float: right; text-align: right">
		{if $show_calendar_selector == 0}<input type="hidden" name="calendar_id[]" value="{ $transition_calendar_id }" />{/if}
		<input type="hidden" name="allow_register" value="0" />
		<input type="hidden" name="event_id" value="{ $post_back.event_id }" />
		<input type="hidden" name="published" id="published" value="{ $post_back.published }" />
		<input type="button" class="action_button" value="Save Changes" onclick ="javascript: {if $post_back.published}publishEvent{else}saveEvent{/if}('{$event_save_mode}')" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = '{$main_path}eventdetails.php?id={ $post_back.event_id }'" />
	</div>
	
	{/if}

</div>


</form>


<div style="clear: both"></div>

</div>

