

// ############################### Display Functions #############################################################//
var calendar_tool_flag = false;  // when set to true, indicates that a calendar tool is currently active.





// ###############################  Calendar Actions #########################################################//


function addNewCalendar() {
			
	var newCalendar = document.getElementById("new_calendar_name");
	
	// display processing icon
	var process = document.getElementById("new_calendar_process");
	process.style.display = "inline";
			
	// validate user input
	if(newCalendar.value.trim() == "") return;
	
	// send query to server
	var query_string = "calendar_name=" + newCalendar.value + "&category_id=0";
					
	var loader = new net.ContentLoader('process/add_calendar.php', addCalendarToInterface, showError, 'POST', query_string);
	
	
	
}


//################ Add New Calendar - Interface Update ####################################//
function addCalendarToInterface() {
		
	var calendarXML  = this.req.responseXML.documentElement;
	
	
	// fetch data from xml doc
	var calendarDataSet = calendarXML.getElementsByTagName("calendar");
	var new_calendar_name = getXMLElementContent(calendarDataSet[0], 'name');
	var new_id = calendarDataSet[0].attributes[0].value;
	var category_id = getXMLElementContent(calendarDataSet[0], 'category');
		
	// calendar set
	var calendarSet = document.getElementById("calendar_set_" + category_id);
	if(calendarSet == null) calendarSet = document.getElementById("calendar_set");
		
		// calendar details template
		var calendarTemplate = document.getElementById("calendar_details_template");
		var newCalendarDetails = calendarTemplate.cloneNode(true);
		newCalendarDetails.style.display = "block";	
		
		
		// set the calendar name
		var h3s = newCalendarDetails.getElementsByTagName("h3");
		h3s[0].childNodes[0].nodeValue=new_calendar_name;
		
		var divs = newCalendarDetails.getElementsByTagName("div");
		
		newCalendarDetails.setAttribute("id", "calendar_" + new_id);
		divs[0].setAttribute("id", "calendar_stat_" + new_id);		// event stat
		divs[1].setAttribute("id", "calendar_tools_" + new_id);		// event tools
		divs[2].setAttribute("id", "calendar_move_" + new_id);		// event move
		divs[3].setAttribute("id", "calendar_edit_" + new_id);		// event edit
		
		var selects = divs[2].getElementsByTagName("select");
		selects[0].setAttribute("id", "calendar_move_to_" + new_id);		// category selector
		
		var inputs = divs[3].getElementsByTagName("input");
		inputs[0].setAttribute("id", "calendar_name_to_" + new_id);		// category selector
		
		// add new calendar details and controls to category
		calendarSet.insertBefore(newCalendarDetails, calendarSet.childNodes[0]);
	
	
	// Clean up the interface
		
	var process = document.getElementById("new_calendar_process");	
	process.style.display = "none";
	
	NewCalendarForm = document.getElementById("new_calendar");
	NewCalendarForm.style.display = "none";
	
	calendar_tool_flag = false;

}





function updateCalendar(elm) {
	
	// calendar id
	var div = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = div[2];

	
	var calendar_editor = "calendar_edit_" + id;
	var calEditor = document.getElementById(calendar_editor);

	
	// display processing icon
	var spans = calEditor.getElementsByTagName("span");
	spans[0].style.display = "inline";
	
	var newCalendarName = document.getElementById("calendar_name_to_" + id);
			
	// validate user input
	if(newCalendarName.value.trim() == "") return;
	
	// send query to server
	var query_string = "calendar_name=" + newCalendarName.value + "&calendar_id=" + id;
						
	var loader = new net.ContentLoader('process/update_calendar.php', updateCalendarInterface, showError, 'POST', query_string);
	
		
}




//################ Update Calendar - Interface Update ####################################//
function updateCalendarInterface() {
		
	//var calendarXML  = this.req.responseXML.documentElement;
	var calendarXML  = this.req.responseXML.documentElement;
			
	// fetch data from xml doc
	var calendarDataSet = calendarXML.getElementsByTagName("calendar");
	var new_calendar_name = getXMLElementContent(calendarDataSet[0], 'name');
	var calendar_id = calendarDataSet[0].attributes[0].value;
	
	var newCalendarName = document.getElementById("calendar_name_to_" + calendar_id);
	
	var calendarDiv = document.getElementById("calendar_" + calendar_id);
	
	// set the calendar name
	if(newCalendarName.value.trim() != "") {
		var h3s = calendarDiv.getElementsByTagName("h3");
		h3s[0].childNodes[0].nodeValue=newCalendarName.value;
	}
	
	var calendar_editor = "calendar_edit_" + calendar_id;
	var calendar_tools = "calendar_tools_" + calendar_id;
	
	calEditor = document.getElementById(calendar_editor);
	calEditor.style.display = "none";
	
	// display processing icon
	var spans = calEditor.getElementsByTagName("span");
	spans[0].style.display = "none";
	
	calTools = document.getElementById(calendar_tools);
	calTools.style.display = "block";
	
	calendar_tool_flag = false;


}




