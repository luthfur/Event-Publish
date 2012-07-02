   function toggleDateRange() {
	
		var dateSelector = document.getElementById("range_selector"); 
		var allDates = document.getElementById("all_dates");
		var toggleDateLink = document.getElementById("toggle_date");
		var searchDatesFlag = document.getElementById("search_dates");
		
		if(dateSelector.style.display == "none") {
			
			dateSelector.style.display = "inline";		
			allDates.style.display = "none";
			toggleDateLink.childNodes[0].nodeValue = "Search All Dates";
			searchDatesFlag.value = 1;
					
		} else {
			
			dateSelector.style.display = "none";		
			allDates.style.display = "inline";
			toggleDateLink.childNodes[0].nodeValue = "Select Date Range";
			searchDatesFlag.value = 0;
		}
		
		
	}
	
	
	function toggleFilter() {
		
		var filterDiv = document.getElementById("filters"); 
		var filterUp = document.getElementById("filter_up");
		var filterDown = document.getElementById("filter_down");
		var sections = filterDiv.getElementsByTagName("p");
		var msg = filterDiv.getElementsByTagName("i");
		var showFilter = document.getElementById("show_filter");
		
		if(filterUp.style.display == "none") {
	
			filterUp.style.display = "inline";
			filterDown.style.display = "none";
			msg[0].style.display = "none";
			showFilter.value = 1;
	
		} else {
			
			filterUp.style.display = "none";
			filterDown.style.display = "inline";
			msg[0].style.display = "inline";
			showFilter.value = 0;
			
		}
		
		for(i=0; i<sections.length; i++) {
			
			if(sections[i].style.display == "none") {
				sections[i].style.display = "block";
			} else {
				sections[i].style.display = "none";
			}
			
		}
		
	}
	
	
	
	function refreshEventList(page) {
		
		var eventList = document.getElementById("filter_form");	
		
		var elSelect = document.getElementById("cal_select");
		var calendarID = document.getElementById("cid");
		var categoryID = document.getElementById("catid");
		
		if(elSelect) {	
		
			var elOptions = elSelect.options;
			
			var selectedOption = elOptions[elSelect.selectedIndex];
			
			var selectType = selectedOption.id.substr(0,3);
			
			if(selectType == "cal" ) {
				
				calendarID.value = selectedOption.id.substr(4);
				
			} else if (selectType == "cat") {
				
				categoryID.value = selectedOption.id.substr(4);
				
			}	
			
		} else {
			
			calendarID.value = 0;
			categoryID.value = 0;
			
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
			
		var filterDiv = document.getElementById("filters"); 
		var ps = filterDiv.getElementsByTagName("p");
			
		var input = ps[0].getElementsByTagName("input");	
		input[0].value = "";
		
		var selects =  ps[1].getElementsByTagName("select");
		
		selects[0].selectedIndex = 0;
		selects[1].selectedIndex = 0;
		selects[2].selectedIndex = 0;
		
		
		var searchDatesFlag = document.getElementById("search_dates");
		
		if(searchDatesFlag.value == 1) toggleDateRange();
		
		selects =  ps[3].getElementsByTagName("select");
		selects[0].selectedIndex = 0;
		
		chks =  ps[3].getElementsByTagName("input");
		chks[0].checked = 0;
		chks[1].checked = 0;
	}
	
	
	function tagSearch(tag) {
		resetFilter();
		document.getElementById("keywords").value=tag;
		refreshEventList(1);
	}
			
		
	