<div id="location_details_title">
	<h1>{if $method == update}Location changes have been saved.{else}Location successfully added.{/if}</h1>
</div>

<div id="location_main_details">

<p>
	<label>Location Name:</label>

	
	{$post_back.location_title}
	
</p>
	

<p>

	<label>Address Line 1:</label> {$post_back.location_address1}
	

</p>


<p>

	<label>Address Line 2:</label> {$post_back.location_address2}
	

</p>

<p>

	<label>City:</label> {$post_back.location_city}
	

</p>


<p>

	<label>State:</label> {$post_back.location_state}
	

</p>

<p>

	<label>Zip:</label> {$post_back.location_zip}
	

</p>


<p>

	<label>Phone:</label> {$post_back.location_phone}
	

</p>



<p>

	<label>Fax:</label> {$post_back.location_fax}
	

</p>



<p>

	<label for="event_desc">Description:</label><br />
	{$post_back.location_desc}
</p>



<div id="location_details_button_set">
	
	
	{if $method == add}
		
	<div style="float: right; text-align: right">
		<input type="button" class="action_button" value="Add Another Location" onclick ="javascript: window.location = '{$main_path}locform.php'" />
		<input type="button" class="action_button" value="Return to Location List" onclick ="javascript: window.location = '{$main_path}loclist.php'" />
	</div>
	
	{/if}
	
	{if $method == update}
		
	<div style="float: right; text-align: right">
		<input type="button" class="action_button" value="Edit Again" onclick ="javascript: window.location = '{$main_path}locedit.php?id={$post_back.location_id}'" />
		<input type="button" class="action_button" value="Return to Location List" onclick ="javascript: window.location = '{$main_path}loclist.php'" />
	</div>
	
	{/if}

</div>

<div style="clear: both"></div>

</div>
