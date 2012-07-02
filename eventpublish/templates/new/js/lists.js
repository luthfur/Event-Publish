  function selectAllRows(elm) {
		
		var DataList = document.getElementById(elm);

		var checkboxes = DataList.getElementsByTagName('input');
			
		
		for(var i=0; i<checkboxes.length; i++) {
			
			if(checkboxes[i].checked == false) checkboxes[i].checked = true;
		}		
		
		var selectLink = document.getElementById('select_all_row_link');
		var deselectLink = document.getElementById('deselect_all_row_link');
		
		
		
		selectLink.style.display = "none";
		deselectLink.style.display = "inline";
	}
	
	
	
	function deselectAllRows(elm) {
		
		var DataList = document.getElementById(elm);
		
		var checkboxes = DataList.getElementsByTagName('input');
				
		for(var i=0; i<checkboxes.length; i++) {
			if(checkboxes[i].checked == true) checkboxes[i].checked = false;
		}	
		
		var selectLink = document.getElementById('select_all_row_link');
		var deselectLink = document.getElementById('deselect_all_row_link');
		
		selectLink.style.display = "inline";
		deselectLink.style.display = "none";
		
	}
	