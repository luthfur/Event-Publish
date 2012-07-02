
//############################# Handler for changing Registration / Publish / Cancel Options in Event Details ################################//




// ########## Toggle Registration - Server Request ##########################/
function toggleRegistration(event_id, allow_registration) {
	
	var divRegOpen = document.getElementById("reg_info_open");
	var divRegClosed = document.getElementById("reg_info_closed");
	
	divRegOpen.style.display = "none";
	divRegClosed.style.display = "none";
	
	if(allow_registration == 1) {
		
		var openingMsg = document.getElementById("reg_open_process");
		openingMsg.style.display='block';
		
	} else {
		
		var closedMsg = document.getElementById("reg_close_process");
		closedMsg.style.display='block';
		
	}
	
	var query_string = "event_id=" + event_id + '&allow_register=' + allow_registration;
	var loader = new net.ContentLoader('process/change_registration.php', processRegistrationResponse, showError, 'POST', query_string);

	
}

//#####################################################################//




// ######## Toggle Registration - Process Server Response ###############//
function processRegistrationResponse() {
	
	var allow = this.req.responseText;
	
	setTimeout(function() { showRegistrationMessage(allow); }, 1000);
		
		
}
//#####################################################################//




// ############## Display Current Registration Mode ###################//
function showRegistrationMessage(allow_register) {
	
	if(allow_register == 1) {
		
		var divRegOpen = document.getElementById("reg_info_open");
		var openingMsg = document.getElementById("reg_open_process");
		divRegOpen.style.display='block';	
		openingMsg.style.display='none';	
	
	} else {
		
		var divRegClosed = document.getElementById("reg_info_closed");
		var closedMsg = document.getElementById("reg_close_process");
		divRegClosed.style.display='block';	
		closedMsg.style.display='none';
		
	}
	
}
//#####################################################################//




// ################## Toggle Event Cancel Status - Server Request ####################//

function setEventCancel(event_id, cancel) {
	
	resetEventDetailsControls();	
	showEventDetailsProcessing();
	
	var query_string;
	var target;
	
	if(cancel) {
		query_string = "event_id=" + event_id + '&cancelled=' + cancel;
		target = 'process/cancel_event.php';
	} else {
		query_string = "event_id=" + event_id;
		target = 'process/republish_event.php';
	}
	
	var loader = new net.ContentLoader(target, processCancelResponse, showError, 'POST', query_string);

}

//#####################################################################################//




//################# Toggle Cancel Status - Process Server Response #####################//
function processCancelResponse() {
	
	var cancel = this.req.responseText;
	
	setTimeout(function() { setCancelLinks(cancel); }, 1000);
			
}
//#####################################################################################//




// ################## Toggle Event Publishi Status - Server Request ####################//
function setEventPublish(event_id, publish) {
	
	resetEventDetailsControls();	
	showEventDetailsProcessing();
	
	var query_string = "event_id=" + event_id + '&published=' + publish;
	
	var loader = new net.ContentLoader('process/change_status_event.php', processPublishResponse, showError, 'POST', query_string);

}
//#####################################################################################//




//########## Toggle Event Publishi Status - Process Server Response ##################//
function processPublishResponse() {
	
	var publish = this.req.responseText;
		
	setTimeout(function() { setPublishLinks(publish); }, 1000);
	
	
		
}
//#####################################################################################//




//########## Display Control once Event Published/Unpublished ##################//
function setPublishLinks(publish) {
	
	resetEventStatus();
	
	hideEventDetailsProcessing();
	
	var editEventLink = document.getElementById("edit_event_link");
	var deleteEventLink = document.getElementById("delete_event_link");
		
	editEventLink.style.display = "inline";
	deleteEventLink.style.display = "inline";
		
		
	if(publish == 1) {
		
		var eventPublished = document.getElementById("event_details_published");
		var draftEventLink = document.getElementById("draft_event_link");
		var cancelEventLink = document.getElementById("cancel_event_link");
		
		draftEventLink.style.display = "inline";
		//cancelEventLink.style.display = "inline";
		eventPublished.style.display = "inline";
		
			
	} else {
		
		var eventDraft = document.getElementById("event_details_draft");
		var publishEventLink = document.getElementById("publish_event_link");
		
		publishEventLink.style.display = "inline";
		eventDraft.style.display = "inline";
		
	}
	
}
//#####################################################################################//




//########## Display Control once Event Cancelled/Republished ##################//
function setCancelLinks(cancel) {
	
	resetEventStatus();
	hideEventDetailsProcessing();
	
	var editEventLink = document.getElementById("edit_event_link");
	var deleteEventLink = document.getElementById("delete_event_link");
		
	editEventLink.style.display = "inline";
	deleteEventLink.style.display = "inline";
			
	if(cancel == 1) {
		
		var republishEventLink = document.getElementById("republish_event_link");
		var eventCancel = document.getElementById("event_details_cancelled");
		
		republishEventLink.style.display = "inline";
		eventCancel.style.display = "inline";
					
	} else {
		
		var draftEventLink = document.getElementById("draft_event_link");
		var cancelEventLink = document.getElementById("cancel_event_link");
		var eventPublished = document.getElementById("event_details_published");
		
		draftEventLink.style.display = "inline";
		//cancelEventLink.style.display = "inline";
		eventPublished.style.display = "inline";
	}
	
}
//#####################################################################################//





//############ Display Control once Event Cancelled/Republished ####################//
function resetEventDetailsControls() {
	
	
	var editEventLink = document.getElementById("edit_event_link");
	var draftEventLink = document.getElementById("draft_event_link");
	var republishEventLink = document.getElementById("republish_event_link");
	var cancelEventLink = document.getElementById("cancel_event_link");
	var publishEventLink = document.getElementById("publish_event_link");
	var deleteEventLink = document.getElementById("delete_event_link");
	
	editEventLink.style.display = "none";
	draftEventLink.style.display = "none";
	republishEventLink.style.display = "none";
	cancelEventLink.style.display = "none";
	publishEventLink.style.display = "none";
	deleteEventLink.style.display = "none";
	
	hideEventDetailsProcessing();

}
//#####################################################################################//	
	


//################## Reset Event Status Display ######################################//
function resetEventStatus() {	
		
	var eventPublished = document.getElementById("event_details_published");
	var eventDraft = document.getElementById("event_details_draft");
	var eventCancel = document.getElementById("event_details_cancelled");
	
	eventDraft.style.display = "none";
	eventPublished.style.display = "none";
	eventCancel.style.display = "none";
		
}
//#####################################################################################//



//################## Show Processing Message ######################################//
function showEventDetailsProcessing() {
	
	var eventAction = document.getElementById("event_action_process");
	eventAction.style.display = "inline";
	
}
//#####################################################################################//




//################## Hide Processing Message ######################################//
function hideEventDetailsProcessing() {
	
	var eventAction = document.getElementById("event_action_process");
	eventAction.style.display = "none";
}

//#####################################################################################//



//################## Toggle Loction/contact details ######################################//
function toggleLocConDetails(elm) {
	
	var details = document.getElementById(elm);
	
	if(details == null) return;
	
	if(details.style.display == "none") {
		details.style.display = "block";
	} else {
		details.style.display = "none";
	}
	
	
}

//#####################################################################################//



//###########################################################################################################################################################//
