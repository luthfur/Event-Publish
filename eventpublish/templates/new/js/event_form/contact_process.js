
//###################################### Handler for Adding a new Contacts #########################################//


// ########## Add a Contact - Server Request ##########################/
function addContact() {

	var divContactButtons = document.getElementById("contact_buttons");
	var divContactForm = document.getElementById("new_contact");
	var divContactProcess = document.getElementById("contact_process");
	
	// reset error messages
	var divContactEmailError = document.getElementById("contact_email_error");
	divContactEmailError.style.display = "none";

	var divContactNameError = document.getElementById("contact_name_error");
	divContactNameError.style.display = "none";
	
		
	var inputs = divContactForm.getElementsByTagName("input");
	
	var validation_result = conValidate(inputs)
	
	if(validation_result == true) {
		
		divContactButtons.style.display = "none";
		divContactProcess.style.display = "block";
	
		
		var query_string = "contact_name=" + inputs[0].value +
							"&contact_email=" + inputs[1].value +
							"&contact_address1=" + inputs[2].value +
							"&contact_address2=" + inputs[3].value +
							"&contact_city=" + inputs[4].value +
							"&contact_state=" + inputs[5].value +
							"&contact_zip=" + inputs[6].value +							
							"&contact_phone=" + inputs[7].value +
							"&contact_fax=" + inputs[8].value +
							"&contact_cell=" + inputs[9].value;
				
		var loader = new net.ContentLoader('process/add_contact.php', processContactResponse, showError, 'POST', query_string);
	
	
	}
	
}

//#####################################################################//




// ######## Add a Contact - Process Server Response ################//
function processContactResponse() {
	
	var new_id = this.req.responseText;
		
	// refresh the location list from the server
	refreshContactList();
	
	// auto select the newly added location
	window.setTimeout(function() { autoSelectContact(new_id); }, 3000);
		
}
//#####################################################################//




// ######## Add a Contact - Auto Select newly added Contact ##########//
function autoSelectContact(new_id) {
		
	var selectContact = document.getElementById("con_select");
		
	for(i=0; i<selectContact.options.length; i++) {
		
		if(selectContact.options[i].value == new_id)  {
			selectContact.options[i].selected = true;
			break;
		}
	}
	
	var divContactProcess = document.getElementById("contact_process");
	divContactProcess.style.display = "none";
	
	var divContactForm = document.getElementById("new_contact");
	divContactForm.style.display = "none";
	
	var divContactButtons = document.getElementById("contact_buttons");
	divContactButtons.style.display = "block";
	
	var divContactNameError = document.getElementById("contact_name_error");
	divContactNameError.style.display = "none";
	
	var divContactMessage = document.getElementById("contact_added_message");
			
	divContactMessage.style.display = "block";
	
	showContactDetails(true);
	
}
//########################################################################//




// ########## Add a Contact - Validate Input ############################//
function conValidate(inputs) { 
				
	var valid = true;
	
	var divContactForm = document.getElementById("new_contact");
		
	var inputs = divContactForm.getElementsByTagName("input");
	
	var contact_name = inputs[0].value.trim();
	
	var contact_email = inputs[1].value.trim();
	
	if(contact_name == "") {
		var divContactNameError = document.getElementById("contact_name_error");
		divContactNameError.style.display = "inline";
		valid = false;
	}
		
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(contact_email) != true && contact_email != "") {
		var divContactEmailError = document.getElementById("contact_email_error");
		divContactEmailError.style.display = "inline";
		valid = false;
	}
	
	return valid;
	
}
//########################################################################//





// ######### Server Response - Display Error Message #####################//
function showError() {
	
	var divContactError = document.getElementById("contact_error_message");	// location error messages
	divLocError.style.display = "block";
	
	
	var divContactButtons = document.getElementById("contact_buttons");
	var divContactProcess = document.getElementById("contact_process");
	
	divContactButtons.style.display = "block";
	divContactProcess.style.display = "none";		
	divContactError.style.display = "block";
	
}
//########################################################################//



//#######################################################################################################################################//






//############################################ Reload Current Contact List from the Server ###############################################//


// ########## Get Contact - Server Request ############//
function refreshContactList() {
	
	var contactListLoader = new net.ContentLoader('process/list_contact.php', getContactList, showError, 'POST', '', 'application/xml');
	
	
}
//#######################################################//




// ########## Preload Contact - Server Request ############//
function preLoadContactList() {
	
	var contactPreLoader = new net.ContentLoader('process/list_contact.php', loadContactList, showError, 'POST', '', 'application/xml');
	
	
}
//###########################################################//




// ########## Get Contact - Process Server Response ############//
function getContactList() {

	contactXML  = this.req.responseXML.documentElement;
	setContactList();
	
}

//######################################################################//




// ########## Preload Contact - Process Server Response ############//
function loadContactList() {

	contactXML  = this.req.responseXML.documentElement;
	
}

//######################################################################//



// ########## Get Contact - Process Server Response ############//
function setContactList() {
	
	var contactSet = contactXML.getElementsByTagName("contact");
	
	var selectContact = document.getElementById("con_select");
	
	var selectOptions = selectContact.options;
	
	var length = selectOptions.length;
	
	for(i=1; i<length; i++) {
		
		selectContact.removeChild(selectOptions[1]);
	}
	
	var opt;
	
	for(i=0; i<contactSet.length; i++) {
		
		opt = document.createElement("option");
		opt.value = contactSet[i].attributes[0].value;
		
		var textNode = document.createTextNode(getXMLElementContent(contactSet[i], 'name'));
		opt.appendChild(textNode);
		
		selectContact.appendChild(opt);
	
	}
	
	

}

//######################################################################//



//################################################################################################################################################//
