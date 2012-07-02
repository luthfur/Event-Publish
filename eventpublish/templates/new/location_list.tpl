{* Smarty *}

	<div id="index_list">
	
	<div id="list_header">Select a {$select_type}:</div>

	<form id="view_selector" method="post">
		
		<div>
		<select name="calview" id="calview" class="selectbox">
			
			<option value="day.{$PHP_EXT}">Day View</option>
			<option value="week.{$PHP_EXT}">Week View</option>
			<option value="month.{$PHP_EXT}">Month View</option>
			<option value="year.{$PHP_EXT}">Year View</option>
	
		</select>
	
		<input type="hidden" name="d" value="{$day}" />
		<input type="hidden" name="m" value="{$month}" />
		<input type="hidden" name="y" value="{$year}" />
		<input type="hidden" name="pv" value="{$private_mode}" />
		<input class="button" onclick="goAll()" value="View All Events" type="button" />
		
		</div>
	</form>



	<table id="cal_list" border="0">
						
		<tr>
							
			<td class="cat_set">
								
				{section name=loc loop=$Locations max=$division}			
					<div class="location_name"><a href="{$default_view}?d={$day}&m={$month}&y={$year}&lid={$Locations[loc]->getId()}&z={$time_zone}&pv={$private_mode}">{$Locations[loc]->getTitle()}</a></div>
				{/section}
				
				
			</td>
					
			<td class="cat_set">
								
				{section name=loc loop=$Locations start=$division}			
					<div class="location_name"><a href="{$default_view}?d={$day}&m={$month}&y={$year}&lid={$Locations[loc]->getId()}&z={$time_zone}&pv={$private_mode}">{$Locations[loc]->getTitle()}</a></div>
				{/section}
				
				
			</td>
		
		</tr>	
			
				
	</table>

	</div>
