<?php

/*********************************************************
Time Sharp Event Publish

Event Schedule Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class EventScheduleQuery  {
	
	private $mdb2;
	private $category_id;
	private $location_id;
	private $calendar_id;
	private $user_id;
	private $timezone;

	function __construct($db, $time_zone, $cat_id = null, $cal_id = null, $user_id = null) {
				
		// establish database object
		$this->mdb2 = $db;
		$this->category_id = $cat_id;
		$this->calendar_id = $cal_id;
		$this->user_id = $user_id;
		$this->timezone = $time_zone;
				
	}		
	
	public function setLocation($lid) {
		$this->location_id = $lid;			
	}
	
	
	public function getWeek($day, $month, $year) {
		
		$StartDate = new SC_DateTime($day, $month, $year);
		$StopDate = new SC_DateTime($day, $month, $year, 23, 59);
		$StopDate->addDay(6);
				
		return $this->adjustTimeZone($StartDate, $StopDate);
	}
	
	
	public function getDay($day, $month, $year) {
		
		$StartDate = new SC_DateTime($day, $month, $year);
		$StopDate = new SC_DateTime($day, $month, $year, 23, 59);
		
		
		return $this->adjustTimeZone($StartDate, $StopDate);
		
	}
	
	
	public function getMonth($daysInMonth, $month, $year) {
		
		$StartDate = new SC_DateTime(1, $month, $year);
		$StopDate = new SC_DateTime($daysInMonth, $month, $year, 23, 59);
		
		return $this->adjustTimeZone($StartDate, $StopDate);
		
	}
	
	
	public function getYear($year) {
		
		$StartDate = new SC_DateTime(1, 1, $year);
		$StopDate = new SC_DateTime(31, 12, $year, 23, 59);
		
		return $this->adjustTimeZone($StartDate, $StopDate);
		
	}
	
	
	
	private function adjustTimeZone($StartDate, $StopDate) {
	
		$ShiftedStartDate = Utilities::shiftTime($StartDate, $this->timezone, 0);
		$ShiftedStopDate = Utilities::shiftTime($StopDate, $this->timezone, 0);
				
		return $this->executeQuery($ShiftedStartDate->getTimeStamp(), $ShiftedStopDate->getTimeStamp());
	
	}
	
	
	
	private function executeQuery($start_date, $stop_date) {
		
		$acc = USER_TABLE;
		$cal =CALENDAR_TABLE;
		$cat = CATEGORY_TABLE;
		$ev = EVENT_TABLE;
		
		$ev_cal = EVCALENDAR_TABLE;
		$ev_con = EVCONTACT_TABLE;
		$con = CONTACT_TABLE;
		$ev_loc = EVLOCATION_TABLE;
		$loc = LOCATION_TABLE;
		
		$ev_sch = EVSCHEDULE_TABLE;
		$ev_usr = EVUSER_TABLE;
		$sch = SCHEDULE_TABLE;

		
		
		$query = "SELECT $ev.*, $con.*, $cal.*, $cat.*, $loc.*, $sch.*, $acc.*";
				
		$query .= " FROM $ev LEFT JOIN $ev_cal ON ($ev.event_id=$ev_cal.event_id) 
			LEFT JOIN $cal ON ($ev_cal.calendar_id=$cal.calendar_id)
			LEFT JOIN $ev_con ON ($ev_con.event_id=$ev.event_id)
			LEFT JOIN $con ON ($ev_con.contact_id=$con.contact_id)
			LEFT JOIN $ev_loc ON ($ev_loc.event_id=$ev.event_id)
			LEFT JOIN $loc ON ($ev_loc.location_id=$loc.location_id)
			LEFT JOIN $ev_sch ON ($ev_sch.event_id=$ev.event_id)
			LEFT JOIN $sch ON ($ev_sch.schedule_id=$sch.schedule_id)
			LEFT JOIN $ev_usr ON ($ev_usr.event_id=$ev.event_id)
			LEFT JOIN $acc ON ($acc.user_id=$ev_usr.user_id)
			LEFT JOIN $cat ON ($cat.cat_id = $cal.category_id)";
			
		$query .= "	WHERE $sch.start_date <= $stop_date AND $sch.stop_date >= $start_date AND $ev.published = 1";	
			
		
		if($this->category_id) $query .= " AND $cat.cat_id = " . $this->category_id;
		if($this->calendar_id) $query .= " AND $cal.calendar_id = " . $this->calendar_id;
		if($this->location_id) $query .= " AND $loc.location_id = " . $this->location_id;
		if($this->user_id) $query .= " AND $acc.user_id = " . $this->user_id;
				
		$this->mdb2->connect();
				
		$ResultSet = $this->mdb2->query($query);
		
		if (PEAR::isError($mdb2)) {
			die($this->mdb2->getMessage());
		}
		
		$this->mdb2->disconnect();
				
		return $ResultSet;
		
	}
	
					
}