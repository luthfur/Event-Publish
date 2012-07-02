/*
###############################################################

sidebar.js

interface functionality for the sidebar.

Used in the event calendar views. 

###############################################################
*/


function goToCalendar() {
	
	if(document.getElementById("sidebar") == null) return;
	
	var elForm = document.getElementById("calfilter");
	var elSelect = document.getElementById("cal_select");
	var elView = document.getElementById("calselect_view");
	
	var elOptions = elSelect.options;
	
	var selectedOption = elOptions[elSelect.selectedIndex];
	
	var selectType = selectedOption.id.substr(0,3);
	
	if(selectType == "cal" ) {
		
		elView.value = selectType;
		
	} else if (selectType == "cat") {
		
		elView.value = selectType;
		
	}
	
	elForm.submit();
	
	
}



function toggle(e) {
		
		var el = window.event ? window.event.srcElement : e ? e.target : null;

		if(!el) return;	
		
		if(document.getElementById("sidebar") == null) return;
				
		var element = el.parentNode;
	
		
		switch (element.getAttribute('id')) {
		
			case 'search_toggle':
				var bodyElement =  document.getElementById("search_body"); 
				var Plus =  document.getElementById("search_plus");
				var Minus =  document.getElementById("search_minus");
				break;
			
			case 'select_toggle':
				var bodyElement =  document.getElementById("view_event_body"); 
				var Plus =  document.getElementById("select_plus");
				var Minus =  document.getElementById("select_minus");
				break;

			case 'option_toggle':
				var bodyElement =  document.getElementById("option_body"); 
				var Plus =  document.getElementById("option_plus");
				var Minus =  document.getElementById("option_minus");
				break;

		}
		

		bodyElement.style.display = (bodyElement.style.display == 'none') ? 'block' : 'none';
		
		if(bodyElement.style.display == 'none') {
			Plus.style.display = 'block';
			Minus.style.display = 'none';
		} else {
			Plus.style.display = 'none';
			Minus.style.display = 'block';
		}



	}

	

	
	function toggleSideBar(e) {
		
		var element = window.event ? window.event.srcElement : e ? e.target : null;

		if(!element) return;
		
		if(document.getElementById("sidebar") == null) return;
		
		var sideBar = document.getElementById("sidebar"); 
		var eventDisplay = document.getElementById("event_display");
		
		if(sideBar.style.display == 'none') {
			
			sideBar.style.display = 'block';
			eventDisplay.className = 'event_display';
			document.getElementById("show_sidebar_icon").style.display = "none";
			document.getElementById("hide_sidebar_icon").style.display = "inline";

		} else {

			sideBar.style.display = 'none';
			eventDisplay.className = 'event_display_wide';
			document.getElementById("show_sidebar_icon").style.display = "inline";
			document.getElementById("hide_sidebar_icon").style.display = "none";
		
		
		}
		

	}

	

	/*********** Erase text from sidebar ***************/
	function erase(e) {

		var element = window.event ? window.event.srcElement : e ? e.target : null;

		if(!element) return;	

		element.value = "";

	}




	function initSideBar(showBar, showMiniCal) {
		
		if(document.getElementById("sidebar") == null) return;
		
		var sideBar = document.getElementById("sidebar");
		var miniCalendar = document.getElementById("minicalendar");
		var eventDisplay = document.getElementById("event_display");
		
		if(showBar == false) {
			sideBar.style.display = 'none';
			document.getElementById("show_sidebar_icon").style.display = "inline";
			document.getElementById("hide_sidebar_icon").style.display = "none";
			if(eventDisplay != null) eventDisplay.className = 'event_display_wide';
			
		} else {
			sideBar.style.display = 'block';
			document.getElementById("hide_sidebar_icon").style.display = "inline";
			document.getElementById("show_sidebar_icon").style.display = "none";
			if(eventDisplay != null) eventDisplay.className = 'event_display';
			
			if(showMiniCal == true) {
				miniCalendar.style.display = 'block';								
			}
			
		}
		
		


		searchPlus =  document.getElementById("search_plus"); 
		selectPlus =  document.getElementById("select_plus");
		optionPlus =  document.getElementById("option_plus");
		
		searchMinus =  document.getElementById("search_minus"); 
		selectMinus =  document.getElementById("select_minus");
		optionMinus =  document.getElementById("option_minus");
					

		// Sidebar toggler
		if(document.getElementById("bar_toggle"))  {
			barToggle = document.getElementById("bar_toggle");
			addEvent(barToggle, 'click', toggleSideBar, false);
		}
		
			
		addEvent(searchPlus, 'click', toggle, false);
		addEvent(selectPlus, 'click', toggle, false);
		addEvent(optionPlus, 'click', toggle, false);
		
		addEvent(searchMinus, 'click', toggle, false);
		addEvent(selectMinus, 'click', toggle, false);
		addEvent(optionMinus, 'click', toggle, false);
		
		

	}



