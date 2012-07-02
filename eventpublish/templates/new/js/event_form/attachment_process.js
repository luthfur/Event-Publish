
//###################################### Handler for Deleting Attachment #########################################//


// ########## Delete Attachment - Server Request ##########################/
function deleteAttachment(id) {
	
	removeAttMessage();
	
	var attTable = document.getElementById("attachment_table");
	var attRow = document.getElementById("attachment_row_" + id);
		
	attRow.style.display = "none";
	
	var ids = document.getElementById("file_ids");
	var id_array = ids.value.split(",");
	
	var new_ids = "";
	
	for(i=0; i<id_array.length; i++) {
		
		if(id_array[i] != id) {
			if(new_ids != "") new_ids += ",";
			new_ids += id_array[i];
		}
	}
	
	
	ids.value = new_ids;
	
	var attRemove = document.getElementById("att_remove_message");
	attRemove.style.display = "block";
}

//#####################################################################//




// ########## Remove all messages #######################################//

function removeAttMessage() {
	
	var attSuccess = document.getElementById("att_success_message");
	var attRemove = document.getElementById("att_remove_message");
	var attError = document.getElementById("att_error_message");
	
	attSuccess.style.display = "none";
	attRemove.style.display = "none";
	attError.style.display = "none";
	
	
}

//#########################################################################//


//#########################################################################################################################//