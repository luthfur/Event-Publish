<?php

/*********************************************************
Time Sharp Scheduling Engine

ScheduleData Class - Container for a single schedule data item

Developed by Luthfur Rahman Chowdhury

July 15, 2006
**********************************************************/


class ScheduleData  {

	private $type;				// item recurrence type
	private $start_date;		// item start date and time		
	private $stop_date;			// item stop date and time
	private $timespec;			// item timespec
	private $org_timezone;		// orignal timezone of the item when added
	private $Details;			// item details (type: Event, Meeting, Resource)
	
	

	function __construct($type, $start_date, $stop_date, $timespec, $timezone, $Details) {
		
		$this->type = $type;
		$this->start_date = $start_date;
		$this->stop_date = $stop_date;
		$this->timespec = $timespec;
		$this->Details = $Details;	
		$this->org_timezone = $timezone;
					
	}	
	
		
	/*
	* @return the DateTime object for this day
	*/
	public function getStartDate() {
		return new SC_DateTime(0,0,0,0,0,0,$this->start_date);
	}
	
	
	/*
	* @return the DateTime object for this day
	*/
	public function getStopDate() {
		return new SC_DateTime(0,0,0,0,0,0,$this->stop_date);
	}
	
	
	/*
	* @return the type of item
	*/
	public function getType() {
		return $this->type;
	}
	
	
	/*
	* @return the timezone of this schedule
	*/
	public function getTimeSpec() {
		return $this->timespec;
	}
	
	
	
	/*
	* @return the item details
	*/
	public function getDetails() {
		return $this->Details;
	}
	
		
	
	/*
	* @return the original timezone
	*/
	public function getOriginalTimeZone() {
		return $this->org_timezone;
	}
	

}