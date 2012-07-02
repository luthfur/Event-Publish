  function refreshLocList(page) {
		
		var locList = document.getElementById("filter_form");	
		
		var pageInput = document.getElementById("page");	
		pageInput.value = page;
							
		var listOrderBy = document.getElementById("list_order_by"); 
		var listOrder = document.getElementById("list_order");
		
		var OrderBy = document.getElementById("order_by"); 
		var Order = document.getElementById("order");
				
		OrderBy.value = listOrderBy.options[listOrderBy.selectedIndex].value;
		Order.value = listOrder.options[listOrder.selectedIndex].value;
		
		locList.submit();
	}
	
	
	function resetLocFilter() {
			
		var filterDiv = document.getElementById("filters"); 
		var ps = filterDiv.getElementsByTagName("p");
			
		var input = ps[0].getElementsByTagName("input");	
		input[0].value = "";
		
		input[1].checked = 0;
		input[2].checked = 0;
		input[3].checked = 0;
		input[4].checked = 0;
		input[5].checked = 0;

	}
	
			
	
	
	function deleteLocation() {
		
		var locationList = document.getElementById('location_list');
		
		var checkboxes = locationList.getElementsByTagName('input');
		
		var ids = "";
		
		for(var i=0; i<checkboxes.length; i++) {
			if(checkboxes[i].checked) {
				if(ids != "") ids += ",";
				ids += checkboxes[i].value;		
			}
		}
		
		if(ids != "") window.location = 'process/delete_location.php?ids=' + ids;
		
	}
	