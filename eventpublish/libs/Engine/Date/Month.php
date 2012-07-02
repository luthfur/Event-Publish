<?php

/*********************************************************
Time Sharp Scheduling Engine

Month Class - Represents a month in the year.

Developed by Luthfur Rahman Chowdhury

July 09, 2006
**********************************************************/


class Month {

	
	private $month;
	private $year;
	
	const SUNDAY = 0;
	const MONDAY = 1;
	const TUESDAY = 2;
	const WEDNESDAY = 3;
	const THURSDAY = 4;
	const FRIDAY = 5;
	const SATURDAY = 6;



	function __construct($m, $y) {
		
		$this->month = $m;
		$this->year = $y;
	
	}

	
	
	/*
	*
	* @param start of the week
	* @return two dimensional array representing days in month
	*/
	public function toArray($start_week) {
		
		$first_day = date("w", mktime(0,0,0,$this->month,1,$this->year));
						
		$last_day = $this->getDaysInMonth();
		
		$day = 1;


		$pointer = $first_day - $start_week;
		if($pointer < 0) $pointer = 7 + $pointer;
		
		// begin insertion of first row
		for ($i=0; $i<=$pointer; $i++) {
			$the_array[0][$i] =(($i != $pointer) ? "" : $day);
		}
		
		// increment pointer and date
		$pointer++;
		$day++;
		
		
		// complete insertion of first row
		for ($i=$pointer; $i<7; $i++) {
			$the_array[0][$i] = $day++;
		}
	
	
		
		// complete insertion of the rest of the month
		for ($i=1; $i<6; $i++) {
			for($j=0; $j<=6; $j++) {
				if ($day <= $last_day) {
					$the_array[$i][$j] = $day++;
				}
			}			
		}
		
		
		return $the_array;

	}



	/*
	* @return DateIterator for this Month
	*/
	public function getDateIterator() {
		
		$startDate = new SC_DateTime(1, $this->month, $this->year);
		$stopDate = new SC_DateTime($this->getDaysInMonth(),$this->month, $this->year);

		return new DateIterator($startDate->getDay(),$startDate->getMonth(),$startDate->getYear(),$stopDate->getDay(),$stopDate->getMonth(),$stopDate->getYear());

	}


	/*
	* @return month of year
	*/
	public function getMonthOfYear() {
		return $this->month;
	}

	/*
	* @return year
	*/
	public function getYear() {
		return $this->year;
	
	}

	
	
	/*
	* @return the days in month
	*/
	public function getDaysInMonth() {
		return date("j", mktime(0,0,0,$this->month + 1,0,$this->year));
	
	}


}
?>