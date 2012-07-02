<?php

/*********************************************************
Time Sharp Scheduling Engine

ScheduleData Class - Container for a single schedule data item

Developed by Luthfur Rahman Chowdhury

July 15, 2006
**********************************************************/


class EventScheduleData {
	
	private $id;
	private $type;				// item recurrence type
	private $start_date;		// item start date and time		
	private $stop_date;			// item stop date and time
	private $timespec;			// item timespec
	private $org_timezone;		// orignal timezone of the item when added

	
	function __construct($data, $shift_time = 0, $timezone = 0) {
		
		$this->id = $data['schedule_id'];
		$this->type = $data['schedule_type'];
		$this->timespec = $data['timespec'];
		$this->org_timezone = $data['org_timezone'];
		
		if(!$shift_time || $data['timespec'] == 0) {
		
			$this->start_date = $data['start_date'];
			$this->stop_date = $data['stop_date'];
		
		} else {
			
			$DataStartDate = new SC_DateTime(0,0,0,0,0,0,$data['start_date']);
			$DataStopDate = new SC_DateTime(0,0,0,0,0,0,$data['stop_date']);
			
			
			if($timezone != 0) {
				
				$DataStartDate = Utilities::shiftTime($DataStartDate, 0, $timezone);
				$DataStopDate = Utilities::shiftTime($DataStopDate, 0, $timezone);
				
			}
			
			$this->start_date = $DataStartDate->getTimeStamp();
			$this->stop_date = $DataStopDate->getTimeStamp();
		}
		
						
	}	
	
	
	public function getId() {
		return $this->id;
	}
	
	
		
	public function getRecurrenceString() {
		
		if(is_null($this->getStartDate()) || is_null($this->getStopDate())) return;
		
		$string = "";
		
		switch($this->getType()) {
			
			case 1:
				$string .= "On ";
				break;
								
			case 2:
				$string .= "Daily";
				break;
				
				
			case 3:
				$string .= "Every Tue, Thu";
				break;
				
				
			case 4:
				$string .= "Every Mon, Wed, Fri";
				break;
				
				
			case 5:
				$string .= "Every Weekday";
				break;
				
				
			case 6:
				$string .= "Every Weekend";
				break;
				
				
			case 7:
				$string .= "Every " . $this->getStartDate()->format("l");
				break;
				
				
			case 8:
				$string .= "Every Other " . $this->getStartDate()->format("l");
				break;
				
			case 9:
				$string .= $this->getStartDate()->format("jS ") . "of Every Month";
				break;
				
			case 10:
				$string .= $this->getStartDate()->format("jS ") . "of " . $this->getStartDate()->format("M") . ", Every Year";
				break;
				
				
			case 11:
				$string .= $this->getStartDate()->getWeekNum() . $this->getOrdinal($this->getStartDate()->getWeekNum()) . " " . $this->getStartDate()->format("l") . " of Every Month";
				break;
				
				
			case 12:
				$string .= $this->getStartDate()->getWeekNum() . $this->getOrdinal($this->getStartDate()->getWeekNum()) . " " . $this->getStartDate()->format("l") . " of " . $this->getStartDate()->format("M") . ", Every Year";
				break;
				
		}
				
		return $string;
		
	}	
	
	
	
	public function getRangeString() {
	
		if(DATE_FORMAT == 0) {
			$format = "M d, Y";
		} else if (DATE_FORMAT == 1) {
			$format = "d M, Y";
		} else if (DATE_FORMAT == 2) {
			$format = "Y-m-d";
		} else {
			$format = "M d, Y";
		}
				
		$string = $this->getStartDate()->format($format);
		
		if($this->type > 1) {
			$string .= " to ";
			$string .=  $this->getStopDate()->format($format);
		}
		
		return $string;
	
	}
	
	
	
	
	private function getOrdinal($num) {
		
		$val = floor($num / 10);
		$val = $num - val;
		
		if($val == 1) return "st";
		if($val == 2) return "nd";
		if($val == 3) return "rd";
		
		return "th";
		
	}
	
	
	
	
	
	
	/*
	* @return the DateTime object for this day
	*/
	public function getStartDate() {
		if(!$this->start_date) return NULL;		
		return new SC_DateTime(0,0,0,0,0,0,$this->start_date);
	}
	
	
	/*
	* @return the DateTime object for this day
	*/
	public function getStopDate() {
		if(!$this->stop_date) return NULL;	
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
	* @return the original timezone
	*/
	public function getOriginalTimeZone() {
		return $this->org_timezone;
	}
	
	
	

}