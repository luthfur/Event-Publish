

<div id="section_title">
	<h1>Accounts</h1>
		
	<p id="account_list_header">	
		
		<div id="total_account">
		Total accounts in the system: {$total_users}. <a href="javascript: showNewAccountForm()">Add New Account</a>
		</div>
		
		<div id="account_order">		
		<form id="account_order_by" action="{$Smarty.server.PHP_SELF}" method="get">
			Order by: 
		<select name="order_by" onchange="javascript: document.getElementById('account_order_by').submit()">
			<option value="1" {if $order_by == 1}selected{/if}>User Name</option>
			<option value="2" {if $order_by == 2}selected{/if}>Full Name</option>
			<option value="3" {if $order_by == 3}selected{/if}>Email Address</option>
		</select>
		
		<select name="order" onchange="javascript: document.getElementById('account_order_by').submit()">
			<option value="1" {if $order == 1}selected{/if}>Ascending</option>
			<option value="2" {if $order == 2}selected{/if}>Descending</option>
		</select>
		
		<input type="hidden" name="p" value="{$current_page}" />
		</form>
	
			<div style="clear:both"></div>
		</div>
	
		<div style="clear:both"></div>
	</p>
	
	<p id="process_message" {if $tsk == 0}style="display: none"{/if}>
	<span id="process_success">
	{if $tsk==1 && $return == 1}
		New Account successfully created
	{/if}
	
	{if $tsk==2 && $return == 1}
		Account updates saved
	{/if}
		
	{if $tsk==3 && $return == 1}
		Account successfully deleted.
	{/if}	
	
	</span>
	<span id="process_error">
	{if $tsk==1 && $return == 0}
		Unable to Create New Account
	{/if}
	
	{if $tsk==2 && $return == 0}
		Unable to Save Account Updates
	{/if}
		
	{if $tsk==3 && $return == 0}
		Unable to Delete Account
	{/if}	
	
	{if $error_send_email == 1}
		( Error sending welcome email )
	{/if}	
	
	</span>
	</p>
	
	<div style="clear:both"></div>
	
</div>

<div id="new_account" style="display: {if count($error)}block{else}none{/if}">
	
	<h1>Create New Account</h1>
	
	<form id="new_account_form" action="{$main_path}process/add_account.php" method="post">
	
	<p>
		<span class="new_account_field">Username:</span><input type="text" size="25" id="user_name" name="user_name" value="{$post_back.user_name}"/> 
		<span class="field_error" id="user_name_error" style="display: {if $error.user_name}inline{else}none{/if}"><img src="{$template_dir}images/warning.gif" />User name required.</span>
		<span class="field_error" id="user_exists_error" style="display: {if $error.user_name_exists}inline{else}none{/if}"><img src="{$template_dir}images/warning.gif" />User name already exists.</span>
	</p>
	
	<p>
		<span class="new_account_field">Password:</span><input type="text" size="25" id="password" name="password" value="{$post_back.password}"  {if $post_back.auto_password == 1}style="display:none"{/if} />&nbsp;&nbsp;<input type="checkbox" name="auto_password" id="auto_password" onclick="javascript: togglePassword()" value="1" {if $post_back.auto_password == 1}checked="true"{/if} /> Auto generate password 
		 <span class="field_error" id="password_error" style="display: {if $error.password}inline{else}none{/if}"><img src="{$template_dir}images/warning.gif" />Password required.</span>

	</p>
	
	<p>
		<span class="new_account_field">Full Name:</span><input type="text" size="35"  id="user_full_name" name="user_full_name" value="{$post_back.user_full_name}" />
		
	</p>
	
	<p>
		<span class="new_account_field">Email:</span><input type="text" size="35" id="user_email" name="user_email" value="{$post_back.user_email}" />
		<span class="field_error" id="user_email_error" style="display: {if $error.user_email}inline{else}none{/if}"><img src="{$template_dir}images/warning.gif" />Invalid email address.</span>
	</p>
	
	<p>
		<span class="new_account_field">Administrator:</span><input type="checkbox" name="is_admin"  value="1" {if $post_back.is_admin == 1}checked="true"{/if} /> <span class="new_account_desc">(Check to make this an Administrator account.)</span>
	</p>
	
	<p id="new_account_button">
		<input type="hidden" id="current_page" name="current_page" value="{ $current_page }" />
		<input type="hidden" id="current_order" name="current_order" value="{ $order }" />
		<input type="hidden" id="current_order_by" name="current_order_by" value="{ $order_by }" />
		<a href="javascript: hideNewAccountForm()">Cancel</a>&nbsp;&nbsp;<input type="button"  onclick="javascript: addNewAccount()" value="Add Account" /><span class="processing" style="display: none">Saving...</span>
	</p>
	</form>
	
</div>


<div id="edit_account" style="display: none">
	
	<h1>Edit: cosmo</h1>
			
	<p>
		<span class="new_account_field">Password:</span><a href="">Reset Password</a> <span class="new_account_desc">(Newly generated password will be emailed user.)</span>
	</p>
	
	<p>
		<span class="new_account_field">Full Name:</span><input type="text" size="35" />
	</p>
	
	<p>
		<span class="new_account_field">Email:</span><input type="text" size="35" />
	</p>
	
	<p>
		<span class="new_account_field">Administrator:</span><input type="checkbox" /> <span class="new_account_desc">(Check to make this an Administrator account.)</span>
	</p>
	
	<p id="new_account_button">
		<a href="javascript: hideEditAccountForm()">Cancel</a>&nbsp;&nbsp;<input type="button" value="Update Account" /><span class="processing" style="display: none">Saving Changes...</span>
	</p>

