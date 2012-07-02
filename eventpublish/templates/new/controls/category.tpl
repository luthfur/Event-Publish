<div id="section_title">
	<h1>Calendars</h1>
	
	<p>
	Manage all calendars in the system.
	</p>
</div>


<div id="manage_calendar">

		<div id="calendar_list">
		
		
		{section name=cat loop=$Categories}
							
			<div id="category_{$Categories[cat]->getId()}" class="category">
		
				<!-- ############ Category ########################## -->
				<h3>{$Categories[cat]->getName()}<span class="processing" style="display:none">Deleting...</span></h3>
				<div class="category_tools">
					<a href="javascript: void(0)" onclick="showNewCalendarForm(this)">Add Calendar</a>
					<a href="javascript: void(0)" onclick="deleteCategory(this)">Delete</a>
					<a href="javascript: void(0)"  onclick="showEditCategoryForm(this)">Edit</a>
				</div>
				
				
				<!-- #### Edit Category #### -->
				<div id="edit_category_{$Categories[cat]->getId()}" class="new_calendar" style="display: none">
					<p>
					Edit Category: <input type="text" size="30" value="" class="new" id="new_category_name_{$Categories[cat]->getId()}" />
											
						<input type="button" class="save_button" value="Save" onclick="updateCategory(this)" />
						<a href="javascript: void(0)" onclick="cancelEditCategoryForm(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
					</p>
				</div>
				
				
				<!-- #### New Calendar #### -->
				<div id="new_calendar_{$Categories[cat]->getId()}" class="new_calendar" style="display: none">
					<p>
					New Calendar: <input type="text" size="30" value="" class="new" id="new_calendar_name_{$Categories[cat]->getId()}" />
											
						<input type="button" class="save_button" value="Save" onclick="addNewCalendar(this)" />
						<a href="javascript: void(0)" onclick="cancelNewCalendarForm(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
					</p>
				</div>
						
			
			{assign var=Calendars value=$Categories[cat]->getCalendars()}
			
			<div id="calendar_set_{$Categories[cat]->getId()}">
			
			{section name=cal loop=$Calendars}			
				
				<!-- ######## Start Calendar ######## -->
				<div id="calendar_{$Calendars[cal]->getId()}" onmouseover="showCalendarTools(this)" onmouseout="hideCalendarTools(this)" class="calendar_details">
					<h3>{$Calendars[cal]->getName()}</h3>
					<div id="calendar_stat_{$Calendars[cal]->getId()}" class="calendar_stat"><p>{$Calendars[cal]->getTotalEvents()} Events Published <span class="processing" style="display:none">Deleting...</span></p></div>
					
					<div id="calendar_tools_{$Calendars[cal]->getId()}" class="calendar_tools" style="display: none">
						<a href="javascript: void(0)" onclick="showEditCalendar(this)">Edit</a>
						<a href="javascript: void(0)" onclick="deleteCalendar(this)">Delete</a>
						<a href="javascript: void(0)" onclick="showMoveCalendar(this)">Move</a>
										
					</div>
					
					
					<!-- ###### Move Calendar ####### -->					
					<div id="calendar_move_{$Calendars[cal]->getId()}" class="calendar_tool_form" style="display: none">
						<p>
						Move this Calendar to:
						<select id="calendar_move_to_{$Calendars[cal]->getId()}" class="select_box">
						
						</select>
						
						<input type="button"  class="save_button" value="Move" onclick="moveCalendar(this)" />
						<a href="javascript: void(0)" onclick="cancelMoveCalendar(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
						</p>
						
					</div>
					
					<!-- ###### Edit Calendar ####### -->
					<div id="calendar_edit_{$Calendars[cal]->getId()}" class="calendar_tool_form" style="display: none">
						<p>
						Edit Calendar Name:
						<input type="text" size="30" value="Company Meetings" id="calendar_name_to_{$Calendars[cal]->getId()}" class="new" />
							
						
						<input type="button"  class="save_button" value="Save"  onclick="updateCalendar(this)" />
						<a href="javascript: void(0)" onclick="cancelEditCalendar(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
						
						</p>
						
					</div>
					
				</div>				
				<!-- ######## End Calendar ######## -->
				
			{/section}
				</div>
			</div>					
		{/section}
		
		
		
			<!-- ######## Start Category Template ######## -->	
			<div id="category_template" class="category" style="display: none">
		
				<!-- ############ Category ########################## -->
				<h3>Category Template </h3><span class="processing" style="display:none">Deleting...</span>
				<div class="category_tools">
					<a href="javascript: void(0)" onclick="showNewCalendarForm(this)">Add Calendar</a>
					<a href="javascript: void(0)" onclick="deleteCategory(this)">Delete</a>
					<a href="javascript: void(0)"  onclick="showEditCategoryForm(this)">Edit</a>
				</div>
				
				
				<!-- #### Edit Category #### -->
				<div id="edit_category_template" class="new_calendar" style="display: none">
					<p>
					Edit Category: <input type="text" size="30" value="" class="new" id="new_category_name_template" />
											
						<input type="button" class="save_button" value="Save" onclick="updateCategory(this)" />
						<a href="javascript: void(0)" onclick="cancelEditCategoryForm(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
					</p>
				</div>
				
				
				<!-- #### New Calendar #### -->
				<div id="new_calendar_template" class="new_calendar" style="display: none">
					<p>
					New Calendar: <input type="text" size="30" value="" class="new" id="new_calendar_name_template" />
											
						<input type="button" class="save_button" value="Save" onclick="addNewCalendar(this)" />
						<a href="javascript: void(0)" onclick="cancelNewCalendarForm(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
					</p>
				</div>
									
				<div id="calendar_set_template">
				</div>
			</div>	
			<!-- ######################################## -->
			
			
			<!-- ######## Start Calendar Template ######## -->
				<div id="calendar_details_template" onmouseover="showCalendarTools(this)" onmouseout="hideCalendarTools(this)" class="calendar_details" style="display:none">
					<h3>Template</h3>
					<div id="calendar_stat" class="calendar_stat"><p>0 Events Published <span class="processing" style="display:none">Deleting...</span></p></div>
					
					<div id="calendar_tools" class="calendar_tools" style="display: none">
						<a href="javascript: void(0)" onclick="showEditCalendar(this)">Edit</a>
						<a href="javascript: void(0)" onclick="deleteCalendar(this)">Delete</a>
						<a href="javascript: void(0)" onclick="showMoveCalendar(this)">Move</a>
											
					</div>
					
					
					<!-- ###### Move Calendar ####### -->					
					<div id="calendar_move" class="calendar_tool_form" style="display: none">
						<p>
						Move this Calendar to:
						<select id="calendar_move_to" class="select_box" >
							
							{section name=cat2 loop=$Categories}
							<option value="{$Categories[cat2]->getId()}">{$Categories[cat2]->getName()}</option>
							{/section}
							
						</select>
						
						<input type="button"  class="save_button" value="Move" onclick="moveCalendar(this)" />
						<a href="javascript: void(0)" onclick="cancelMoveCalendar(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
						
						</p>
						
					</div>
					
					<!-- ###### Edit Calendar ####### -->
					<div id="calendar_edit" class="calendar_tool_form" style="display: none">
						<p>
						Edit Calendar Name:
						<input type="text" size="30" value="Company Meetings" id="calendar_name_to" class="new" />
							
						
						<input type="button"  class="save_button" value="Save"  onclick="updateCalendar(this)" />
						<a href="javascript: void(0)" onclick="cancelEditCalendar(this)">Cancel</a>
						<span class="processing" style="display:none">Saving...</span>
						
						</p>
						
					</div>
					
				</div>				
				<!-- ######## End Calendar Template ######## -->
				
		</div>
		
		<div id="info_bar">
		
			
			<div id="create_new_category">
				<a href="javascript: showNewCategoryForm()">
					<img src="{$template_dir}images/createNewCategory.gif" border="0" onmouseover="javascript: this.src='{$template_dir}images/createNewCategory_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/createNewCategory.gif'" />
				</a>
			</div>
			
			<div id="new_category" style="display: none">
				<p>
					 
				</p>
				
				<p>
					<strong>Create a New Category:</strong>
				</p>
				
				<p>
					<input type="text" id="category_name" size="20" class="new" />
				</p>
				
				<p style="text-align: right; width: 90%">
					<span class="processing" style="display:none">Saving...</span><a href="javascript: cancelNewCategoryForm()">Cancel</a><input type="button" value="Create" onclick="addNewCategory()" />
				</p>
			</div>
						
			<div class="calendar_tip">
				<p>
					The system is now in <strong>{$system_mode} mode.</strong> 
				</p>
				
				<p>
					Calendar categories are <strong>{$category_mode}.</strong> 
				</p>

			</div>
			
			
			<div class="calendar_tip">
				<p>
					<strong>Quick Tip</strong> 
				</p>
				
				<p>
					You can disable calendar categories at the Settings section of this control panel.
				</p>

			</div>
			
			
			
			<div class="calendar_tip">
				<p>
					<strong>What are publish modes?</strong>
				</p>
				
				<p>
					Modes allow you to customize how you want to publish your events.
				</p>
				
				<p>
					In Multiple Calendar mode, your visitors will be able to browse and view events by calendars. Each calendar can have events from different locations in them.
				</p>
				
				<p>
					In Single Calendar mode, all your events will be published to a single calendar. Visitors will still be able to filter events by locations.
				</p>
				
				<p>
					In Location Calendar mode, your events will be automatically published to separate 

calendars for each location.

				</p>
				
				<p>
					You can change the mode at the Settings section of the control panel.

				</p>
				
			</div>
			
		</div>
		
	<div style="clear: both"></div>

</div>