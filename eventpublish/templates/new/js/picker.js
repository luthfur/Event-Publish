	function DatePicker(picker, month, year) {
		
		this.name = picker;
		this.month_end_dates = new Array(29,31,28,31,30,31,30,31,31,30,31,30,31);
		this.month_names = new Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
		this.month;
		this.year;
		
		if(month == 0 || year == 0) {
			
			Today = new Date();
	
			this.month = Today.getMonth();
			this.year = Today.getFullYear();
		
		} else {
			
			this.month = month;
			this.year = year;
			
		}
		
		
		this.month++;
		
		this.month_array = new Array(7);
			
		for(i=0; i<6; i++) {
			
			this.month_array[i] = new Array(7);
	
		}
				
		
		
	}
	
		
	
	DatePicker.prototype.pick=function(cell) {
		
		if(cell.childNodes[0].nodeValue != "&nbsp;") {
									
				startDate = new Date();
				startDate.setDate(cell.childNodes[0].nodeValue);
				startDate.setMonth(this.month);
				startDate.setYear(this.year);
				
				return startDate;
			
		}
		
		return null;
				
	}

	
	/************************* Month Array Generator *********************************/
	
	DatePicker.prototype.getMonthArray=function(cell) {
		
		var date_string = this.month_names[this.month] + " 1," + this.year;

		var FirstDayDate = new Date(date_string);
		
		var first_day = FirstDayDate.getDay();
		
		var leap_year = ((this.year % 4) ==  0) ? 1 : 0; 
		
		var lastday = ((leap_year == 1) && (this.month == 2)) ? this.month_end_dates[0] : this.month_end_dates[this.month];

		var day = 1;

		var the_array = new Array(6);
		the_array[0] = new Array(7);
				
		
		var pointer = 0;

		// begin array insertion
		for (i=0; i<7; i++) {
			if (i == first_day) {
				the_array[0][i] = day;
				pointer = i;
			}
		}


		// increment pointer and date
		pointer++;
		day++;
		
		
		// complete insertion of first row
		for (i=pointer; i<7; i++) {
			the_array[0][i] = day++;
		}
		
		
	
		
		// complete insertion of the rest of the month
		for (i=1; i<6; i++) {
			
			the_array[i] = new Array(7);

			for(j=0; j<=6; j++) {
				if (day <= lastday) {
					the_array[i][j] = day++;
				}
			}			
		}

		

		return the_array;

		
	
	}
	/******************************************************************************************/
	
	
	
	DatePicker.prototype.setMonth=function(month) {
		
		this.month = month;
				
	}
	
	
	DatePicker.prototype.setMonth=function(year) {
		
		this.year = year;
				
	}
	

	/**************************** Calendar Navigators *****************************************/
		
	DatePicker.prototype.nextMonth=function() {
		
		this.month++;

		if(this.month > 12) {
			
			this.month = 1;
			this.nextYear();
			return;
		
		}

		this.setCalDisplay(0,0);

	}



	DatePicker.prototype.prevMonth=function() {
		
		this.month--;

		if(this.month == 0) {
			
			this.month = 12;
			this.prevYear();
			return;
		
		}

		this.setCalDisplay(0,0);

	}


	DatePicker.prototype.nextYear=function() {
		
		this.year++;

		this.setCalDisplay(0,0);

	}


	DatePicker.prototype.prevYear=function() {
		
		this.year--;

		this.setCalDisplay(0,0);

	}

	/****************************************************************************************/

	
		
	
	/********************************** Set Calendar Display ************************************************/
	
	DatePicker.prototype.setCalDisplay=function(day, month, year) {
		
		if(month != 0 && year != 0) {
			this.month = month;
			this.year = year;
		}
		var calLabel = document.getElementById(this.name + '_cal_display');
		calLabel.childNodes[0].nodeValue = this.month_names[this.month] + ' ' + this.year;
		calLabel.style.fontWeight = 'bold';
		
		
		
		var picker = document.getElementById(this.name);
		
		var tables = picker.getElementsByTagName("table");
		
		var calTable = tables[0];
		
		var month_array = this.getMonthArray();
	
		
		for(i=0;i<6;i++) {
			
			var tableRow = calTable.rows[i + 2];
		
			for(j=0;j<=6;j++) {
				
				if(month_array[i][j] != null)  {
					tableRow.cells[j].childNodes[0].nodeValue = month_array[i][j];
					
					if(day == month_array[i][j]) {
						tableRow.cells[j].className = "today_cell";
												
					} else {
						tableRow.cells[j].className = "minical_cell";
					}	
					
				} else {
					tableRow.cells[j].childNodes[0].nodeValue = ' ';
				}
			}
	
		}
	
	}


	/*******************************************************************************************************/
	
	