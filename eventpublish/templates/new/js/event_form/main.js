//############################## Location Form Controls ########################################################//


// ############### Show location Details ####################//
function showLocationDetails(show_message) {
	
	var locForm = document.getElementById("new_location");				// location form
	var locSelect = document.getElementById("loc_select");				// location select box
	var locDetails = document.getElementById("location_details");		// location details display box
	var divLocMessage = document.getElementById("location_added_message");	// location process messages
	var divLocError = document.getElementById("location_error_message");	// location error messages
	
	// toggle process message off if displayed:
	if(show_message == false || show_message == null) {
		divLocMessage.style.display = "none";
		divLocError.style.display = "none";
	}
	
	locPs = locDetails.getElementsByTagName("p");
	locH2 = locDetails.getElementsByTagName("h2");
	
	locPs[0].innerHTML = "";
	locPs[1].innerHTML = "";
	
	if(locSelect.options[locSelect.selectedIndex].value != 0) {
		
		var locationSet = locationXML.getElementsByTagName("location");
		
		for(i=0; i<locationSet.length; i++) {
			
			if(locationSet[i].attributes[0].value == locSelect.options[locSelect.selectedIndex].value) {
				
				locH2[0].innerHTML = getXMLElementContent(locationSet[i], 'title');
				
				if(getXMLElementContent(locationSet[i], 'address_1') != "") locPs[0].innerHTML += getXMLElementContent(locationSet[i], 'address_1') + "<br />"; 
				if(getXMLElementContent(locationSet[i], 'address_2') != "") locPs[0].innerHTML += getXMLElementContent(locationSet[i], 'address_2') + "<br />";  
				if(getXMLElementContent(locationSet[i], 'city') != "") locPs[0].innerHTML += getXMLElementContent(locationSet[i], 'city');
				if(getXMLElementContent(locationSet[i], 'state') != "") locPs[0].innerHTML += ", " + getXMLElementContent(locationSet[i], 'state');
				if(getXMLElementContent(locationSet[i], 'zip') != "") locPs[0].innerHTML += "<br />" + getXMLElementContent(locationSet[i], 'zip');
			
				if(getXMLElementContent(locationSet[i], 'phone') != "") locPs[1].innerHTML += "Tel: " + getXMLElementContent(locationSet[i], 'phone');
				if(getXMLElementContent(locationSet[i], 'fax') != "") locPs[1].innerHTML += "<br />Fax: " + getXMLElementContent(locationSet[i], 'fax') + "<br />";
		
				break;
			}
			
		}
		
		locDetails.style.display = "block";
	} else {
		locDetails.style.display = "none";
	}
	
	if(locForm.style.display == "block") {
		locForm.style.display = "none";
	}
	
}


// ############### Show location Form ####################//
function toggleLocationForm() {
	
	var locDetails = document.getElementById("location_details");		// location details display box
	var locForm = document.getElementById("new_location");				// location form
	var divLocMessage = document.getElementById("location_added_message");	// location process messages
	
	// toggle process message off if displayed:
	divLocMessage.style.display = "none";
	
	// TODO: clear form:
	//var locationForm = document.getElementById("location_form");
	//locationForm.reset();
	
	// clear error messages:
	var divLocTitleError = document.getElementById("location_title_error");
		divLocTitleError.style.display = "none";
	
	if(locForm.style.display == "none") {
		locForm.style.display = "block";
	} else {
		locForm.style.display = "none";
	}
	
	if(locDetails.style.display == "block") {
		locDetails.style.display = "none";
	}

}
// #################################################################################################################//





//############################## Contact Form Controls ########################################################//


