<div id="section_title">
	<h1>My Account</h1>
	
	<p>
	View and Edit your account settings.
	</p>
	
	<p id="process_message" {if $result == 0}style="display: none"{/if}>
	<span id="process_success">
	{if $result==1}
		Your new password has been saved.
	{/if}
	</span>
	<span id="process_error">
	{if $result==2}
		Sorry, unable to save your new password. One or more password entries invalid.
	{/if}
	</span>
	</p>
</div>

<div id="settings">
			
			<form action="process/save_my_account.php" method="post">
			
			<h3>Account Details</h3>
			<div class="setting_set">
			<p>
				<label>User Name:</label>
				{$account_data.user_name}
			</p>
			
			<p>
				<label>Name:</label>
				{$account_data.user_full_name}
			</p>
			
			<p>
				<label>Email:</label>
				{$account_data.user_email}
			</p>
			
			</div>
						
			
			<h3>Change Password</h3>			
			
			
			<div class="setting_set">
			
			<p><label>Current Password:</label><input type="password" name="current_password" size="40" value="" /></p>
			
			<p><label>New Password:</label><input type="password" name="new_password" size="40" value="" /></p>
			
			<p><label>Confirm New Password:</label><input type="password" name="confirm_password" size="40" value="" /></p>
			
					
			</div>
		
		<div style="clear: both"></div>
			
</div>
		



	<div id="save_settings">
		<input type="hidden" name="account_id"  value="{$account_data.account_id}" />
		<input type="submit" value="Save Changes" />
	</div>
	
	</form>