<?php

/*********************************************************
Time Sharp Event Publish

Event Schedule Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class EventSchedule  {
	
	private $EventScheduleQuery;
		
	function __construct($ESQuery) {
		
		$this->EventScheduleQuery = $ESQuery;
		
	}		
	
	
	public function getWeek($day, $month, $year, $start_day) {
				
		$Week = new Week($day, $month, $year, $start_day);
		
		$WeekOf = $Week->getWeekOf();
		
		return $this->getScheduleData($this->EventScheduleQuery->getWeek($WeekOf->getDay(), $WeekOf->getMonth(), $WeekOf->getYear()));
		
		
	}
	
	
	public function getDay($day, $month, $year) {
		return $this->getScheduleData($this->EventScheduleQuery->getDay($day, $month, $year));
	}
	
	
	public function getMonth($month, $year) {
	
		$Month = new Month($month, $year);
		return $this->getScheduleData($this->EventScheduleQuery->getMonth($Month->getDaysInMonth(), $month, $year));
				
	}
	
	
	public function getYear($year) {
	
		return $this->getScheduleData($this->EventScheduleQuery->getYear($year));
		
	}
	
	private function getScheduleData($ResultSet) {
		
		$ScheduleData = array();
		
		while($row = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
						
			$Event = new Event($row);
	
			$ScheduleData[] = new ScheduleData($row["schedule_type"], $row["start_date"], $row["stop_date"], $row["timespec"], $row["org_timezone"], $Event);
		}
		
				
		return $ScheduleData;	
		
	
	}
	
					
}