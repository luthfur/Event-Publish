{assign var=Account value=$User->getAccount()}
<div id="section_title">
	<h1>Delete Account for {$Account->getUserName()}</h1>
		
	<div style="clear:both"></div>
	
</div>
<div id="delete_confirm">

<form id="account_delete" method="post" action="{$main_path}process/delete_account.php">


<p>
	
	<label for="text_time">Assign events, contacts and locations from this account to the following user: </label>
	<select name="assign_user">
		{section name=user loop=$Users}
		{assign var=acc value=$Users[user]->getAccount()}
		{assign var=Contact value=$Users[user]->getContactInfo()}
		{if $acc->getAccountId() != $Account->getAccountId()}<option value="{$Users[user]->getUserId()}">{$acc->getUserName()} ({$Contact->getName()})</option>{/if}
		{/section}
	</select>
</p>




<div style="float: right; text-align: right">
		<input type="hidden" name="account_id" value="{$Account->getAccountId()}" />
		<input type="hidden" name="user_id" value="{$User->getUserId()}" />
		<input type="hidden" name="current_page" value="{$current_page}" />
		<input type="hidden" name="order" value="{$order}" />
		<input type="hidden" name="order_by" value="{$order_by}" />
		<input type="submit" class="action_button" value="Confirm and Delete" />
		<input type="button" class="action_button" value="Cancel" onclick ="javascript: window.location='account.php?p={$curr_page}&order={$order}&order_by{$order_by}" />
	</div>


</form>

<div style="clear: both"></div>

</div>