// ############### Show Contact Details ###################//
function showContactDetails(show_message) {

	var conSelect = document.getElementById("con_select");			// contact select box
	var conDetails = document.getElementById("contact_details");	// contact details display
	var conForm = document.getElementById("new_contact");			// contact form display
	var divContactMessage = document.getElementById("contact_added_message");	// contact process messages
	var divContactError = document.getElementById("contact_error_message");	// contact error messages
	
	// toggle process message off if displayed:
	if(show_message == false || show_message == null) {
		divContactMessage.style.display = "none";
		divContactError.style.display = "none";

	}
	
	
	
	conPs = conDetails.getElementsByTagName("p");
	conH2 = conDetails.getElementsByTagName("h2");
	
	conPs[0].innerHTML = "";
	conPs[1].innerHTML = "";
	
	if(conSelect.options[conSelect.selectedIndex].value != 0) {
		
		var contactSet = contactXML.getElementsByTagName("contact");
		
		for(i=0; i<contactSet.length; i++) {
			
			if(contactSet[i].attributes[0].value == conSelect.options[conSelect.selectedIndex].value) {
				
				conH2[0].innerHTML = getXMLElementContent(contactSet[i], 'name');
				

				if(getXMLElementContent(contactSet[i], 'address_1') != "") conPs[0].innerHTML += getXMLElementContent(contactSet[i], 'address_1') + "<br />"; 
				if(getXMLElementContent(contactSet[i], 'address_2') != "") conPs[0].innerHTML += getXMLElementContent(contactSet[i], 'address_2') + "<br />";  
				if(getXMLElementContent(contactSet[i], 'city') != "") conPs[0].innerHTML += getXMLElementContent(contactSet[i], 'city');
				if(getXMLElementContent(contactSet[i], 'state') != "") conPs[0].innerHTML += ", " + getXMLElementContent(contactSet[i], 'state');
				if(getXMLElementContent(contactSet[i], 'zip') != "") conPs[0].innerHTML += "<br />" + getXMLElementContent(contactSet[i], 'zip');
	
				if(getXMLElementContent(contactSet[i], 'email') != "") conPs[1].innerHTML += "Email: " + getXMLElementContent(contactSet[i], 'email');
				if(getXMLElementContent(contactSet[i], 'phone') != "") conPs[1].innerHTML += "<br />Phone: " + getXMLElementContent(contactSet[i], 'phone');
				if(getXMLElementContent(contactSet[i], 'fax') != "") conPs[1].innerHTML += "<br />Fax: " + getXMLElementContent(contactSet[i], 'fax');
				if(getXMLElementContent(contactSet[i], 'cell') != "") conPs[1].innerHTML += "<br />Cell: " + getXMLElementContent(contactSet[i], 'cell');
								
				break;
			}
			
		}
		
		
		conDetails.style.display = "block";
	} else {
		conDetails.style.display = "none";
	}
	
	if(conForm.style.display == "block") {
		conForm.style.display = "none";
	}
	
}


// ############### Show Contact Form ####################//
function toggleContactForm() {

	var conDetails = document.getElementById("contact_details");	// contact details display
	var conForm = document.getElementById("new_contact");			// contact form display
	var divContactMessage = document.getElementById("contact_added_message");	// contact process messages
	
	// toggle process message off if displayed:
	divContactMessage.style.display = "none";
	
	// TODO: clear form:
	//var form = document.getElementById("contact_form");	
	//form.reset();
	
	// clear error messages:
	var divContactNameError = document.getElementById("contact_name_error");
	divContactNameError.style.display = "none";
	
	var divContactEmailError = document.getElementById("contact_email_error");
	divContactEmailError.style.display = "none";
		
	if(conForm.style.display == "none") {
		conForm.style.display = "block";
	} else {
		conForm.style.display = "none";
	}
	
	if(conDetails.style.display == "block") {
		conDetails.style.display = "none";
	}
}


// ###############################################################################################################//





//############################## Date Selector Controls ########################################################//


// ############### Toggle Date Repeat ####################//
function toggleRepeat(repeat) {

	var repeatUntil = document.getElementById("repeat_until");
		
	if(repeat.options[repeat.selectedIndex].value == 1) {
		repeatUntil.style.display = "none";
	} else {
		repeatUntil.style.display = "block";
	}

}	


// ############### Pick Selected Date ####################//
function pickDate(cell, type) {
	
	if(type == "start") {
		var PickedDate = StartDatePicker.pick(cell);
		var picker = document.getElementById("start_picker");
	} else {
		var PickedDate = StopDatePicker.pick(cell);
		var picker = document.getElementById("stop_picker");
	}
	
	var dayText = document.getElementById(type + "_day");
	var monthText = document.getElementById(type + "_month");
	var yearText = document.getElementById(type + "_year");
	
	dayText.value = PickedDate.getDate();
	monthText.value = ((PickedDate.getMonth() == 0) ? 12 : PickedDate.getMonth());
	yearText.value = PickedDate.getFullYear();
		
	picker.style.display = "none";
	
}


// ############### Toggle Date Highlight ####################//
function toggleHighlight(cell) {

	if(cell.className == "minical_cell") {
		cell.className = "highlight_cell";
	} else {
		cell.className = "minical_cell";
	}
	

}


