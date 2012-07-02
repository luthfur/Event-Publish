
//###################################### Handler for Adding a new Contacts #########################################//



// ################## Check start and end time ##############################/
function checkTime() {
	
	// if no time is checked...abort validation
	var noTime = document.getElementById("no_time");	
	
	if(noTime.checked == true) {
		return true;
	}
	
	
	// grab start and stop time
	var startTime = document.getElementById("start_time");	
	var startM = document.getElementById("start_m");
	var stopTime = document.getElementById("stop_time");	
	var stopM = document.getElementById("stop_m");
	
	
	// parse the hour and minute values
	var startTimeArray = startTime.options[startTime.selectedIndex].value.split(":");
	var stopTimeArray = stopTime.options[stopTime.selectedIndex].value.split(":");
	
	var StartDate = new Date();
	var StopDate = new Date();
	
	var startHour = startTimeArray[0];
	var stopHour = stopTimeArray[0];
	
	// set to 24 hour time
	if(startM.options[startM.selectedIndex].value == 1 && startHour != 12)	{
		startHour = (Number(startHour) + 12) % 24;
	} else if(startM.options[startM.selectedIndex].value == 0 && startHour == 12) {
		startHour = 0;
	}
	
	if(stopM.options[stopM.selectedIndex].value == 1 && stopHour != 12)	{
		stopHour = (Number(stopHour) + 12) % 24;
	} else if(stopM.options[stopM.selectedIndex].value == 0 && stopHour == 12) {
		stopHour = 0;
	}
	
	// perform time validation
	StartDate.setHours(startHour);
	StartDate.setMinutes(startTimeArray[1]);
	
	StopDate.setHours(stopHour);
	StopDate.setMinutes(stopTimeArray[1]);
	
	var diff = StopDate.getTime() - StartDate.getTime();
	
	// display message if time is invalid
	if(diff < 0) {
		return confirm("The end time for the event is earlier than the start time.\nClick OK, if you would like the event to end into the next day.")
	} else {
		return true;
	}
}
//#####################################################################//





// ################## Publish new Event ##############################/
function publishEvent(save_mode) {
	
	if(validateEventForm(save_mode) == true && checkTime() == true) {
		submitEventData(1);	
	}
		
}

//#####################################################################//



// #################### Save new Event ################################/
function saveEvent(save_mode) {
	
	if(validateEventForm(save_mode) == true && checkTime() == true) {
		submitEventData(0);	
	}
		
}

//#####################################################################//




// #################### Save new Event ################################/
function previewEvent(path, save_mode) {
	
	if(validateEventForm(save_mode) == true && checkTime() == true) {
		
		var form = document.getElementById("event_form");
		form.action = path + "eventpreview.php";
		
		submitEventData(0);	
	}
		
}

//#####################################################################//





// ################## Validate Event Form ##############################/
function validateEventForm (save_mode) {
	
	var calendarID = document.getElementById("calendar_id");	
	var title = document.getElementById("event_title");
	
	
	var locationIDError = document.getElementById("location_id_error");	
	var eventTitleError = document.getElementById("event_title_error");	
	
	
	eventTitleError.style.display = "none";
	
	var valid = true;
	
	// only required for multi-calendar mode
	if(save_mode == "calendar") {
		
		var calendarIDError = document.getElementById("calendar_id_error");	
		calendarIDError.style.display = "none";
		
		if(calendarID.selectedIndex == -1)  {
			// error - no calendars selected
			valid = false;
			
			calendarIDError.style.display = "inline";
			
		}
	
	}
	
	// only required for location mode
	if(save_mode == "location") {
		
		var locationID = document.getElementById("location_id");
		
		if(!locationID.selectedIndex)  {
			// error - no locations selected
			valid = false;
			
			locationIDError.style.display = "inline";
			
		}
	}
	
	if(title.value.trim() == "") {
		// error - event title not specified
		valid = false;
		
		eventTitleError.style.display = "inline";
	}
	
	return valid;
}
//#####################################################################//



// ################## Submit Event Data ##############################//
function submitEventData(status) {
	
	var eventAttachments = document.getElementById("attachments");
	var attachmentFrame = document.getElementById("attachment_frame");
	var publishedStatus = document.getElementById("published");		
	
	if(attachmentFrame) {
		
		if(attachmentFrame.contentDocument) {
			attachmentsFromFrame = attachmentFrame.contentDocument.getElementById("file_ids");
		} else {
			attachmentsFromFrame = document.frames["attachment_frame"].document.getElementById("file_ids");
		}
				
		eventAttachments.value = attachmentsFromFrame.value;
	}
		
	
	publishedStatus.value = status;
	
	var eventForm = document.getElementById("event_form");
	eventForm.submit();
		
}
//#####################################################################//




// ############ Return to Event Form (from preview) #########################//
function returnToEventForm() {
		
	var eventForm = document.getElementById("event_form");
	eventForm.action = "eventform.php";
	eventForm.submit();
		
}
//#####################################################################//



//################################################################################################################################################//
