<?php

/*********************************************************
Time Sharp Scheduling Engine

Week Class - Represents a calendar week.

Developed by Luthfur Rahman Chowdhury

July 09, 2006
**********************************************************/


class Week {

	
	private $start_week;
	private $first_day;
	private $month;
	private $year;
	
	
	const SUNDAY = 0;
	const MONDAY = 1;
	const TUESDAY = 2;
	const WEDNESDAY = 3;
	const THURSDAY = 4;
	const FRIDAY = 5;
	const SATURDAY = 6;


	function __construct($d, $m, $y, $s) {
		
		$date = new SC_DateTime($d, $m, $y);
		
		while($date->getDayOfWeek() != $s) {
			$date->removeDay(1);
		}
		
		$this->month = $date->getMonth();
		$this->year = $date->getYear();
		$this->start_week = $s;
		$this->first_day = $date->getDay();


	}

	
	/*
	* @return the start day of the week
	*/
	public function getStartWeek() {
		return $this->start_week;
	}


	/*
	* @return DateTime first day of the week
	*/
	public function getWeekOf() {
		return new SC_DateTime($this->first_day, $this->month, $this->year);
	}

	/*
	* @return DateIterator for the week
	*/
	public function getDateIterator() {

		$startDate = new SC_DateTime($this->first_day, $this->month, $this->year);
		$stopDate = new SC_DateTime($this->first_day, $this->month, $this->year);
		$stopDate->addDay(6);

		return new DateIterator($startDate->getDay(),$startDate->getMonth(),$startDate->getYear(),$stopDate->getDay(),$stopDate->getMonth(),$stopDate->getYear());
	
	}


}