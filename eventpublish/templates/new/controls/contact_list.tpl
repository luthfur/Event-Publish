<div id="section_title">
	<h1>Contacts</h1>
	
	<p>
	<div style="float: left">Use the filters to sort through and view your contacts in the system.</div>
	<div style="float: right"><a href="contactform.php"><img src="{$template_dir}images/createNewContact.gif" border="0" onmouseover="javascript: this.src='{$template_dir}images/createNewContact_R.gif'"  onmouseout="javascript: this.src='{$template_dir}images/createNewContact.gif'" /></a></div>
		<div style="clear:both"></div>
	</p>
</div>

<div id="filters">

	<h1>
		<a href="javascript: toggleFilter()">
		<img src="{$template_dir}images/uparrow.gif" style="padding-right: 6px; border: 0; display: {if $post_back.show_filter}inline{else}none{/if}" id="filter_up" /><img src="{$template_dir}images/downarrow.gif" style="padding-right: 6px; border: 0; display: {if $post_back.show_filter}none{else}inline{/if}" id="filter_down" /></a>Search Contacts: <i>(Click on arrow to view options.)</i>
		
	</h1>
	
	<form method="post" action="{$Smarty.server.SERVER_NAME}" id="filter_form">

	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
	Keywords: <input type="text" name="keywords" size="50" value="{$post_back.keywords}" />
	</p>
	<p style="display: {if $post_back.show_filter}block{else}none{/if}">

	Search in: 
	<input type="checkbox" name="search_name" {if $post_back.search_name}checked{/if}/>Contact Name
	&nbsp;&nbsp;<input type="checkbox" name="search_email" {if $post_back.search_email}checked{/if} />Email
	&nbsp;&nbsp;<input type="checkbox" name="search_address" {if $post_back.search_address}checked{/if} />Address
	&nbsp;&nbsp;<input type="checkbox" name="search_city" {if $post_back.search_city}checked{/if}/>City
	&nbsp;&nbsp;<input type="checkbox" name="search_state" {if $post_back.search_state}checked{/if}/>State

	</p>
	
	
	<p style="display: {if $post_back.show_filter}block{else}none{/if}">
			
		<input type="hidden" name="search_dates" id="search_dates" value="{$post_back.search_dates}" />
		<input type="hidden" name="page" id="page" />
		<input type="hidden" name="cid" id="cid" />
		<input type="hidden" name="catid" id="catid" />
		<input type="hidden" name="order_by" id="order_by" />
		<input type="hidden" name="order" id="order" />
		<input type="hidden" name="show_filter" id="show_filter" value="{if $post_back.show_filter}1{else}0{/if}" />
		<input type="button" class="filter_button" value="Reset Filters" onclick="javascript: resetLocFilter()" />
		<input type="submit" class="filter_button" onclick="javascript:  refreshConList(1)" value="Refresh Contact List" />
			
	</p>
	
	</form>
	<div style="clear: both"></div>

</div>


<div id="list_menu">

	<div id="list_options">
		
		<input type="button" value="Delete Selected" onclick="javascript: deleteContact()" />
		
		<a href="javascript: selectAllRows('contact_list')" id="select_all_row_link">Select All</a>
		<a href="javascript: deselectAllRows('contact_list')" id="deselect_all_row_link" style="display: none">Deselect All</a>
	</div>
	
	
	<div id="list_order_options">
		Order by: 
		<select id="list_order_by" onchange="javascript:  refreshConList({$current_page})">
			<option value="1" {if $post_back.order_by == 1}selected{/if}>Contact Name</option>
			<option value="2" {if $post_back.order_by == 2}selected{/if}>Email Address</option>
			<option value="3" {if $post_back.order_by == 3}selected{/if}>City</option>
			<option value="4" {if $post_back.order_by == 4}selected{/if}>State</option>
		</select>
		
		<select id="list_order" onchange="javascript:  refreshConList({$current_page})">
			<option value="1" {if $post_back.order == 1}selected{/if}>Ascending</option>
			<option value="2" {if $post_back.order == 2}selected{/if}>Descending</option>
		</select>
	
		
	</div>
	
	<div style="clear: both"></div>

</div>

<div id="contact_list">
	
	<table border=0 cellspacing=0 class="list_table">
	
		<tr class="list_header">
			
			<td width="10px">
			
			</td>
			
			<td width="200px">
				Contact Name
			</td>
			
			<td>
				Email
			</td>
			
			<td>
				Address
			</td>
				
			<td width="130px">
				Telephone
			</td>
			
			<td width="130px">
				Cell
			</td>
			
		</tr>
		
		
		
		{section name=con loop=$ContactList}			
			{assign var=ContactInfo value=$ContactList[con]->getContactInfo()}
			{assign var=Address value=$ContactInfo->getAddress()}
	
				<tr class="{cycle values="list_row_odd,list_row_even"}">
			
					<td width="10px">
						<input type="checkbox" value="{$ContactList[con]->getId()}" />
					</td>
					
					<td width="200px">
						<a href="contactedit.php?id={$ContactList[con]->getId()}">{$ContactInfo->getName()}</a>
					</td>
					
					<td width="130px">
						{if $ContactInfo->getEmail()}{$ContactInfo->getEmail()}{/if}
					</td>
					
					<td>
						{if $Address->getAddressLine1()}{$Address->getAddressLine1()}<br />{/if}
						{if $Address->getAddressLine2()}{$Address->getAddressLine2()}<br />{/if}
						{if $Address->getCity()}{$Address->getCity()}{/if}{if $Address->getState()}{if $Address->getCity()}, {/if}{$Address->getState()}{/if}<br />
						{if $Address->getZip()}{$Address->getZip()}{/if}
					</td>
								
					<td width="130px">
						{if $Address->getPhone()}{$Address->getPhone()}{/if}
					</td>
					<td width="130px">
						{if $ContactInfo->getCell()}{$ContactInfo->getCell()}{/if}
					</td>
					
				</tr>			
				
		{/section}
				
				
		
		
		
	
	</table>
	
		
	{if !$total_pages}
		
		<div class="result_item">
			No Contacts Found.		
		</div>
		
		
	{/if}
		
	
	{if $total_pages}
	
		<div class="page_nav">
			
			{if $current_page != $total_pages}<a href="javascript:  refreshConList({$total_pages})" class="nav_link">&gt;&gt;</a>{/if}
			
			{if $next_page}<a href="javascript:  refreshConList({$next_page})" class="nav_link">&gt;</a>{/if}
			
			{if $jump_forward}<a href="javascript:  refreshConList({$jump_forward})" class="nav_link">...</a>{/if}
			
			{section name=pg loop=$page_nav start=-1 step=-1}
				
				<a href="javascript:  refreshConList({$page_nav[pg]})" class="nav_{if $page_nav[pg] eq $current_page}select_{/if}link">{$page_nav[pg]}</a>
			
			{/section}
			
			{if $jump_back}<a href="javascript:  refreshConList({$jump_back})" class="nav_link">...</a>{/if}
									
			{if $prev_page}<a href="javascript:  refreshConList({$prev_page})" class="nav_link">&lt;</a>{/if}
			
			{if $current_page != 1}<a href="javascript:  refreshConList(1)" class="nav_link">&lt;&lt;</a>{/if}
			
			<div class="page_nav_title">
			Page {$current_page} of {$total_pages}:
			</div>
			<div style="clear:both"></div>
		</div>
		
	{/if}
	
	<div style="clear:both"></div>
	
</div>