function deleteCalendar(elm) {
	
	var calendarDiv = elm.parentNode.getAttribute("id").split("_");
	var id = calendarDiv[2];
	
	
	if(confirm("Are you sure you want to delete this calendar?")) {
		// send query to server
		var query_string = "calendar_id=" + id;
		
		
		// hide processing icon
		var processing = document.getElementById("calendar_stat_"+ id).getElementsByTagName("span");
		processing[0].style.display = "inline";
									
		var loader = new net.ContentLoader('process/delete_calendar.php', deleteCalendarFromInterface, showError, 'POST', query_string);
	}
	
}




//################ Update Calendar - Interface Update ####################################//
function deleteCalendarFromInterface() {
	
	var id  = this.req.responseText;
		
	var calendarDiv = document.getElementById("calendar_" + id);
	var calSet = calendarDiv.parentNode;		
	calSet.removeChild(calendarDiv);
	
	// hide processing icon
		var processing = document.getElementById("calendar_stat_"+ id).getElementsByTagName("span");
		processing[0].style.display = "none";
	
}



// #####################################################################################################//








function showNewCalendarForm() {

	new Effect.Appear("new_calendar", {duration:0.2});
	
	var newCalendarName = document.getElementById("new_calendar_name");
	setTimeout("newCalendarName.focus()", 1000);
	
	newCalendarName.value ="";
		
}


function cancelNewCalendarForm() {	
	
	var newCalendarName = document.getElementById("new_calendar_name");
	newCalendarName.value = "";
	
	var calForm = document.getElementById("new_calendar");
	calForm.style.display = "none";
	
	
}




function showEditCalendar(elm) {
		
	var calendarToolsDiv = elm.parentNode.getAttribute("id").split("_");
	var id = calendarToolsDiv[2];
	
	calNameElm = elm.parentNode.parentNode.getElementsByTagName("h3");
	var current_name = calNameElm[0].childNodes[0].nodeValue;
	
	var calendar_editor = "calendar_edit_" + id;
	var calendar_tools = "calendar_tools_" + id;
	var calendar_name_to = "calendar_name_to_" + id;
	
	var calTools = document.getElementById(calendar_tools);
	calTools.style.display = "none";
	
	var calEditor = document.getElementById(calendar_editor);
	calEditor.style.display = "block";	
	
	
	var calNameTo = document.getElementById(calendar_name_to);
	calNameTo.value = current_name;
	
	
	calendar_tool_flag = true;
	
}



function cancelEditCalendar(elm) {
	
	var calendarEditDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = calendarEditDiv[2];
	
	var calendar_editor = "calendar_edit_" + id;
	var calendar_tools = "calendar_tools_" + id;
	
	calEditor = document.getElementById(calendar_editor);
	calEditor.style.display = "none";
	
	calTools = document.getElementById(calendar_tools);
	calTools.style.display = "block";
	
	calendar_tool_flag = false;
	
}



function showCalendarTools(elm) {
	
	if(calendar_tool_flag == true) return;
	
	var calendarDiv = elm.getAttribute("id").split("_");
	var id = calendarDiv[1];
	
	var calendar_stat = "calendar_stat_" + id;
	var calendar_tools = "calendar_tools_" + id;
		
	calStat = document.getElementById(calendar_stat);
	calStat.style.display = "none";
	
	calTools = document.getElementById(calendar_tools);
	calTools.style.display = "block";
	
	
}



function hideCalendarTools(elm) {
	
	if(calendar_tool_flag == true) return;
	
	calendarDiv = elm.getAttribute("id").split("_");
	
	var id = calendarDiv[1];
	
	var calendar_stat = "calendar_stat_" + id;
	var calendar_tools = "calendar_tools_" + id;
	
	calStat = document.getElementById(calendar_stat);
	calStat.style.display = "block";
	
	calTools = document.getElementById(calendar_tools);
	calTools.style.display = "none";
	
}



// ########################################################################################################### //