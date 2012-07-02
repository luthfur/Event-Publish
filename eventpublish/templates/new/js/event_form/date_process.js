
//###################################### Handler for Date Control in Event Form #########################################################//


// ########## Add a New Date (Validation at Server) - Server Request ##########################/
function addNewDates(path) {

	var startDay = document.getElementById("start_day");
	var startMonth = document.getElementById("start_month");
	var startYear = document.getElementById("start_year");
	
	var stopDay = document.getElementById("stop_day");
	var stopMonth = document.getElementById("stop_month");
	var stopYear = document.getElementById("stop_year");

	var eventType = document.getElementById("event_type");
	
	hideDateErrorMsgs();
	
			
		var query_string = "start_day=" + startDay.value +
							"&start_month=" + startMonth.value +
							"&start_year=" + startYear.value +
							"&stop_day=" + stopDay.value +
							"&stop_month=" + stopMonth.value +
							"&stop_year=" + stopYear.value +
							"&event_type=" + eventType.options[eventType.options.selectedIndex].value;
											
		var loader = new net.ContentLoader(path + 'process/validate_date.php', processDateResponse, showError, 'POST', query_string);

	
}

//#############################################################################################//




// ########## Add a New Date (Validation at Server) - Server Response ##########################/
function processDateResponse() {
	
	// grab xml server response
	var xml  = this.req.responseXML.documentElement;
	var responseElement = xml.getElementsByTagName("response");
		
		
	// check if error message was generated	
	if(responseElement[0].attributes[0].value == "error") {
				
		parseDateError(xml);
		
	// successful validation - date data returned
	} else if(responseElement[0].attributes[0].value == "date") {
		
		var selectedDates = document.getElementById("selected_dates");
		
		// grab the next date id
		var currID = document.getElementById("curr_date_id");
		var new_id = parseInt(currID.value);
		currID.value = parseInt(currID.value) + 1;
		
		// grab the <date> element
		var dateElement = xml.getElementsByTagName("date");
		
		// append new date to the interface
		newDiv = document.createElement("div");
		hiddenP = document.createElement("p");
		firstP = document.createElement("p");
		secondP = document.createElement("p");
		
		var textNode = document.createTextNode(new_id);
		hiddenP.appendChild(textNode);
		hiddenP.style.display = "none";
		
		textNode = document.createTextNode(getXMLElementContent(dateElement[0], 'recurrence'));
		firstP.appendChild(textNode);
		
		textNode = document.createTextNode(getXMLElementContent(dateElement[0], 'range'));
		secondP.appendChild(textNode);
		
		newDiv.appendChild(hiddenP);
		newDiv.appendChild(firstP);
		newDiv.appendChild(secondP);
		
		// append new date to selected list
		selectedDates.appendChild(newDiv);
			
		// add date string
		addDateString(new_id);
		
		// reset the inteface
		resetDateForm();	
		
		// add event handler to the date item
		addEvent(newDiv, 'click', showDateEditForm, false);			
		addEvent(newDiv, 'mouseover',selectedDateHighlight, true);	
		addEvent(newDiv, 'mouseout',selectedDateHighlight, true);
	}
	
		
}
//#############################################################################################################################//



// ###################### Show the Date Add Form  ######################################//
function showDateAddForm() {
	
	resetDateForm();
	
	// change the header
	var dateSelector = document.getElementById("date_selection_area");
	var h3Elm = dateSelector.getElementsByTagName("h3");
	
	h3Elm[0].childNodes[0].nodeValue="Select and Add New Dates";
	
	
	// display the buttons:
	var addDates = document.getElementById("add_dates");
	var deleteDates = document.getElementById("delete_dates");
	var saveDates = document.getElementById("save_dates");
	var addNewDates = document.getElementById("add_new_dates");
	
	saveDates.style.display = "none";
	deleteDates.style.display = "none";
	addDates.style.display = "block";
	addNewDates.style.display = "none";
	
	
}
//####################################################################################//



