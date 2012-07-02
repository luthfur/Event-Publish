
	var clicked = 0;

	function changeTab(e) {
		
		var element = window.event ? window.event.srcElement : e ? e.target : null;

		if(!element) return;
		
		eventTab =  document.getElementById("event_tab"); 
		locTab =  document.getElementById("loc_tab"); 
		contactTab =  document.getElementById("contact_tab"); 
		attTab =  document.getElementById("att_tab"); 


		eventTab.className = 'tab';
		locTab.className = 'tab';
		contactTab.className = 'tab';
		attTab.className = 'tab';		
		
		
		eventBody =  document.getElementById("event"); 
		locBody =  document.getElementById("loc"); 
		contactBody =  document.getElementById("contact"); 
		attBody =  document.getElementById("att"); 
		
	
		eventBody.style.display = 'none';
		locBody.style.display = 'none';
		contactBody.style.display = 'none';
		attBody.style.display = 'none';
		

		switch (element.getAttribute('id')) {
			
			case 'event_link':
				eventTab.className = 'tab_select';
				eventBody.style.display = 'inline';
				break;

			case 'event_tab':
				eventTab.className = 'tab_select';
				eventBody.style.display = 'inline';
				break;
			
			case 'loc_link':
				locTab.className = 'tab_select';
				locBody.style.display = 'inline';
				break;
			
			case 'loc_tab':
				locTab.className = 'tab_select';
				locBody.style.display = 'inline';
				break;

			case 'contact_link':
				contactTab.className = 'tab_select';
				contactBody.style.display = 'inline';
				break;
			
			case 'contact_tab':
				contactTab.className = 'tab_select';
				contactBody.style.display = 'inline';
				break;

			case 'att_link':
				attTab.className = 'tab_select';
				attBody.style.display = 'inline';
				break;
				
			case 'att_tab':
				attTab.className = 'tab_select';
				attBody.style.display = 'inline';
				break;
		
		}
		

		clicked = 1;

	
	}



	function highlightTab(e) {
		
		var element = window.event ? window.event.srcElement : e ? e.target : null;

		if(!element) return;
		
		eventTab =  document.getElementById("event_tab"); 
		locTab =  document.getElementById("loc_tab"); 
		contactTab =  document.getElementById("contact_tab"); 
		attTab =  document.getElementById("att_tab"); 

		
		
		switch (element.getAttribute('id')) {
			
			case 'event_tab':
				if(eventTab.className != 'tab_select') eventTab.className = 'tab_highlight';
				break;
			
			case 'loc_tab':
				if(locTab.className != 'tab_select') locTab.className = 'tab_highlight';
				break;
			
			case 'contact_tab':
				if(contactTab.className != 'tab_select') contactTab.className = 'tab_highlight';
				break;
				
			case 'att_tab':
				if(attTab.className != 'tab_select') attTab.className = 'tab_highlight';
				break;
		
		}

		clicked = 0;
	
	}



	function returnTab(e) {
		
		var element = window.event ? window.event.srcElement : e ? e.target : null;

		if(!element) return;
		
		eventTab =  document.getElementById("event_tab"); 
		locTab =  document.getElementById("loc_tab"); 
		contactTab =  document.getElementById("contact_tab"); 
		attTab =  document.getElementById("att_tab"); 

		
		if(clicked != 1) {

			switch (element.getAttribute('id')) {
			
				case 'event_tab':
					if(eventTab.className != 'tab_select') eventTab.className = 'tab';
					break;
						
				case 'loc_tab':
					if(locTab.className != 'tab_select') locTab.className = 'tab';
					break;

			
				case 'contact_tab':
					if(contactTab.className != 'tab_select') contactTab.className = 'tab';
					break;

				case 'att_tab':
					if(attTab.className != 'tab_select') attTab.className = 'tab';
					break;
			
			}

		}	
	}


	function initTab() {
		
		eventBody =  document.getElementById("event"); 
		locBody =  document.getElementById("loc"); 
		contactBody =  document.getElementById("contact"); 
		attBody =  document.getElementById("att"); 

		eventBody.style.display = 'inline';
		locBody.style.display = 'none';
		contactBody.style.display = 'none';
		attBody.style.display = 'none';
		

		eventTab =  document.getElementById("event_tab"); 
		locTab =  document.getElementById("loc_tab"); 
		contactTab =  document.getElementById("contact_tab"); 
		attTab =  document.getElementById("att_tab"); 

		eventTab.className = 'tab_select';


		addEvent(eventTab, 'click', changeTab, false);
		addEvent(locTab, 'click', changeTab, false);
		addEvent(contactTab, 'click', changeTab, false);
		addEvent(attTab, 'click', changeTab, false);



		addEvent(eventTab, 'mouseover', highlightTab, false);
		addEvent(locTab, 'mouseover', highlightTab, false);
		addEvent(contactTab, 'mouseover', highlightTab, false);
		addEvent(attTab, 'mouseover', highlightTab, false);



		addEvent(eventTab, 'mouseout', returnTab, false);
		addEvent(locTab, 'mouseout', returnTab, false);
		addEvent(contactTab, 'mouseout', returnTab, false);
		addEvent(attTab, 'mouseout', returnTab, false);

	
	}
