/*
###############################################################

search.js

interface functionality for event search system.

Used by search.php

###############################################################
*/

	
	function disableDateRange() {
	
		var dateSelector = document.getElementById("range_selector"); 
		var dateDisabled = document.getElementById("range_disable");
		var disableRange = document.getElementById("disable_range");	
		var searchDatesFlag = document.getElementById("search_dates");
		
		dateSelector.style.display = "none";		
		dateDisabled.style.display = "block";
		disableRange.style.display = "none";
		searchDatesFlag.value = 0;
	}
	
	
	
	function enableDateRange() {
	
		var dateSelector = document.getElementById("range_selector"); 
		var dateDisabled = document.getElementById("range_disable");
		var disableRange = document.getElementById("disable_range");	
		var searchDatesFlag = document.getElementById("search_dates");
		
		dateSelector.style.display = "block";		
		dateDisabled.style.display = "none";
		disableRange.style.display = "inline";
		searchDatesFlag.value = 1;
	}
	
	
	
	function toggleSearchFilters() {
	
		var Filters = document.getElementById("search_filters"); 
		var toggleLink = document.getElementById("toggle_filters"); 
		var disableRange = document.getElementById("disable_range");	
		var dateSelector = document.getElementById("range_selector");
		var showFilter = document.getElementById("show_filter");
		
		if(Filters.style.display == 'none') {
			Filters.style.display = 'block';
			
			if(dateSelector.style.display == "block") disableRange.style.display = "inline";
			toggleLink.firstChild.nodeValue = "Hide Options";
			showFilter.value = 1;
			
		} else {
			Filters.style.display = 'none';
			disableRange.style.display = "none";
			toggleLink.firstChild.nodeValue = "Show Options";
			showFilter.value = 0;
		}
	}
	
	
	function refreshEventList(page) {
		
		var eventList = document.getElementById("adv_search_form");	
		
		var elSelect = document.getElementById("cal_select");
		var calendarID = document.getElementById("cid");
		var categoryID = document.getElementById("catid");
					
		var elOptions = elSelect.options;
		
		var selectedOption = elOptions[elSelect.selectedIndex];
		
		var selectType = selectedOption.id.substr(0,3);
		
		if(selectType == "cal" ) {
			
			calendarID.value = selectedOption.id.substr(4);
			
		} else if (selectType == "cat") {
			
			categoryID.value = selectedOption.id.substr(4);
			
		}	
		
		
		var pageInput = document.getElementById("page");	
		pageInput.value = page;
		
					
		var listOrderBy = document.getElementById("list_order_by"); 
		var listOrder = document.getElementById("list_order");
		
		var OrderBy = document.getElementById("order_by"); 
		var Order = document.getElementById("order");
		
		
		
		OrderBy.value = listOrderBy.options[listOrderBy.selectedIndex].value;
		Order.value = listOrder.options[listOrder.selectedIndex].value;
		
		eventList.submit();
	}

	
	
	function resetFilter() {
		
		var filters = document.getElementById("search_filters");
		var input = document.getElementById("keywords");	
		input.value = "";
			
		
		var selects = filters.getElementsByTagName("select");
		
		selects[0].selectedIndex = 0;
		selects[1].selectedIndex = 0;
		
		var searchDatesFlag = document.getElementById("search_dates");
		
		if(searchDatesFlag.value == 1) disableDateRange();
		
	}




