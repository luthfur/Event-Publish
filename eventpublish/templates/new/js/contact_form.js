
//###################################### Handler for Adding a new Locations #########################################//


// ########## Add a Location - Server Request ##########################/
function submitContactForm() {
	
	var conNameError =  document.getElementById("contact_name_error");
	var conEmailError =  document.getElementById("contact_email_error");
	conNameError.style.display = "none";
	conEmailError.style.display = "none";	
	
	if(contactMainValidate() == true) {
		
		var contForm =  document.getElementById("contact_main_form");
		
		contForm.submit();
		
	}
}

//#####################################################################//




// ########## Add a Contact - Validate Input ############################//
function contactMainValidate(inputs) { 
				
	var valid = true;
	
	var divContactForm = document.getElementById("new_main_contact");
		
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




//#######################################################################################################################################//




