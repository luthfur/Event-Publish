<?php

/*********************************************************
Time Sharp Scheduling Engine

ScheduleItem Class - Container for a single schedule tem

Developed by Luthfur Rahman Chowdhury

July 15, 2006
**********************************************************/


class ScheduleItem {

	private $start_time;
	private $stop_time;				
	private $timespec;
	private $Details;
	
	

	function __construct($start_time, $stop_time, $timespec, $Details) {
		
		$this->start_time = $start_time;
		$this->stop_time = $stop_time;
		$this->timespec = $timespec;
		$this->Details = $Details;	
			
	}	
	
		
	/*
	* @return start time timestamp
	*/
	public function getStartTime() {
		return new SC_DateTime(0,0,0,0,0,0,$this->start_time);
	}
	
	
	/*
	* @return stop time timestamp
	*/
	public function getStopTime() {
		return new SC_DateTime(0,0,0,0,0,0,$this->stop_time);
	}
	
	
	/*
	* @return details of this item
	*/
	public function getDetails() {
		return $this->Details;
	}
	
	
	/*
	* @return details of this item
	*/
	public function getTimeSpec() {
		return $this->timespec;
	}
	
		

}