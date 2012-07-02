
//###################################### Handler for Adding a new Locations #########################################//


// ########## Add a Location - Server Request ##########################/
function addLocation() {

	var divLocButtons = document.getElementById("location_buttons");
	var divLocForm = document.getElementById("new_location");
	var divLocProcess = document.getElementById("location_process");
		
	var inputs = divLocForm.getElementsByTagName("input");
	
	
	
	if(locValidate(inputs) == true) {
		
		divLocButtons.style.display = "none";
		divLocProcess.style.display = "block";
	
		
		var query_string = "location_title=" + inputs[0].value +
							"&location_address1=" + inputs[1].value +
							"&location_address2=" + inputs[2].value +
							"&location_city=" + inputs[3].value +
							"&location_state=" + inputs[4].value +
							"&location_zip=" + inputs[5].value +
							"&location_phone=" + inputs[6].value +
							"&location_fax=" + inputs[7].value +
							"&location_image=" + inputs[8].value +
							"&location_desc=" + inputs[9].value;
	
		var loader = new net.ContentLoader('process/add_location.php', processLocationResponse, showError, 'POST', query_string);
	
	
	} else {
		var divLocTitleError = document.getElementById("location_title_error");
		divLocTitleError.style.display = "inline";
	}
	
}

//#####################################################################//




// ######## Add a Location - Process Server Response ################//
function processLocationResponse() {
	
	var new_id = this.req.responseText;
	
	// refresh the location list from the server
	refreshLocationList();
	
	// auto select the newly added location
	window.setTimeout(function() { autoSelectLocation(new_id); }, 3000);
		
}
//#####################################################################//




// ######## Add a Location - Auto Select newly added Location ##########//
function autoSelectLocation(new_id) {
	
	
	
	var selectLoc = document.getElementById("loc_select");
		
	for(i=0; i<selectLoc.options.length; i++) {
		
		if(selectLoc.options[i].value == new_id)  {
			selectLoc.options[i].selected = true;
			break;
		}
	}
	
	var divLocProcess = document.getElementById("location_process");
	divLocProcess.style.display = "none";
	
	var divLocForm = document.getElementById("new_location");
	divLocForm.style.display = "none";
	
	var divLocButtons = document.getElementById("location_buttons");
	divLocButtons.style.display = "block";
	
	var divLocTitleError = document.getElementById("location_title_error");
		divLocTitleError.style.display = "none";
	
	var divLocMessage = document.getElementById("location_added_message");
			
	divLocMessage.style.display = "block";
	
	showLocationDetails(true);
	
}
//########################################################################//




// ########## Add a Location - Validate Input ############################//
function locValidate(inputs) { 
	
	var divLocForm = document.getElementById("new_location");
		
	var inputs = divLocForm.getElementsByTagName("input");
	
	var location_title = inputs[0].value.trim();
	
	if(location_title == "") return false;
	
	return true;
	
}
//########################################################################//





// ######### Server Response - Display Error Message #####################//
function showError() {
	
	var divLocError = document.getElementById("location_error_message");	// location error messages
	divLocError.style.display = "block";
	
	
	var divLocButtons = document.getElementById("location_buttons");
	var divLocProcess = document.getElementById("location_process");
	
	divLocButtons.style.display = "block";
	divLocProcess.style.display = "none";		
	divLocMessage.style.display = "block";
	
}
//########################################################################//



//#######################################################################################################################################//






//############################################ Reload Current Location List from the Server ###############################################//


// ########## Get Location - Server Request ############//
function refreshLocationList() {

	var locationListLoader = new net.ContentLoader('process/list_location.php', getLocationList, showError, 'POST', '', 'application/xml');
	
	
}
//#######################################################//



// ########## Preload Location - Server Request ############//
function preLoadLocationList() {
	
	var locationPreLoader = new net.ContentLoader('process/list_location.php', loadLocationList, showError, 'POST', '', 'application/xml');
	
	
}
//###########################################################//



// ########## Get Location - Process Server Response ############//
function getLocationList() {

	locationXML  = this.req.responseXML.documentElement;
	setLocationList();
	
}

//######################################################################//





// ########## Preload Location - Process Server Response ############//
function loadLocationList() {

	locationXML  = this.req.responseXML.documentElement;
	
}

//######################################################################//




// #################### Set Location List ###########################//

function setLocationList() {

	var locationSet = locationXML.getElementsByTagName("location");
	
	var selectLoc = document.getElementById("loc_select");
	
	var selectOptions = selectLoc.options;
	
	var length = selectOptions.length;
	
	for(i=1; i<length; i++) {
		
		selectLoc.removeChild(selectOptions[1]);
	}
	
	var opt;
	
	for(i=0; i<locationSet.length; i++) {
		
		opt = document.createElement("option");
		opt.value = locationSet[i].attributes[0].value;
		
		var textNode = document.createTextNode(getXMLElementContent(locationSet[i], 'title'));
		opt.appendChild(textNode);
		
		selectLoc.appendChild(opt);
	
	}
	
}

//######################################################################//




//################################################################################################################################################//


