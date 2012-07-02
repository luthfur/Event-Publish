<form method="post" action="install.php">
<div id="installer_body">
	
	<div id="install_info">
	
	<h3>Database Connection</h3>
	
	<div class="error" style="display: {if $error.dbinfo || $error.db_connection}block{else}none{/if}">		
		<img src="{$template_dir}images/warning.gif" />&nbsp;&nbsp;The installer was unable to connect to your database. Please recheck the database information.
	</div>
	
	<div class="error" style="display:  {if $error.db_name}block{else}none{/if}">		
		<img src="{$template_dir}images/warning.gif" />&nbsp;&nbsp;Please specify the name of your MySQL database you wish to use.
	</div>
	
	<div class="error" style="display:  {if $error.db_selection}block{else}none{/if}">		
		<img src="{$template_dir}images/warning.gif" />&nbsp;&nbsp;The installer was unable to find the database: {$post_back.db_name}.
	</div>
	
	<p><label>Database Hostname:</label> <input type="text" name="db_hostname" value="{$post_back.db_hostname}"  size="30"/></p>
	<p><label>Database Username:</label> <input type="text" name="db_username" value="{$post_back.db_username}" /></p>
	<p><label>Database Password:</label> <input type="password" name="db_password" value="{$post_back.db_password}" /></p>
	<p><label>Database Name:</label> <input type="text" name="db_name" value="{$post_back.db_name}" /></p>
	</p>
	
	
	<h3>New Administration Account</h3>
	
	<div class="error" style="display:  {if $error.accounts}block{else}none{/if}">	
		<img src="{$template_dir}images/warning.gif" />&nbsp;&nbsp;One or more fields below are empty or invalid.
	</div>
	
	<p>
		<label>Name:</label> <input type="text" name="full_name" value="{$post_back.full_name}" size="30" />
		
	</p>
	
	<p>
		<label>Email:</label> <input type="text" name="email" value="{$post_back.email}" size="30" />
		<span class="error" style="display:  {if $error.email}inline{else}none{/if}">	
			<img src="{$template_dir}images/warning.gif" />&nbsp;&nbsp;Invalid email address.
		</span>
	</p>
	<p>
		<label>Username:</label> <input type="text" name="username" value="{$post_back.username}" />
		<span class="error" style="display:  {if $error.username}inline{else}none{/if}">	
			<img src="{$template_dir}images/warning.gif" />
		</span>
		
	</p>
	<p>
		<label>Password: </label><input type="password" name="password" value="{$post_back.password}" />
		<span class="error" style="display:  {if $error.password}inline{else}none{/if}">	
			<img src="{$template_dir}images/warning.gif" />
		</span>
	</p>
	<p>
		<label>Confirm Password: </label><input type="password" name="confirm_password" value="{$post_back.confirm_password}" />
		<span class="error" style="display:  {if $error.confirm_password}inline{else}none{/if}">	
			<img src="{$template_dir}images/warning.gif" />
		</span>
		
		<span class="error" style="display:  {if $error.password_compare}inline{else}none{/if}">	
			<img src="{$template_dir}images/warning.gif" />&nbsp;&nbsp;Passwords did not match.
		</span>
	</p>
	
	</div>
	
	




</div>

	<p>&nbsp;</p>
		<input type="submit" value="Install Database and Account" class="next_button" />
		<p>&nbsp;</p>
	</form>