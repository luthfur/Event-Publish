<div id="section_title">
	<h1>{if $method == update}Update Location{else}Create A New Location{/if}</h1>
	
	<p>
	{if $method == update}
	Use the form below to edit this location. Click Cancel to return to Location List.
	{else}
	Use the form below to create a new location and add to the system.
	{/if}
	</p>
</div>

<div id="new_main_location">

<form id="location_main_form" method="post" action="{$main_path}process/{$method}_main_location.php">

<fieldset>


<p>
	<label for="event_title">Location Name: <i>(Required)</i></label>
	
	 <div class="field_error" id="location_name_error" style="display: {if $error.location_name}inline{else}none{/if}">
			<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
			Location Name is required
		 </div>
	
	<br />
	<input type="text" size="45" class="field" id="location_title" name="location_title" value="{$post_back.location_title}">
	<span class="field_desc">
		
		
	</span>
</p>
	

<p>

	<label for="text_time">Address Line 1:</label>
	<input type="text" size="45" class="field" name="location_address1" value="{$post_back.location_address1}">
	

</p>


<p>

	<label for="text_time">Address Line 2:</label>
	<input type="text" size="45" class="field" name="location_address2" value="{$post_back.location_address2}">
	

</p>

<p>

	<label for="text_time">City:</label>
	<input type="text" size="30" class="field" name="location_city" value="{$post_back.location_city}">
	

</p>


<p>

	<label for="text_time">State:</label>
	<input type="text" size="30" class="field" name="location_state" value="{$post_back.location_state}">
	

</p>

<p>

	<label for="text_time">Zip:</label>
	<input type="text" size="20" class="field" name="location_zip" value="{$post_back.location_zip}">
	

</p>


<p>

	<label for="text_time">Phone:</label>
	<input type="text" size="20" class="field" name="location_phone" value="{$post_back.location_phone}">
	

</p>



<p>

	<label for="text_time">Fax:</label>
	<input type="text" size="20" class="field" name="location_fax" value="{$post_back.location_fax}">
	

</p>




<p>

	<label for="event_desc">Description:</label>
	<textarea cols="60" rows="8" class="field" name="location_desc">{$post_back.location_desc}</textarea>

</p>


<div id="location_details_button_set">
	
	
	{if $method == add}
		
	<div style="float: right; text-align: right">
		<input type="button" class="action_button" value="Add Location" onclick ="javascript: submitLocationForm()" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = 'loclist.php'" />
	</div>
	
	{/if}
	
	{if $method == update}
		
	<div style="float: right; text-align: right">
		<input type="hidden" name="location_id" value="{ $post_back.location_id }" />
		<input type="button" class="action_button" value="Save Changes" onclick ="javascript: submitLocationForm()" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = 'loclist.php'" />
	</div>
	
	{/if}

</div>


</form>


<div style="clear: both"></div>

</div>

