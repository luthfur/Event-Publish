<?php

/*********************************************************
Time Sharp Event Publish

Event Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class EventData extends DataAccess  {
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
	}	
		
	
	/*
	* Insert a single row of location data
	* @param $Location object
	* @param user id
	* @return Affected rows
	*
	*/	
	public function add($Event, $calendar_id, $user_id, $location_id=0, $contact_id=0, $schedule_id) {
		
		$ev = EVENT_TABLE;
		$ev_loc = EVLOCATION_TABLE;
		$ev_con = EVCONTACT_TABLE;
		$ev_user = EVUSER_TABLE;
		$ev_cal = EVCALENDAR_TABLE;
		$ev_tag = EVTAG_TABLE;
		$ev_sch = EVSCHEDULE_TABLE;
		
		$event_id = $this->getCurrentId() + 1;
			
		
		$event_title = $Event->getTitle();
		$text_time = $Event->getTextTime();
		$event_desc = $Event->getDesc();
		$capacity = ($Event->getCapacity()) ? $Event->getCapacity(): 0;
		$approved = $Event->isApproved();
		$published = $Event->isPublished();
		$cancelled = $Event->isCancelled();
		$allow_register = $Event->allowRegistration();
		$tags = $Event->getTags();
				
				
		$query = "INSERT INTO $ev VALUES ($event_id, '$event_title', '$text_time', '$event_desc', $capacity, $approved, $published, $cancelled, $allow_register)";
				
		$this->execute($query);
		
		
		while(list($ind, $val) = each($calendar_id)) {
		
			$query = "INSERT INTO $ev_cal VALUES ($event_id, $val)";
					
			$this->execute($query);
		
		}	
		
		if($location_id) {
		
			$query = "INSERT INTO $ev_loc VALUES ($event_id, $location_id)";
					
			$this->execute($query);
			
		}
		
	
		if($contact_id) {
		
			$query = "INSERT INTO $ev_con VALUES ($event_id, $contact_id)";
					
			$this->execute($query);
		
		}
		
		$query = "INSERT INTO $ev_user VALUES ($event_id, $user_id)";
				
		$this->execute($query);
		
		
		while(list($ind, $val) = each($schedule_id)) {
		
			$query = "INSERT INTO $ev_sch VALUES ($event_id, $val)";
					
			$this->execute($query);
		
		}
		
		
		if($tags) {
			
			$tags = implode(",", $tags);
			
			$query = "INSERT INTO $ev_tag VALUES ($event_id, '$tags')";
						
			$this->execute($query);
			
		}
				
	}
	
	
	
	public function update($Event, $calendar_id, $location_id=0, $contact_id=0, $schedule_id) {
		
		$ev = EVENT_TABLE;
		$ev_loc = EVLOCATION_TABLE;
		$ev_con = EVCONTACT_TABLE;
		$ev_user = EVUSER_TABLE;
		$ev_cal = EVCALENDAR_TABLE;
		$ev_tag = EVTAG_TABLE;
		$ev_sch = EVSCHEDULE_TABLE;
		
		$event_id = $Event->getId();
		$event_title = $Event->getTitle();
		$text_time = $Event->getTextTime();
		$event_desc = $Event->getDesc();
		$capacity = ($Event->getCapacity()) ? $Event->getCapacity(): 0;
		$approved = $Event->isApproved();
		$published = $Event->isPublished();
		$cancelled = $Event->isCancelled();
		$allow_register = $Event->allowRegistration();
		$tags = $Event->getTags();
				
				
		$query = "UPDATE $ev SET event_title = '$event_title', text_time = '$text_time', event_desc = '$event_desc', 
					capacity = $capacity, approved = $approved, published = $published, cancelled = $cancelled, 
					allow_register = $allow_register WHERE event_id = $event_id";
		
			
		$this->execute($query);
				
		
		$query = "DELETE FROM $ev_cal WHERE event_id = $event_id";
		$this->execute($query);
		
			
		while(list($ind, $val) = each($calendar_id)) {
		
			$query = "INSERT INTO $ev_cal VALUES ($event_id, $val)";
					
			$this->execute($query);
		
		}
		
		
		$query = "DELETE FROM $ev_loc WHERE event_id = $event_id";
			$this->execute($query);
			
		
		
		$query = "INSERT INTO $ev_loc VALUES ($event_id, $location_id)";
				
		$this->execute($query);
		
		
		
		$query = "DELETE FROM $ev_con WHERE event_id = $event_id";
			$this->execute($query);
				
		
		$query = "INSERT INTO $ev_con VALUES ($event_id, $contact_id)";
				
		$this->execute($query);
										
						
		$query = "DELETE FROM $ev_sch WHERE event_id = $event_id";
		$this->execute($query);
		
		
		while(list($ind, $val) = each($schedule_id)) {
		
			$query = "INSERT INTO $ev_sch VALUES ($event_id, $val)";
					
			$this->execute($query);
		
		}
		
		
		$query = "DELETE FROM $ev_tag WHERE event_id = $event_id";
		$this->execute($query);
		
		$tags = implode(",", $tags);
		
		$query = "INSERT INTO $ev_tag VALUES ($event_id, '$tags')";
					
		$this->execute($query);
		
	
	}
	
	
	public function delete($event_id) {
		
		$ev = EVENT_TABLE;
		$ev_loc = EVLOCATION_TABLE;
		$ev_con = EVCONTACT_TABLE;
		$ev_user = EVUSER_TABLE;
		$ev_cal = EVCALENDAR_TABLE;
		$ev_tag = EVTAG_TABLE;
		$ev_sch = EVSCHEDULE_TABLE;
		
		$event_id_set = array();
		
		if(is_array($event_id)) {
			$event_id_set = $event_id;
		} else {
			$event_id_set[] = $event_id;
		}
		
		
		while(list($ind, $val) = each($event_id_set)) {
			
			$query = "DELETE FROM $ev WHERE event_id = $val";
			$this->execute($query);
						
			$query = "DELETE FROM $ev_loc WHERE event_id = $val";
			$this->execute($query);
			
			$query = "DELETE FROM $ev_con WHERE event_id = $val";
			$this->execute($query);
			
			
			$query = "DELETE FROM $ev_user WHERE event_id = $val";
			$this->execute($query);
			
			
			$query = "DELETE FROM $ev_cal WHERE event_id = $val";
			$this->execute($query);
			
			
			$query = "DELETE FROM $ev_tag WHERE event_id = $val";
			$this->execute($query);
			
			
			$query = "DELETE FROM $ev_sch WHERE event_id = $val";
			$this->execute($query);
									
		}
		
		
	}
	
	
	
	
	public function setCancelled($cancelled, $event_id) {
		
		$ev = EVENT_TABLE;
		
		$query = "UPDATE $ev SET cancelled = $cancelled WHERE event_id = $event_id";
		
		$this->execute($query);
					
	}
	
	
	public function setPublished($published, $event_id) {
		
		$ev = EVENT_TABLE;
		
		$query = "UPDATE $ev SET published = $published WHERE event_id = $event_id";
				
		$this->execute($query);
		
	}
	
	
	public function toggleRegistration($allow_register, $event_id) {
		
		$ev = EVENT_TABLE;
		
		$query = "UPDATE $ev SET allow_register = $allow_register WHERE event_id = $event_id";
				
		$this->execute($query);
		
	}
	
	
	/*
	* Get the current location id in the system
	* @return $location_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$ev = EVENT_TABLE;
		
		$query = "SELECT event_id FROM $ev ORDER BY event_id DESC LIMIT 0,1";
				
		$Resultset = $this->executeQuery($query);
				
		$data = $Resultset->fetchRow();
		
		return $data[0];
		
	}	
					
}