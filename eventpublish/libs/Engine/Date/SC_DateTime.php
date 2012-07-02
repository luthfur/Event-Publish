<?php
	
/***********************************************************************
DateTime Class

This module has been developed by Luthfur R. Chowdhury
	
(c)2006 Luthfur R. Chowdhury  All Rights Reserved.
************************************************************************/


class SC_DateTime {
	
	private $timestamp;
	private $day;
	private $month;
	private $year;
	
	private $hour;
	private $minute;
	private $second;



	/********************* Class Constructor ***************************/
	function __construct( $d=0, $m=0, $y=0, $h=0, $min=0, $sec=0, $timestamp=0 ) {

		
		if((!$d || !$m || !$y) && !$timestamp) {
			
			$this->setTimeStamp(time());
			
				
		} elseif($timestamp)  {
			$this->setTimeStamp($timestamp);
			
		} else {
			
			$this->setTimeStamp(mktime($h,$min,$sec,$m,$d,$y));
					
		}
						
		
		 
	}
	
	
		

	public function getDayOfWeek() {
		
		$date_tokens = getdate($this->getTimeStamp());
		return $date_tokens["wday"];
		
	 }

	public function getTimeStamp() { return $this->timestamp; }


	public function getDay() { return $this->day; }
	public function getMonth() { return $this->month; }
	public function getYear() { return $this->year; }
	
	public function getHour() { return $this->hour; }
	public function getMinute() { return $this->minute; }
	public function getSecond() { return $this->second; }


	public function isWeekDay() {
		
		$day_of_week = $this->getDayOfWeek();

		if($day_of_week != 0 && $day_of_week != 6) return 1;

		return 0;
	
	}




	public function isWeekEnd() {

		$day_of_week = $this->getDayOfWeek();
		
		if($day_of_week == 0 || $day_of_week == 6) return 1;

		return 0;

	}


	

	public function addDay($num) {

		if($num < 0) return;
		
		$timestamp = $this->timestamp + (86400 * $num);
		$this->setTimeStamp($timestamp);

	}




	public function addWeek($num) {
		
		if($num < 0) return;
		
		$timestamp = $this->timestamp;
		
		for($i=1; $i<=$num; $i++) {
			$timestamp = $timestamp + (86400 * 7);
		}
		
		$this->setTimeStamp($timestamp);

	}





	public function addHour($num) {
			
		if($num < 0) return;
		
		$timestamp = $this->timestamp + (3600 * $num);
		$this->setTimeStamp($timestamp);

	}




	public function addMinute($num) {
		
		if($num < 0) return;
		
		$timestamp = $this->timestamp + (60 * $num);
		$this->setTimeStamp($timestamp);

	}




	public function addSecond($num){

		if($num < 0) return;
		
		$timestamp = $this->timestamp + (1 * $num);
		$this->setTimeStamp($timestamp);

	}
	


	public function removeHour($num) {
			
		if($num < 0) return;
		
		$timestamp = $this->timestamp - (3600 * $num);
		$this->setTimeStamp($timestamp);

	}

	




	public function removeMinute($num) {
		
		if($num < 0) return;
		
		$timestamp = $this->timestamp - (60 * $num);
		$this->setTimeStamp($timestamp);

	}




	public function removeSecond($num){

		if($num < 0) return;
		
		$timestamp = $this->timestamp - (1 * $num);
		$this->setTimeStamp($timestamp);

	}


	
	public function removeDay($num) {
	
		if($num < 0) return;
		
		$timestamp = $this->timestamp - (86400 * $num);
		$this->setTimeStamp($timestamp);
	
	}


	

	public function removeWeek($num) {
		
		if($num < 0) return;
		
		$timestamp = $this->timestamp;
		
		for($i=1; $i<=$num; $i++) {
			$timestamp = $timestamp - (86400 * 7);
		}
		
		$this->setTimeStamp($timestamp);
	}




