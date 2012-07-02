<div id="section_title">
	<h1>{if $method == update}Update Contact{else}Add A New Contact{/if}</h1>
	
	<p>
	{if $method == update}
	Use the form below to edit information for this contact. Click Cancel to return to Contact List.
	{else}
	Use the form below to add a new contact.
	{/if}
	</p>
</div>

<div id="new_main_contact">

<form id="contact_main_form" method="post" action="{$main_path}process/{$method}_main_contact.php">


<p>
	<label for="event_title">Full Name: <i>(Required)</i></label>
			
	<input type="text" size="45" class="field" id="contact_name" name="contact_name" value="{$post_back.contact_name}">
	 <span class="field_error" id="contact_name_error" style="display: {if $error.contact_name}inline{else}none{/if}">
			<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
			Contact Name is required
		 </span>
</p>



<p>

	<label for="text_time">Email Address:</label>
		 
	<input type="text" size="45" class="field" name="contact_email" value="{$post_back.contact_email}">
		
	<span class="field_error" id="contact_email_error" style="display: {if $error.contact_email}inline{else}none{/if}">
			<img src="{$template_dir}/images/warning.gif" alt="warning icon" />
			Invalid Email Address
		 </span>
	
</p>
	

<p>

	<label for="text_time">Address Line 1:</label>
	<input type="text" size="45" class="field" name="contact_address1" value="{$post_back.contact_address1}">
	

</p>


<p>

	<label for="text_time">Address Line 2:</label>
	<input type="text" size="45" class="field" name="contact_address2" value="{$post_back.contact_address2}">
	

</p>

<p>

	<label for="text_time">City:</label>
	<input type="text" size="30" class="field" name="contact_city" value="{$post_back.contact_city}">
	

</p>


<p>

	<label for="text_time">State:</label>
	<input type="text" size="30" class="field" name="contact_state" value="{$post_back.contact_state}">
	

</p>


<p>

	<label for="text_time">Phone:</label>
	<input type="text" size="20" class="field" name="contact_phone" value="{$post_back.contact_phone}">
	

</p>



<p>

	<label for="text_time">Fax:</label>
	<input type="text" size="20" class="field" name="contact_fax" value="{$post_back.contact_fax}">
	

</p>

<p>

	<label for="text_time">Cell:</label>
	<input type="text" size="20" class="field" name="contact_cell" value="{$post_back.contact_cell}">
	

</p>



<div id="contact_details_button_set">
	
	
	{if $method == add}
		
	<div style="float: right; text-align: right; width: 100%">
		<input type="button" class="action_button" value="Add Contact" onclick ="javascript: submitContactForm()" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = 'contactlist.php'" />
	</div>
	
	{/if}
	
	{if $method == update}
		
	<div style="float: right; text-align: right; width: 100%">
		<input type="hidden" name="contact_id" value="{ $post_back.contact_id }" />
		<input type="button" class="action_button" value="Save Changes" onclick ="javascript: submitContactForm()" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location = 'contactlist.php'" />
	</div>
	
	{/if}

</div>

</form>

<div style="clear: both"></div>

</div>