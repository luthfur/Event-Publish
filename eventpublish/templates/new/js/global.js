
/*
###############################################################

global.js

Contains functions that are used globally in the system

###############################################################
*/





/**** Cross Browser Event Handling ********************************/

	function addEvent(elm, evType, fn, useCapture) {
	
			if(elm.addEventListener) {
				
				elm.addEventListener(evType, fn, useCapture);
				return true
			
			} else if (elm.attachEvent) {
				
				var r = elm.attachEvent('on' + evType, fn);
				EventCache.add(elm, evType, fn)
				return r;

			} else {

				elm['on' + evType] = fn;
			
			}

	
	}
	/*****************************************************************/

	
	
	/***************************** View All events ************************************/
	
	function goAll() {
	
		var viewSelector = document.getElementById("view_selector");
		var calView = document.getElementById("calview");
		
		var input = viewSelector.getElementsByTagName("input");
		
		var day =  input[0].value;
		var month =  input[1].value;
		var year =  input[2].value; 
		var pv =  input[3].value; 
		
				
		var url = calView.options[calView.selectedIndex].value;
		
		window.location = url + "?d=" + day + "&m=" + month + "&y=" + year + "&pv=" + pv;
		
	}
	
	/**********************************************************************************/
	
	
	
	
	/*************************** String Trim function *********************************/
	
	String.prototype.trim = function(){  return this.replace(/^\s*|\s*$/g, "") }
	
	/**********************************************************************************/
	
	
	
	// ############ HELPER - XML Element Parser ################//
	function getXMLElementContent(element, tagName) {
		
		var childElement = element.getElementsByTagName(tagName)[0];
		return (childElement.text != undefined) ? childElement.text: childElement.textContent;
		
	}
// #########################################################//



	function isNumeric(val) {
	
		var num = '0123456789';
		
		for (i=0; i<val.length; i++) {
			if (num.indexOf(val.charAt(i),0) == -1) return false;
		}
		
		return true;

	}
	
	
	function validateMonthYear(month, year) {
				
		if(!isNumeric(month) || !isNumeric(year)) return false;
		
		if(year.length != 4) return false;
		
		if(Number(year) < 1970) return false;
		
		if(Number(month) > 13 || Number(month) < 0) return false;
						
		return true;
		
	}
	