</div>

<div id="account_list">
	<div id="account_listings">
	<div id="account_section_1">
		{section name=user loop=$Users max=$row_1}
		
		{assign var=Account value=$Users[user]->getAccount()}
		{assign var=Contact value=$Users[user]->getContactInfo()}
		
		<div class="account_active" id="account_{$Account->getAccountId()}">
			
			<h3>
				{$Account->getUserName()} {if $Account->getAccountType() == 1}<span class="account_type">(Admin)</span>{/if}
			</h3>
						
			<p>
				{$Contact->getName()}
				
			</p>
			
			<p class="account_email">
			<a href="mailto: {$Contact->getEmail()}">{$Contact->getEmail()}</a>
			</p>
						
			<p class="account_action"><a href="{$main_path}accountedit.php?id={$Account->getAccountId()}&p={$current_page}&order={$order}&order_by={$order_by}">Edit this Account</a> | <a href="{$main_path}accountdelete.php?id={$Account->getAccountId()}&user_id={$Users[user]->getUserId()}&p={$current_page}&order={$order}&order_by={$order_by}">Delete</a> <span class="processing" style="display:none">Deleting...</span><div style="clear:both"></div></p>
			
			<div style="clear:both"></div>
			
		</div>
		{/section}
	
	</div>
	
	
	<div id="account_section_2">
		{section name=user loop=$Users start=$row_1 max=$row_1}
		
		{assign var=Account value=$Users[user]->getAccount()}
		{assign var=Contact value=$Users[user]->getContactInfo()}
		
		<div class="account_active" id="account_{$Account->getAccountId()}">
			
			<h3>
				{$Account->getUserName()} {if $Account->getAccountType() == 1}<span class="account_type">(Admin)</span>{/if}
			</h3>
						
			<p>
				{$Contact->getName()}
				
			</p>
			
			<p class="account_email">
			<a href="mailto: {$Contact->getEmail()}">{$Contact->getEmail()}</a>
			</p>
						
			<p class="account_action"><a href="{$main_path}accountedit.php?id={$Account->getAccountId()}&p={$current_page}&order={$order}&order_by={$order_by}">Edit this Account</a> | <a href="{$main_path}accountdelete.php?id={$Account->getAccountId()}&p={$current_page}&user_id={$Users[user]->getUserId()}&order={$order}&order_by={$order_by}">Delete</a> <span class="processing" style="display:none">Deleting...</span><div style="clear:both"></div></p>
			
			<div style="clear:both"></div>
			
		</div>
		{/section}
	
	</div>
	
	
	<div id="account_section_3">
		{section name=user loop=$Users start=$row_2 max=$row_3}
		
		{assign var=Account value=$Users[user]->getAccount()}
		{assign var=Contact value=$Users[user]->getContactInfo()}
		
		<div class="account_active" id="account_{$Account->getAccountId()}">
			
			<h3>
				{$Account->getUserName()} {if $Account->getAccountType() == 1}<span class="account_type">(Admin)</span>{/if}
			</h3>
						
			<p>
				{$Contact->getName()}
				
			</p>
			
			<p class="account_email">
			<a href="mailto: {$Contact->getEmail()}">{$Contact->getEmail()}</a>
			</p>
						
			<p class="account_action"><a href="{$main_path}accountedit.php?id={$Account->getAccountId()}&p={$current_page}&order={$order}&order_by={$order_by}">Edit this Account</a> | <a href="{$main_path}accountdelete.php?id={$Account->getAccountId()}&p={$current_page}&user_id={$Users[user]->getUserId()}&order={$order}&order_by={$order_by}">Delete</a> <span class="processing" style="display:none">Deleting...</span><div style="clear:both"></div></p>
			
			<div style="clear:both"></div>
			
		</div>
		{/section}
	
	</div>
	</div>
	
	{if $total_pages}
	
		<div class="page_nav">
			
			{if $current_page != $total_pages}<a href="{$Smarty.server.PHP_SELF}?p={$total_pages}&order={$order}&order_by={$order_by}" class="nav_link">&gt;&gt;</a>{/if}
			
			{if $next_page}<a href="{$Smarty.server.PHP_SELF}?p={$next_page}&order={$order}&order_by={$order_by}" class="nav_link">&gt;</a>{/if}
			
			{if $jump_forward}<a href="{$Smarty.server.PHP_SELF}?p={$jump_forward}&order={$order}&order_by={$order_by}" class="nav_link">...</a>{/if}
			
			{section name=pg loop=$page_nav start=-1 step=-1}
				
				<a href="{$Smarty.server.PHP_SELF}?p={$page_nav[pg]}&order={$order}&order_by={$order_by}" class="nav_{if $page_nav[pg] eq $current_page}select_{/if}link">{$page_nav[pg]}</a>
			
			{/section}
			
			{if $jump_back}<a href="{$Smarty.server.PHP_SELF}?p={$jump_back}&order={$order}&order_by={$order_by}" class="nav_link">...</a>{/if}
									
			{if $prev_page}<a href="{$Smarty.server.PHP_SELF}?p={$prev_page}&order={$order}&order_by={$order_by}" class="nav_link">&lt;</a>{/if}
			
			{if $current_page != 1}<a href="{$Smarty.server.PHP_SELF}?p={1}&order={$order}&order_by={$order_by}" class="nav_link">&lt;&lt;</a>{/if}
			
			<div class="page_nav_title">
			Page {$current_page} of {$total_pages}:
			</div>
			<div style="clear:both"></div>
		</div>
		
	{/if}
</div>
	
	



	