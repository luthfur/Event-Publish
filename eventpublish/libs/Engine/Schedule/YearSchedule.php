<?php

/*********************************************************
Time Sharp Scheduling Engine

YearSchedule Class - Container for all scheduleitem belonging 
to a given year.

Developed by Luthfur Rahman Chowdhury

July 13, 2006
**********************************************************/


class YearSchedule  {

	private $year;				// integer: year 
	private $Schedules;			// MonthSchedule array		
	private $pointer;
	private $timezone;
	private $weekend;

	function __construct($y, $timezone, $weekend, $DataSet) {
		
			$this->year = $y;
			$this->timezone = $timezone;
			$this->weekend = $weekend;
			$this->reset();
			
			$this->insert($DataSet);
		
	}	
	
	
		
	
	/*
	* Inserts all schedule data in the MonthSchedule container.
	* 
	* Arranges Items in chronological order
	* 
	* @param DataSet containing schedule data
	*/
	private function insert($DataSet) {
	
		$this->Schedules = array();
		
		for($i=0; $i<12; $i++) {
		
			$this->Schedules[$i] = new MonthSchedule($i + 1, $this->year, $this->timezone, $this->weekend, $DataSet);
		
		}
		
	}
		

	
	
	/*
	* Move Pointer to the next month
	* 
	*/
	public function nextMonth() {
		if($this->pointer < 12) $this->pointer++;
	}
	
	
	/*
	* @return true if its the last month of the year
	* or false otherwise
	*/
	public function isLastMonth() {
		
		if($this->pointer < 12) return 0;
		
		return 1;
	}
	
	
	
	/*
	* @return Schedule for the current pointed month
	*/
	public function getMonthSchedule() {
		return $this->Schedules[$this->pointer];
	}
	
	
	/*
	*
	* @param month
	* @param year 
	* @return the schedule item container array
	*/
	public function getItemsByDate($d, $m) {
	
		if($d <= $this->Month->getDaysInMonth() && $d >= 1) return $this->Schedules[$m - 1]->getItemsByDate($d);
		
		return null;
	}
	
		
	
	
	/*
	* Reset pointer to the first Month
	* 
	*/
	public function reset() {
		$this->pointer = 0;
	}
	
	
	/*
	* @return the Month object
	*/
	public function getMonth() {
		return new Month($this->pointer + 1, $this->year);
	}
	
	
	/*
	* @return the schedule year
	*/
	public function getYear() {
		return $this->year;
	}
	
	
	/*
	* @return the timezone of this schedule
	*/
	public function getTimeZone() {
		return $this->timezone;
	}

}