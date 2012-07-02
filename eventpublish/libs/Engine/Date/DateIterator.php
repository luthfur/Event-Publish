<?php

/*********************************************************
Time Sharp Scheduling Engine

Date Iterator Class - Provides the ability to iterate
through dates from a start date to end date.

Developed by Luthfur Rahman Chowdhury

July 10, 2006
**********************************************************/


class DateIterator {

	
	private $StartDate;
	private $StopDate;
	private $CurDate;


	function __construct($start_day, $start_month, $start_year, $stop_day, $stop_month, $stop_year) {
		
		$this->StartDate = new SC_DateTime($start_day, $start_month, $start_year);
		$this->StopDate = new SC_DateTime($stop_day, $stop_month, $stop_year);
		$this->CurDate = new SC_DateTime($start_day, $start_month, $start_year);
		
		$this->CurDate->removeDay(1);
		$this->StartDate->removeDay(1);
		$this->StopDate->addDay(1);
	}

		
	
	/*
	*
	* Moves pointer to the next day
	*
	* @return true if next day is within stop date, false otherwise
	*/
	public function nextDay() {
		
		$this->CurDate->addDay(1);
				
		if($this->CurDate->compareDate($this->StopDate) < 0) {
			
			return new SC_DateTime($this->CurDate->getDay(), $this->CurDate->getMonth(), $this->CurDate->getYear());
		}
		
		$this->reset();
		
		return false;
	}
	

	
	/*
	*
	* Reset the pointer to the start date
	*
	*/
	public function reset() {
		$this->CurDate->setTimeStamp($this->StartDate->getTimeStamp());
		
	}



}