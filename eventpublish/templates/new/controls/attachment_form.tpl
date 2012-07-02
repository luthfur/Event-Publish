
<form enctype="multipart/form-data" action="{$smarty.server.SCRIPT_NAME}" method="POST" style="margin: 0; padding: 0;">
<fieldset>
	<p>
	<label for="calendar_id">Select a file:<br/></label>
	
		<input type="file" name="selected_file" size="35">
		
	</p>
	
	<p style="margin: 0; padding-bottom: 14px">	
		<label for="calendar_id">File Description:<br/></label>
	
		<input type="text" size="50" name="file_desc">
		
		<span class="field_desc">
			<input type="submit" value="Attach File">
		</span>
	</p>
	
	<input type="hidden" value="{$attachment_string}" name="file_ids" id="file_ids" />

	
</fieldset>

</form>
<div id="att_success_message" style="display: {if $successful_upload && $upload_try }block{else}none{/if}">
		
	<img src="{$template_dir}/images/notify_info.gif" />File successfully attached.
	
</div>
<div id="att_remove_message" style="display: none">
		
	<img src="{$template_dir}/images/notify_info.gif" />Attachment has successfully been removed.
	
</div>
<div id="att_error_message" style="display: {if !$successful_upload && $upload_try}block{else}none{/if}">
		
	<img src="{$template_dir}/images/error.gif" />Unable to attach file - {$att_error_message}
	
</div>
<div id="att_form" style="padding: 0; margin: 0">
	
	<div id="attached_files" style="height: 160px; overflow: auto;">
	<table border="0" cellpadding="6" id="attachment_table">
		
		{section name=att_row loop=$attdata}
		<tr class="attachment_row" id="attachment_row_{$attdata[att_row]->getId()}">
			<td width="75%">
				{$attdata[att_row]->getFileName()}
				
			</td>
			<td align="middle">
				<a href="{$att_dir}{$attdata[att_row]->getFileName()}" target="_blank">View</a>
			</td>
			
			<td align="middle">
				<a href="javascript: deleteAttachment({$attdata[att_row]->getId()})">Remove</a>
			</td>
		</tr>
		{/section}
				
	</table>
	</div>
</div>