// ###################### Show the Date Edit Form  ######################################//
function showDateEditForm(e, direct) {
	
	var element;
	
	if(direct) {
		element = e;	
	} else {	
		element = window.event ? window.event.srcElement : e ? e.target : null;
	}
	
	
	var pElm = element.getElementsByTagName("p");
	var id;
	
	// check if event trigger is a div or a p
	if(pElm.length < 1) {
			
		divElm = element.parentNode;
		pElm = divElm.getElementsByTagName("p");
		
	}
	
	
	// grab the date id
	id = pElm[0].childNodes[0].nodeValue;
	
	
	
	// check if date edit form is already loaded for this id
	var dateID = document.getElementById("date_id");
	if(dateID.value == id) return;
	
	
	
	// fetch date data from string
	var dateString = document.getElementById("date_string");
	
	
	// parse date data
	var dateset = dateString.value.split(";");
	var dateitem;
	
	for(var i=0; i<dateset.length; i++) {
		
		dateitem = dateset[i].split(",");
		if(dateitem[0] == id) break;
	}
	
	
	// display date data on form
	var startDay = document.getElementById("start_day");
	var startMonth = document.getElementById("start_month");
	var startYear = document.getElementById("start_year");
	
	var stopDay = document.getElementById("stop_day");
	var stopMonth = document.getElementById("stop_month");
	var stopYear = document.getElementById("stop_year");
	var dateID = document.getElementById("date_id");
	
	var eventType = document.getElementById("event_type");
	
	dateID.value = dateitem[0];
	startDay.value = dateitem[2];
	startMonth.value = dateitem[3];
	startYear.value = dateitem[4];
	stopDay.value = dateitem[5];
	stopMonth.value = dateitem[6];
	stopYear.value = dateitem[7];
	eventType.selectedIndex = parseInt(dateitem[1]) - 1;
	
	toggleRepeat(eventType);	
	
		
	
	// display the buttons:
	var addDates = document.getElementById("add_dates");
	var deleteDates = document.getElementById("delete_dates");
	var saveDates = document.getElementById("save_dates");
	var addNewDates = document.getElementById("add_new_dates");
	
	saveDates.style.display = "block";
	deleteDates.style.display = "block";
	addDates.style.display = "none";
	addNewDates.style.display = "block";
	
	
	
	// change the header
	var dateSelector = document.getElementById("date_selection_area");
	var h3Elm = dateSelector.getElementsByTagName("h3");
	
	h3Elm[0].childNodes[0].nodeValue="Edit Dates";
	
}
//################################################################################################//





//###################### Update Dates (Server Validation) - Server Request ##########################//
function updateDates() {
	
	var startDay = document.getElementById("start_day");
	var startMonth = document.getElementById("start_month");
	var startYear = document.getElementById("start_year");
	
	var stopDay = document.getElementById("stop_day");
	var stopMonth = document.getElementById("stop_month");
	var stopYear = document.getElementById("stop_year");
	var eventType = document.getElementById("event_type");
	
	var query_string = "start_day=" + startDay.value +
							"&start_month=" + startMonth.value +
							"&start_year=" + startYear.value +
							"&stop_day=" + stopDay.value +
							"&stop_month=" + stopMonth.value +
							"&stop_year=" + stopYear.value +
							"&event_type=" + eventType.options[eventType.options.selectedIndex].value;
											
	var loader = new net.ContentLoader('process/validate_date.php', saveDates, showError, 'POST', query_string);
		
			
}
//################################################################################################//



//###################### Update Dates (Server Validation) - Server Response ##########################//
function saveDates() {
				
	var xml  = this.req.responseXML.documentElement;
	
	var responseElement = xml.getElementsByTagName("response");
	
	// display error message on error
	if(responseElement[0].attributes[0].value == "error") {
		
		parseDateError(xml);		
	
	// validation succeeded...parse and update date data
	} else if(responseElement[0].attributes[0].value == "date") {
		
		// grab the date id
		var dateID = document.getElementById("date_id");
		
		// update the date string
		deleteDateString(dateID.value);
		addDateString(dateID.value);
		
		// update the date data display
		var selectedDates = document.getElementById("selected_dates");
		var divItems = selectedDates.getElementsByTagName("div");
		var pElm;	
		
		var dateElement = xml.getElementsByTagName("date");
		
		for(var i=0; i<divItems.length; i++) {
			
			pElm = divItems[i].getElementsByTagName("p");
			
			if(pElm[0].childNodes[0].nodeValue == dateID.value) {
				pElm[1].childNodes[0].nodeValue = getXMLElementContent(dateElement[0], 'recurrence');
				pElm[2].childNodes[0].nodeValue = getXMLElementContent(dateElement[0], 'range');
				break;
			}
			
		}		
		
		// display the add form
		showDateAddForm();
		
	}
	
	
}
//################################################################################################//




//###################### Parse Validation Error and Display Messages ##########################//
function parseDateError(xmlData) {
	
		var errorElement = xmlData.getElementsByTagName("date_error");
		
		// Start Date error
		if(errorElement[0].attributes[0].value == 1) {
			
			var startDateError = document.getElementById("start_date_error");
			var startDateErrorSymb = document.getElementById("start_date_error_symb");
			
			startDateErrorSymb.style.display = "inline";
			startDateError.style.display = "inline";
		
		// Stop date error
		} else if(errorElement[0].attributes[0].value == 2) {
			
			var stopDateError = document.getElementById("stop_date_error");
			var stopDateErrorSymb = document.getElementById("stop_date_error_symb");
			
			stopDateError.style.display = "inline";
			stopDateErrorSymb.style.display = "inline";
		
		// Date comparison error
		} else if(errorElement[0].attributes[0].value == 3) {
			
			var dateCompareError = document.getElementById("date_compare_error");
			var dateCompareErrorSymb = document.getElementById("date_compare_error_symb");
			
			dateCompareError.style.display = "inline";
			dateCompareErrorSymb.style.display = "inline";
		}
	
}
//################################################################################################//



