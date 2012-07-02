<div id="contact_details_title">
	<h1>{if $method == update}Contact changes have been saved.{else}Contact successfully added.{/if}</h1>
</div>

<div id="contact_main_details">

<p>
	<label>Full Name:</label>

	
	{$post_back.contact_name}
	
</p>
	
	
<p>

	<label>Email Address:</label> {$post_back.contact_email}

</p>

<p>

	<label>Address Line 1:</label> {$post_back.contact_address1}
	

</p>


<p>

	<label>Address Line 2:</label> {$post_back.contact_address2}
	

</p>

<p>

	<label>City:</label> {$post_back.contact_city}
	

</p>


<p>

	<label>State:</label> {$post_back.contact_state}
	

</p>


<p>

	<label>Phone:</label> {$post_back.contact_phone}
	

</p>



<p>

	<label>Fax:</label> {$post_back.contact_fax}
	

</p>


<p>

	<label>Cell:</label> {$post_back.contact_cell}
	

</p>




<div id="contact_details_button_set">
	
	
	{if $method == add}
		
	<div style="float: right; text-align: right">
		<input type="button" class="action_button" value="Add Another Contact" onclick ="javascript: window.location = '{$main_path}contactform.php'" />
		<input type="button" class="action_button" value="Return to Contact List" onclick ="javascript: window.location = '{$main_path}contactlist.php'" />
	</div>
	
	{/if}
	
	{if $method == update}
		
	<div style="float: right; text-align: right">
		<input type="button" class="action_button" value="Edit Again" onclick ="javascript: window.location = '{$main_path}contactedit.php?id={$post_back.contact_id}'" />
		<input type="button" class="action_button" value="Return to Contact List" onclick ="javascript: window.location = '{$main_path}contactlist.php'" />
	</div>
	
	{/if}

</div>



<div style="clear: both"></div>

</div>

