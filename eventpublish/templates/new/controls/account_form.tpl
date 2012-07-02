{assign var=Contact value=$User->getContactInfo()}
{assign var=Account value=$User->getAccount()}
<div id="section_title">
	<h1>Edit Account: {$Account->getUserName()}</h1>
	
	<p>
	Update account information for this user.
	<div style="clear:both"></div>
	</p>
	
	<div style="clear:both"></div>
	
</div>
<div id="account_form">

<form id="account_update" method="post" action="{$main_path}process/update_account.php">

<fieldset>


<p>
	<label for="text_time">Password</label>
	<input type="button" size="45" value="Send New Password" onclick="javascript: sendNewPassword()" id="password_button">

	<span class="field_desc"  id="password_info">		
		( A new password will be emailed to the user )
	</span>
	
	<span class="field_desc" id="sending_message"  style="display:none">		
		Sending new password...(please wait)
	</span>
	
	<span class="field_desc" id="password_sent_message"  style="display:none">		
		Password successfully sent.
	</span>
	
	<span class="field_desc" id="error_sending_password" style="display:none">		
		Error sending password. Please check the email address.
	</span>
</p>

<p>
	<label for="text_time">Full Name:</label>
	<input type="text" size="45" class="field" name="user_full_name" value="{$Contact->getName()}">
	<span class="field_desc">		
		
	</span>
</p>


<p>
	<label for="text_time">Email:</label>
	<input type="text" size="45" class="field" id="user_email" name="user_email" value="{$Contact->getEmail()}">
	<span class="field_error" id="user_email_error" style="display: none"><img src="{$template_dir}images/warning.gif" />Invalid email address.</span>
</p>



<p>
	<label for="text_time">Administrator:</label>
	<input type="checkbox" name="is_admin" value="1" {if $Account->getAccountType() == 1}checked=true{/if} />
	<span class="field_desc">		
		(Check to make this an Administrator account.)
	</span>
	
</p>


</fieldset>

<div style="float: right; text-align: right">
		<input type="hidden" id="current_user_email" name="current_user_email" value="{$Contact->getEmail()}" />
		<input type="hidden" id="account_id" name="account_id" value="{$Account->getAccountId()}" />
		<input type="hidden" id="user_id" name="user_id" value="{$User->getUserId()}" />
		<input type="hidden" id="current_page" name="current_page" value="{$current_page}" />
		<input type="hidden" id="current_order" name="order" value="{$order}" />
		<input type="hidden" id="current_order_by" name="order_by" value="{$order_by}" />
		<input type="button" class="action_button" value="Save Changes" onclick ="javascript: updateAccount()" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location='account.php?p={$current_page}&order={$order}&order_by{$order_by}'" />
	</div>


</form>

<div style="clear: both"></div>

</div>
