
//###################################### Handler for Adding a new Locations #########################################//


// ########## Add a Location - Server Request ##########################/
function submitLocationForm() {
	
	var locError =  document.getElementById("location_name_error");
	
	locError.style.display = "none";
	
	if(locationValidate() == true) {
		
		var locForm =  document.getElementById("location_main_form");
		
		locForm.submit();
		
	} else {
				
		locError.style.display = "inline";
	}
}

//#####################################################################//



// ########## Add a Location - Validate Input ############################//
function locationValidate() { 
	
	var divLocForm = document.getElementById("location_main_form");
		
	var inputs = divLocForm.getElementsByTagName("input");
	
	var location_title = inputs[0].value.trim();
	
	if(location_title == "") return false;
	
	return true;
	
}
//########################################################################//




//#######################################################################################################################################//




