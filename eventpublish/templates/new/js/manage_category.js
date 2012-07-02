

// ############################### Display Functions #############################################################//
var calendar_tool_flag = false;  // when set to true, indicates that a calendar tool is currently active.





// ###############################  Calendar Actions #########################################################//


function addNewCalendar(elm) {
			
	// grab the category id
	var categoryDiv = elm.parentNode.parentNode;
	var categoryID = categoryDiv.getAttribute("id").split("_");
	var category_id = categoryID[2];
	
	var newCalendar = document.getElementById("new_calendar_name_" + category_id);
	
	// display processing icon
	var spans = categoryDiv.getElementsByTagName("span");
	spans[0].style.display = "inline";
			
	// validate user input
	if(newCalendar.value.trim() == "") return;
	
	// send query to server
	var query_string = "calendar_name=" + newCalendar.value + "&category_id=" + category_id;
					
	var loader = new net.ContentLoader('process/add_calendar.php', addCalendarToInterface, showError, 'POST', query_string);
	
	
	
}


//################ Add New Calendar - Interface Update ####################################//
function addCalendarToInterface() {
	
	//alert(this.req.responseText);
	
	var calendarXML  = this.req.responseXML.documentElement;
	
	
	// fetch data from xml doc
	var calendarDataSet = calendarXML.getElementsByTagName("calendar");
	var new_calendar_name = getXMLElementContent(calendarDataSet[0], 'name');
	var new_id = calendarDataSet[0].attributes[0].value;
	var category_id = getXMLElementContent(calendarDataSet[0], 'category');
		
	// calendar set
	var calendarSet = document.getElementById("calendar_set_" + category_id);
	if(calendarSet == null) {
		calendarSet = document.getElementById("calendar_set");
	}
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
		if(calendarSet.childNodes[0] == null) {
			calendarSet.appendChild(newCalendarDetails);
		} else {
			calendarSet.insertBefore(newCalendarDetails, calendarSet.childNodes[0]);
		}
		
	
	// Clean up the interface
	
	var NewCalendarForm = document.getElementById("new_calendar_" + category_id);
	NewCalendarForm.style.display = "none";
	
	var processes = NewCalendarForm.getElementsByTagName("span");
	processes[0].style.display = "none";
	
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






function moveCalendar(elm) {		
	
	var calendarDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = calendarDiv[2];
		
	var calendarTo = document.getElementById("calendar_move_to_" + id);
	var calendar = document.getElementById("calendar_" + id);
	
	var category_id = calendarTo.options[calendarTo.selectedIndex].value;
	
	var calSetTo = document.getElementById("calendar_set_" + category_id);
	var calSetFrom = calendar.parentNode;
	
	if(calSetTo != calSetFrom) {
		// send query to server
		var query_string = "calendar_id=" + id + "&category_id=" + category_id;
		var loader = new net.ContentLoader('process/move_calendar.php', moveCalendarInInterface, showError, 'POST', query_string);			
	}	
	
	
}


function moveCalendarInInterface(){
	
	var calendarXML  = this.req.responseXML.documentElement;
			
	// fetch data from xml doc
	var calendarDataSet = calendarXML.getElementsByTagName("calendar");
	var category_id = getXMLElementContent(calendarDataSet[0], 'category');
	var id = calendarDataSet[0].attributes[0].value;
	
	
	var calendar = document.getElementById("calendar_" + id);
	
	var calSetTo = document.getElementById("calendar_set_" + category_id);
		
	calSetTo.appendChild(calendar);
			
	// hide calendar tool box
	var calendar_move = "calendar_move_" + id;
	var calendar_stat = "calendar_stat_" + id;
	
	calMove = document.getElementById(calendar_move);
	calMove.style.display = "none";
	
	calStat = document.getElementById(calendar_stat);
	calStat.style.display = "block";
	
	calendar_tool_flag = false;
	
	cleanCategoryList(calMove);
	
}




// #####################################################################################################//






// ###############################  Category Actions ######################################################//

function addNewCategory() {
	
	var categoryName = document.getElementById("category_name");
			
	if(categoryName.value.trim() == "") return;
	
	// display processing icon
	var processing = document.getElementById("new_category").getElementsByTagName("span");
	processing[0].style.display = "inline";
	
	var query_string = "cat_name=" + categoryName.value.trim();
	var loader = new net.ContentLoader('process/add_category.php', createNewCategory, showError, 'POST', query_string);
	
	
	
}



function createNewCategory() {
	
	var categoryXML = this.req.responseXML.documentElement;
	
	// fetch data from xml doc
	var categoryDataSet = categoryXML.getElementsByTagName("category");
	var category_name = getXMLElementContent(categoryDataSet[0], 'name');
	var category_id = categoryDataSet[0].attributes[0].value;
			
	// category details template
	var categoryTemplate = document.getElementById("category_template");
	var newCategory = categoryTemplate.cloneNode(true);
	newCategory.style.display = "block";
	
	var calendarList = document.getElementById("calendar_list");
	calendarList.insertBefore(newCategory, calendarList.childNodes[0]);
	
	var h3s = newCategory.getElementsByTagName("h3");
	h3s[0].childNodes[0].nodeValue = category_name;
	
	var mainDiv = h3s[0].parentNode;
	mainDiv.setAttribute("id", "category_" + category_id);
	
	var childDivs = mainDiv.getElementsByTagName("div");
	
	childDivs[1].setAttribute("id", "edit_category_" + category_id);		// edit category
	childDivs[2].setAttribute("id", "new_calendar_" + category_id);		// new calendar
	childDivs[3].setAttribute("id", "calendar_set_" + category_id);		// calendar set

	
	var inputs = mainDiv.getElementsByTagName("input");
	inputs[0].setAttribute("id", "new_category_name_" + category_id);		// edit category
	inputs[2].setAttribute("id", "new_calendar_name_" + category_id);		// edit category
	
	
	
	var newCategoryForm = document.getElementById("new_category");
	newCategoryForm.style.display = "none";
	
	var categoryName = document.getElementById("category_name");
	categoryName.value = "";
	
	// hide processing icon
	var processing = document.getElementById("new_category").getElementsByTagName("span");
	processing[0].style.display = "none";
}




function updateCategory(elm) {
	
	var categoryDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = categoryDiv[2];
	
	var categoryName = document.getElementById("new_category_name_" + id);
	if(categoryName.value.trim() == "") return;
	
	var processing = document.getElementById("edit_category_" + id).getElementsByTagName("span");
	processing[0].style.display = "inline";
	
	var query_string = "cat_name=" + categoryName.value.trim() + "&cat_id=" + id;
	var loader = new net.ContentLoader('process/update_category.php', updateCategoryInInterface, showError, 'POST', query_string);
			
}



function updateCategoryInInterface(){
	
	var categoryXML = this.req.responseXML.documentElement;
	
	// fetch data from xml doc
	var categoryDataSet = categoryXML.getElementsByTagName("category");
	var category_name = getXMLElementContent(categoryDataSet[0], 'name');
	var id = categoryDataSet[0].attributes[0].value;
		
	var categoryDiv = document.getElementById("category_" + id);
		
	var h3s = categoryDiv.getElementsByTagName("h3");
	h3s[0].childNodes[0].nodeValue = category_name;

	
	var catForm = document.getElementById("edit_category_" + id);
	catForm.style.display = "none";
	
	var processing = catForm.getElementsByTagName("span");
	processing[0].style.display = "none";
	
}




function deleteCategory(elm) {
	
	var categoryDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = categoryDiv[1];
	
	if(confirm("Are you sure you want to delete this category? (All calendars in this category will also be deleted.)")) {
		
		var processing = document.getElementById("category_" + id).getElementsByTagName("span");
		processing[0].style.display = "inline";
		
		var query_string = "cat_id=" +id;
		var loader = new net.ContentLoader('process/delete_category.php', deleteCategoryFromInterface, showError, 'POST', query_string);	
	
	}
	
	
}



function deleteCategoryFromInterface(){
	
	var id = this.req.responseText;
	
	categoryDiv = document.getElementById("category_" + id);
	
	var calendarList = categoryDiv.parentNode;
	
	calendarList.removeChild(categoryDiv);
	
	var processing = document.getElementById("category_" + id).getElementsByTagName("span");
	processing[0].style.display = "none";
}



// #####################################################################################################//




function showNewCalendarForm(elm) {
	
	var categoryDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = categoryDiv[1];
	
	var editCategoryForm = document.getElementById("edit_category_" + id);
			
	editCategoryForm.style.display = "none";
	
	new Effect.Appear("new_calendar_" + id, {duration:0.2});
	
	var newCalendarName = document.getElementById("new_calendar_name_" + id);
	setTimeout("newCalendarName.focus()", 1000);
	
	newCalendarName.value ="";
		
}









function cancelNewCalendarForm(elm) {
	
	var categoryDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = categoryDiv[2];
	
	var newCalendarName = document.getElementById("new_calendar_name_" + id);
	newCalendarName.value = "";
	
	var calForm = document.getElementById("new_calendar_" + id);
	calForm.style.display = "none";
	
	
}




function showEditCategoryForm(elm) {
	
	var categoryDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = categoryDiv[1];
	
	categoryDiv = document.getElementById("category_" + id);
	
	var h3s = categoryDiv.getElementsByTagName("h3");
	var current_name = h3s[0].childNodes[0].nodeValue;
	
	var calForm = document.getElementById("new_calendar_" + id);
	calForm.style.display = "none";
		
	new Effect.Appear("edit_category_" + id, {duration:0.2});
	
	
	var newCategoryName = document.getElementById("new_category_name_" + id);
	newCategoryName.value=current_name;
	
	setTimeout("newCategoryName.focus()", 1000);
		
}


function cancelEditCategoryForm(elm) {
	
	var categoryDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = categoryDiv[2];
	
	var newCategoryName = document.getElementById("new_category_name_" + id);
		
	var catForm = document.getElementById("edit_category_" + id);
	catForm.style.display = "none";
	
	
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





function showMoveCalendar(elm) {
		
	var calendarToolsDiv = elm.parentNode.getAttribute("id").split("_");
	var id = calendarToolsDiv[2];
	
	var calendar_move = "calendar_move_" + id;
	var calendar_tools = "calendar_tools_" + id;
	
	calTools = document.getElementById(calendar_tools);
	calTools.style.display = "none";
	
	calMove = document.getElementById(calendar_move);
	calMove.style.display = "block";
	
	cleanCategoryList(calMove);
	populateCategoryList(calMove);
	
	calendar_tool_flag = true;
	
}



function cancelMoveCalendar(elm) {
	
	var calendarMoveDiv = elm.parentNode.parentNode.getAttribute("id").split("_");
	var id = calendarMoveDiv[2];
	
	var calendar_move = "calendar_move_" + id;
	var calendar_tools = "calendar_tools_" + id;
	
	calMove = document.getElementById(calendar_move);
	calMove.style.display = "none";
	
	calTools = document.getElementById(calendar_tools);
	calTools.style.display = "block";
	
	calendar_tool_flag = false;
	
	cleanCategoryList(calMove);
	
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





function showNewCategoryForm() {
	
	
	new Effect.Appear("new_category", {duration:0.2});
		
	
		
}


function cancelNewCategoryForm() {
	
	var newCategoryForm = document.getElementById("new_category");
			
	newCategoryForm.style.display = "none";
	
	
}



function populateCategoryList(move_elm) {
	
	var calendarList = document.getElementById("calendar_list");
	var currNode;
	var divs;
	var select_node;
	
	// get category divs
		
	for(var i=0; i<calendarList.childNodes.length; i++) {
		//catHeader = calendarList.childNodes[i].childNodes[0];
		//alert(h3s[0]);	
		divNode = calendarList.childNodes[i];
		if(divNode.tagName == "DIV" && divNode.getAttribute("id") != "category_template" && divNode.getAttribute("id") != "calendar_details_template") {
			
			h3 = divNode.getElementsByTagName("h3");
			
			// grab the select node
			select_nodes = move_elm.getElementsByTagName("select");
						
			createCategoryOptions(divNode.getAttribute("id"), h3[0].childNodes[0].nodeValue, select_nodes[0]);
			
		}
	}
	
	
}

function createCategoryOptions(id, name, select_elm) {
	
	// parse out the id
	var category_ids = id.split("_");
	
	var cat_id = category_ids[1]; // the second portion has the id
	
	// create the new option node
	var opt = document.createElement("option");
	
	//set the select node
	try {
		var opt = document.createElement("option");
		opt.setAttribute("value", cat_id);
		var txt = document.createTextNode(name);
		opt.appendChild(txt);
	
		select_elm.add(opt, null);
	
	} catch(ex) {
		var newOption = document.createElement("option");
		newOption.value = cat_id;
		newOption.text = name;
		select_elm.add(newOption, select_elm.selectedIndex); // IE only
	}
}


function cleanCategoryList(move_elm) {
	
	var select_nodes = move_elm.getElementsByTagName("select");
	var sel_node = select_nodes[0];
	
	for(i=0; i<sel_node.length; i++) {
		sel_node.remove(i);
		i--;
	}
	
}


// ########################################################################################################### //