//############################# Delete a date from #################################################//
function deleteDates() {
	
	var dateID = document.getElementById("date_id");
	
	deleteDateString(dateID.value);
	
	var selectedDates = document.getElementById("selected_dates");
	var divItems = selectedDates.getElementsByTagName("div");
	var pElm;
	
	
	for(var i=0; i<divItems.length; i++) {
		
		pElm = divItems[i].getElementsByTagName("p");
		
		if(pElm[0].childNodes[0].nodeValue == dateID.value) {
			selectedDates.removeChild(divItems[i]);
			break;
		}
		
	}
	
	showDateAddForm();
	
}
//################################################################################################//




//############################# Add a new date to the date string #################################//
function addDateString(id) {
	
	// setup values for server transfer
	var dateString = document.getElementById("date_string");
	var startDay = document.getElementById("start_day");
	var startMonth = document.getElementById("start_month");
	var startYear = document.getElementById("start_year");
	
	var stopDay = document.getElementById("stop_day");
	var stopMonth = document.getElementById("stop_month");
	var stopYear = document.getElementById("stop_year");

	var eventType = document.getElementById("event_type");
	
	dateString.value += id + "," + eventType.options[eventType.options.selectedIndex].value + ","
								+ startDay.value + ","
								+ startMonth.value + ","
								+ startYear.value + ","
								+ stopDay.value + ","
								+ stopMonth.value + ","
								+ stopYear.value + ";";
								
}
//################################################################################################//




//############################# Delete a date from the date string #################################//
function deleteDateString(id) {
	
	var dateString = document.getElementById("date_string");
	
	var dateset = dateString.value.split(";");
	var new_datestring = "";
	var dateitem;
	
	for(var i=0; i<dateset.length - 1; i++) {
		
		dateitem = dateset[i].split(",");
		if(dateitem[0] != id) new_datestring += dateset[i] + ";";
	}
		
	dateString.value = new_datestring;
	
}
//################################################################################################//




//################################## Reset Date Form ###########################################//
function resetDateForm() {
	
	var startDay = document.getElementById("start_day");
	var startMonth = document.getElementById("start_month");
	var startYear = document.getElementById("start_year");
	
	var stopDay = document.getElementById("stop_day");
	var stopMonth = document.getElementById("stop_month");
	var stopYear = document.getElementById("stop_year");

	var eventType = document.getElementById("event_type");
	
	hideDateErrorMsgs();
	
	startDay.value = "dd";
	startMonth.value = "mm";
	startYear.value = "yyyy";
	stopDay.value = "dd";
	stopMonth.value = "mm";
	stopYear.value = "yyyy";
	eventType.selectedIndex = 0;
	
	toggleRepeat(eventType);
	
		
}
//################################################################################################//




//############################# Hide Date Error Messages #######################################//
function hideDateErrorMsgs() {

	var startDateError = document.getElementById("start_date_error");
	var startDateErrorSymb = document.getElementById("start_date_error_symb");
	
	var stopDateError = document.getElementById("stop_date_error");
	var stopDateErrorSymb = document.getElementById("stop_date_error_symb");
		
	var dateCompareError = document.getElementById("date_compare_error");
	var dateCompareErrorSymb = document.getElementById("date_compare_error_symb");
	
	var dateStringError = document.getElementById("date_string_error");
	
	startDateError.style.display = "none";
	startDateErrorSymb.style.display = "none";
	stopDateError.style.display = "none";
	stopDateErrorSymb.style.display = "none";
	dateCompareError.style.display = "none";
	dateCompareErrorSymb.style.display = "none";
	dateStringError.style.display = "none";
}

//################################################################################################//




function selectedDateHighlight(e) {

	var element = window.event ? window.event.srcElement : e ? e.target : null;
	var type = window.event ? window.event.type : e ? e.type : null;
		
	if(!checkMouseLeave (element, e)) return;
	
	if(element.tagName.toLowerCase() != "div") return;
			
	if(type == "mouseout") {
		element.className="";
	} else {
		element.className="selected_date_highlight";
	}

}




/********************** Helpers ******************************/
	function containsDOM (container, containee) {
	
	  var isParent = false;
	  do {
		
		if (isParent = (container == containee))
		  break;
		containee = containee.parentNode;
	  }
	  while (containee != null);
	  return isParent;
	}


	function checkMouseLeave (element, evt) {
	 		  
	  evt = (evt) ? evt : ((window.event) ? window.event : "");
	  
	  if (evt.relatedTarget) {
		  
		return !containsDOM(element, evt.relatedTarget);
		
	  } else {
		  
			if (element.contains(evt.toElement)) {
					return(false);
			} else {
					return(true);
			}
			
	  }
	  
	}
	/*************************************************************/


//################################################################################################################################################//
