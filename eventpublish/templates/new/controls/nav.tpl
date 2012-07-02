<div id="sub_desc">
	<a href="{$main_path}index.php">Dashboard</a>&nbsp;&nbsp;|&nbsp;&nbsp;
	{if $is_admin == 1}<a href="{$main_path}my_account.php">My Account</a>&nbsp;&nbsp;|&nbsp;&nbsp;{/if}
	<!--<a href="">Help</a>&nbsp;&nbsp;|&nbsp;&nbsp;-->
	<!--[&nbsp;{$welcome_name} : --><a href="{$main_path}logout.php">Log Out</a>&nbsp;

</div>

	
<div class="sub_nav" id="sub_nav">

	<div class="sub_nav_inner">
		
		<div id="default_nav" {if $control_location != "events" && $control_location != "manage"}style="display:block"{else}style="display:none"{/if}>		
			Click on Events or Manage to view menu options
		</div>
		
		{if $is_admin == 1}
		<div class="sub_nav_link" id="manage_nav" {if $control_location == "manage"}style="display:block"{else}style="display:none"{/if}>		
			{if $enable_calendar_control == 1}<a href="{$main_path}calendar.php">Calendars</a>{/if}
			<a href="{$main_path}contactlist.php">Contacts</a>
			<a href="{$main_path}loclist.php">Locations</a>
			<a href="{$main_path}account.php">Accounts</a>
			<a href="{$main_path}settings.php">Settings</a>
		</div>
		{else}
		
		<div class="sub_nav_link" id="manage_nav" {if $control_location == "manage"}style="display:block"{else}style="display:none"{/if}>		
			<a href="{$main_path}contactlist.php">Manage Contacts</a>
			{if $enable_location_control == 1}<a href="{$main_path}loclist.php">Manage Locations</a>{/if}
			<a href="{$main_path}my_account.php">My Account</a>
		</div>
		{/if}
		
		<div class="sub_nav_link" id="event_nav" {if $control_location == "events"}style="display:block"{else}style="display:none"{/if}>		
			<a href="{$main_path}eventform.php">Create New Event</a>
			<a href="{$main_path}eventlist.php">Event Search</a>
			<a href="../" target="_blank">Go to Calendar</a>
		</div>
		
	
		<div style="clear: both"></div>
	
	</div>
	
	<div style="clear: both"></div>
		
</div>

