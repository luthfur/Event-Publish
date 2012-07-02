{* Smarty *}

<div id="myevents">

<div id="header">
			
			<div class="left_side_bar"></div>
			
			<div id="header_main">
				<div id="logo">
					<img src="{$template_dir}/images/logo.gif" />	
				</div>	
				
				
				<div id="main_nav">
					<a href="javascript: void(0)" class="{if $control_location == 'events'}selected_nav{else}main_nav{/if}" onclick="showSubNav('event_nav', 'event_nav_link')" id="event_nav_link">Events</a>
					<!--<a href="javascript: void(0)" class="main_nav" onclick="showSubNav('publish_nav', 'publish_nav_link')" id="publish_nav_link">Publish</a> -->
					<a href="javascript: void(0)" class="{if $control_location == 'manage'}selected_nav{else}main_nav{/if}" onclick="showSubNav('manage_nav', 'manage_nav_link')" id="manage_nav_link">Manage</a>
					
				</div>
				
				
			</div>
						
			<div class="side_bar"></div>
			
</div>
		
		
<div id="content">
		
		<div class="left_side_bar">&nbsp;</div>
		
		<div id="content_main">
	