// ############### Toggle Date Picker ####################//
function togglePicker(picker_name) {
	
	var picker = document.getElementById(picker_name);
		
	if(picker.style.display == "none") {
		picker.style.display = "block";
						
	} else if(picker.style.display == "block") {
		picker.style.display = "none";
	}
	
	if(picker_name == "start_picker") {
		
		var startDay = document.getElementById("start_day"); 
		var startMonth = document.getElementById("start_month"); 
		var startYear = document.getElementById("start_year"); 
		
		var start_month = startMonth.value;
		var start_year = startYear.value;
	
		if(validateMonthYear(start_month, start_year) == false) {
			start_month = 0;
			start_year = 0;
		}
	
		StartDatePicker.setCalDisplay(startDay.value, start_month,start_year);
		var other = document.getElementById("stop_picker");
		
	} else {
		
		var stopDay = document.getElementById("stop_day"); 
		var stopMonth = document.getElementById("stop_month"); 
		var stopYear = document.getElementById("stop_year");
		
		var stop_month = stopMonth.value;
		var stop_year = stopYear.value;		
	
		if(validateMonthYear(stop_month, stop_year) == false) {
			stop_month = 0;
			stop_year = 0;
		}
				
		StopDatePicker.setCalDisplay(stopDay.value, stop_month,stop_year);
		var other = document.getElementById("start_picker");
	} 
	other.style.display = "none";

}

// ###############################################################################################################//






//################################## Tab Switch Controls ########################################################//


// ############### Tab Switch  ####################//
function tabSwitch(element) {

	switch(element.id) {
		
		case("date_select"):
			var body = document.getElementById("date_body");
			break;
			
		case("location_select"):
			var body = document.getElementById("location_body");
			break;
			
		case("contact_select"):
			var body = document.getElementById("contact_body");
			break;
						
			
		case("attach_select"):
			var body = document.getElementById("attach_body");
			break;
						
			
		case("tag_select"):
			var body = document.getElementById("tag_body");
			break;
		
		
		case("option_select"):
			var body = document.getElementById("option_body");
			break;
	}
			
	var tabNav = document.getElementById("tab_nav");
	
	if(tabNav.childNodes[1]) {
		var ul = tabNav.childNodes[1];
	} else {
		var ul = tabNav.childNodes[0];
	}
	
	var lis = ul.getElementsByTagName("li");
		
	for(var i=0; i<lis.length; i++) {
		if(lis[i].className == "select") {
			lis[i].className = "basic";
		}
	}
	
	
	var tabBody = document.getElementById("tab_body");
	
	var divs = tabBody.childNodes;
			
	for(var i=0; i<divs.length; i++) {
		
		if(divs[i].style) {
		
			if(divs[i].style.display == "block") {
				divs[i].style.display = "none";
			}
		}
	}
	
	body.style.display = "block";
	element.className = "select";
	
	
	if(element.id == "attach_select") {
		
		var attFrame = document.getElementById("attachment_frame");
			
			if(attFrame.contentDocument != null) {
			
			var attSuccess = attFrame.contentDocument.getElementById("att_success_message");
			var attRemove = attFrame.contentDocument.getElementById("att_remove_message");
			var attError = attFrame.contentDocument.getElementById("att_error_message");
						
			attSuccess.style.display = "none";
			attRemove.style.display = "none";
			attError.style.display = "none";
			
			}
		
	}
	
	
}


// ############### Toggle Tab Highlight ####################//
function toggleHighlight(tab) {

	if(tab.className == "basic") {
		
		tab.className = "highlight";
		
	} else if(tab.className == "highlight") {
		
		tab.className = "basic";
	}
		
}



function toggleMiniCalHighlight(cell) {

	/*if(tab.className == "basic") {
		
		tab.className = "highlight";
		
	} else if(tab.className == "highlight") {
		
		tab.className = "basic";
	}*/
		
}



function toggleTime() {

	var startTime = document.getElementById("start_time");	
	var startM = document.getElementById("start_m");
	
	var stopTime = document.getElementById("stop_time");	
	var stopM = document.getElementById("stop_m"); 
	
	var timeTo = document.getElementById("time_to"); 
	
	if(startTime.style.display == "none") {
	
		startTime.style.display = "inline";
		startM.style.display = "inline";
		stopTime.style.display = "inline";
		stopM.style.display = "inline";
		timeTo.style.display = "inline";
		
	} else  {
		
		startTime.style.display = "none";
		startM.style.display = "none";
		stopTime.style.display = "none";
		stopM.style.display = "none";
		timeTo.style.display = "none";
		
	}
	

}

// ###############################################################################################################//
