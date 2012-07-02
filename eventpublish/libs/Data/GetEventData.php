<?php

/*********************************************************
Time Sharp Event Publish

Get Event Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/


class GetEventData extends DataAccess  {
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
	}	
			
	
	public function getSingle($event_id) {
		
		$ev = EVENT_TABLE;
		
		$query = $this->setQuery();
		$query .= " WHERE $ev.event_id = $event_id";
							
		return $this->executeQuery($query);
		
		
	}
	
	
	
	public function getList($Filters, $mode=0, $order_by = null, $order = null, $limit = null) {
		
		$acc = USER_TABLE;
		$cal = CALENDAR_TABLE;
		$cat = CATEGORY_TABLE;
		$ev = EVENT_TABLE;
		$con = CONTACT_TABLE;
		$loc = LOCATION_TABLE;
		$sch = SCHEDULE_TABLE;
		$ev_tag = EVTAG_TABLE;
		
		$query = $this->setQuery();
		
		$flag = 0;
		
		if($user_id = $Filters->getUserId()) {
			$query .= $this->append($flag);
			$query .= "$acc.user_id = $user_id";
		}
		
		if($location_id = $Filters->getLocationId()) {
			$query .= $this->append($flag);	
			$query .= "$loc.location_id = $location_id";
			
		}
		
		
		if($calendar_id = $Filters->getCalendarId()) {
			$query .= $this->append($flag);
			$query .= "$cal.calendar_id = $calendar_id";
		}
		
		
		if($category_id = $Filters->getCategoryId()) {
			$query .= $this->append($flag);
			$query .= "$cat.cat_id = $category_id";
		}
		if($event_type = $Filters->getEventType()) {
			$query .= $this->append($flag);
			$query .= "$sch.schedule_type = $event_type";
		}

		
		if($Filters->getCancelled() == "on") {
			$query .= $this->append($flag);
			$query .= "$ev.cancelled = 1";
		} else if($Filters->getCancelled() == "off" && !is_null($Filters->getCancelled())) {
			$query .= $this->append($flag);
			$query .= "$ev.cancelled = 0";
		}
		
		if($Filters->getApproved() == 1) {
			$query .= $this->append($flag);
			$query .= " AND $ev.approved = 1";
		} else if($Filters->getApproved() == 0 && !is_null($Filters->getApproved())) {
			$query .= $this->append($flag);
			$query .= "$ev.approved = 0";
		}
		
		
		if($Filters->getPublished() == 1) {
			$query .= $this->append($flag);
			$query .= " $ev.published = 1";
		} else if($Filters->getPublished() == 0 && !is_null($Filters->getPublished()) ){
			$query .= $this->append($flag);
			$query .= "$ev.published = 0";
		}
		
		if($Filters->getDateRange()) {
			$start_date = $Filters->getStartDate();
			$stop_date = $Filters->getStopDate();
			$query .= $this->append($flag);
			$query .= "$sch.start_date <= $stop_date AND $sch.stop_date >= $start_date";
		}
		
		
		if($keywords = $Filters->getKeywords()) {
		
			$keyword_array = explode(" ", $keywords);
			
			while (list($ind, $val) = each($keyword_array)) {
				
				$query .= $this->append($flag);
				$query .= "("; 
				
				if($Filters->searchTitle()) $query .= "$ev.event_title LIKE '%$val%'";
				
				if($Filters->searchDesc()) {
					if($Filters->searchTitle()) $query .= " OR";
					 $query .= " $ev.event_desc LIKE '%$val%'";
				}
				
				if($Filters->searchTags()) {
					if($Filters->searchDesc() || $Filters->searchTitle()) $query .= " OR";
					 $query .= " $ev_tag.tag LIKE '%$val%'";
				}
				
				$query .= ")"; 
			}
		
		}
		
		
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
				
		if($limit != null) $query .= " LIMIT " . $limit;	
		
		
					
		
		$ResultSet = $this->executeQuery($query);
		
		
		if($mode == 1) {
			
			return $ResultSet->numRows();
		
		}  else if($mode == 2) {
			
			
			return $this->getDataSet($ResultSet, $Filters->getTimeZone());
			
		}
		
		return $ResultSet;
		
	}
	
	
	
	
	/*
	* Insert a single row of location data
	* @param $Location object
	* @param user id
	* @return Affected rows
	*
	*/	
	private function setQuery() {
				
		$ev_loc = EVLOCATION_TABLE;
		$ev_con = EVCONTACT_TABLE;
		$ev_usr = EVUSER_TABLE;
		$ev_cal = EVCALENDAR_TABLE;
		$ev_tag = EVTAG_TABLE;
		$ev_sch = EVSCHEDULE_TABLE;
				
		$acc = USER_TABLE;
		$cal =CALENDAR_TABLE;
		$cat = CATEGORY_TABLE;
		$ev = EVENT_TABLE;
		$con = CONTACT_TABLE;
		$loc = LOCATION_TABLE;
		$sch = SCHEDULE_TABLE;
		
		$query .= "SELECT DISTINCT $ev.*, $con.*, $cal.*, $cat.*, $loc.*, $sch.*, $acc.*, $ev_tag.tag AS event_tags";
				
		$query .= " FROM $ev LEFT JOIN $ev_tag ON ($ev.event_id=$ev_tag.event_id) 
			LEFT JOIN $ev_cal ON ($ev.event_id=$ev_cal.event_id) 
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
		
		return $query;	
				
	}
	
	
	
	
	private function append(&$flag) {
		
		if($flag) {
			return " AND ";
		}
		$flag = 1;
		return " WHERE ";
		
	}
	
	
	
	private function getDataSet($ResultSet, $time_zone) {
		
		$collector = array();
		$Events = array();
		$count = 0;
		
		
		while($data = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
			$pointer = array_search($data['event_id'], $collector);
					
			if($pointer !== FALSE) {
							
				if(!$this->scheduleExists($Events[$pointer]->getScheduleInfo(), $data[schedule_id])) {
					$Events[$pointer]->setScheduleInfo(new EventScheduleData($data, 1, $time_zone));
				}
				
				if(!$this->calendarExists($Events[$pointer]->getCalendar(), $data[calendar_id])) {
					$Events[$pointer]->setCalendar(new Calendar($data));
				}
			
				
			} else {
			
				$Events[$count] = new Event($data);
				$Events[$count]->setScheduleInfo(new EventScheduleData($data, 1, $time_zone));
				$collector[$count] = $Events[$count]->getId();
				$count++;
			}
							
		}
				
		return $Events;
		
	}
	
	
	
	
	
	private function scheduleExists($CurrScheduleInfo, $new_id) {
		
		if(is_array($CurrScheduleInfo)) {
			
			while(list($ind, $val) = each($CurrScheduleInfo)) {
			
				if($val->getId() == $new_id) return 1;
			
			}
			
		}
		
		return 0;			
	}
	
	
	
	
	
	private function calendarExists($Calendar, $new_id) {
		
		if(is_array($Calendar)) {
			
			while(list($ind, $val) = each($Calendar)) {
			
				if($val->getId() == $new_id) return 1;
			
			}
			
		} else if($Calendar) {
				
				if($Calendar->getId() == $new_id) return 1;
		}
		
		return 0;			
	}
	
	
						
}