	public function getWeekNum() {
		
		$weeknum = 1;
		
		$month = date("m", mktime(0,0,0,$this->month, $this->day, $this->year));
		
		if ($month == date("m", mktime(0,0,0,$this->month, ($this->day - 7), $this->year)) ) {
			$weeknum = 2;
		}
		if ( $month == date("m", mktime(0,0,0,$this->month, ($this->day - 14), $this->year)) ) {
			$weeknum = 3;
		}
		if ( $month == date("m", mktime(0,0,0,$this->month, ($this->day - 21), $this->year)) ) {
			$weeknum = 4;
		}
		if ( $month == date("m", mktime(0,0,0,$this->month, ($this->day - 28), $this->year)) ) {
			$weeknum = 5;
		}
		
		return $weeknum;
		
	}

	
	public function setTimeStamp($timestamp) {
		
		$this->timestamp = $timestamp;
		$date_tokens = getdate($timestamp);
			
		$this->day = $date_tokens["mday"];
		$this->month = $date_tokens["mon"];
		$this->year = $date_tokens["year"];
		$this->hour = $date_tokens["hours"];
		$this->minute = $date_tokens["minutes"];
		$this->second = $date_tokens["seconds"];
	}




	public function format($format) {
		
		return date($format, $this->getTimeStamp());
	
	}

	
	


	public function compareDate($Date) {
		
		$ExtDate = new SC_DateTime($Date->getDay(), $Date->getMonth(), $Date->getYear(), $this->hour, $this->minute, $this->second);

		if($this->getTimeStamp() < $ExtDate->getTimeStamp()) return -1;

		if($this->getTimeStamp() > $ExtDate->getTimeStamp()) return 1;

		return 0;

	}






	public function compareTime($Date) {

		$ExtDate = new SC_DateTime($this->day, $this->month, $this->year, $Date->getHour(), $Date->getMinute(), $Date->getSecond());

		if($this->getTimeStamp() < $ExtDate->getTimeStamp()) return -1;

		if($this->getTimeStamp() > $ExtDate->getTimeStamp()) return 1;

		return 0;

	}
	





	public function compare($ExtDate) {
			
		if($this->getTimeStamp() < $ExtDate->getTimeStamp()) return -1;

		if($this->getTimeStamp() > $ExtDate->getTimeStamp()) return 1;

		return 0;

	}
			
			
			
			
			
	public function addMonth($num) {
		

		for($i=1; $i<=$num; $i++) {

			// Check if day needs to re assigned
			$end_of_month = date("j", mktime(0,0,0,$this->month + 1, 0, $this->year));
			
			$this->month++;
			
			if($this->month > 12) {
				$this->month = 1;
				$this->year++;
			}
			

			if($this->day == $end_of_month) $this->day = date("j", mktime(0,0,0,$this->month + 1, 0, $this->year));

		}
		
		$this->setTimeStamp(mktime($this->hour,$this->minute,$this->second,$this->month, $this->day, $this->year));
			

	}





	public function addYear($num) {
		
		for($i=1; $i<=$num; $i++) { $this->year++; }
		$this->setTimeStamp(mktime($this->hour,$this->minute,$this->second,$this->month, $this->day, $this->year));

	}
	
	
	
	public function removeMonth($num) {
		
		for($i=1; $i<=$num; $i++) {

			// Check if day needs to re assigned
			$end_of_month = date("j", mktime(0,0,0,$this->month + 1, 0, $this->year));

			$this->month--;

			if($this->month == 0) {
				$this->month = 12;
				$this->year--;
			}

			if($this->day == $end_of_month) $this->day = date("j", mktime(0,0,0,$this->month + 1, 0, $this->year));
			
		}
		
		$this->setTimeStamp(mktime($this->hour,$this->minute,$this->second,$this->month, $this->day, $this->year));
		
	}



	public function removeYear($num) {
		
		for($i=1; $i<=$num; $i++) { $this->year--; }
		$this->setTimeStamp(mktime($this->hour,$this->minute,$this->second,$this->month, $this->day, $this->year));

	}




	
}