/*
###############################################################

eventdrop.js

interface functionality for the drop-down option box.

Used in the event list views. 

(NOTE: Feature has been disabled for v1.0)

###############################################################
*/	

	function ToggleItemMenu(i){
		
		var div = document.getElementById('div'+i);
		
		if(!div) return;
		
        var menu = div.style;
        var uls = div.getElementsByTagName('ul');
		
		var optLink = div.parentNode.childNodes[0];
		
		content = uls[0];
		
        if(menu.display=="none"){
                
			menu.display = 'block';
						
        } else {
			
			menu.display='none';
							
        }
		
		content.onmouseout = function (evt) {
				if (checkMouseLeave(this, evt)) {
					div.style.display = 'none';
				}
			}
			
			
		optLink.onmouseout = function (evt) {
				if (checkMouseLeave(content, evt)) {
					div.style.display = 'none';
				}
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
