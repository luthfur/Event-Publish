<?php

/*********************************************************
Time Sharp Event Publish

Event Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class ScheduleDbData extends DataAccess {
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
	}	
	
	
	/*
	* get schedule data pretaining to an event
	* 
	* @param event_id
	* @return schedule resultset
	*
	*/	
	public function getEventScheduleData($event_id) {
	
		$ev = EVENT_TABLE;
		$ev_sch = EVSCHEDULE_TABLE;
		$sch = SCHEDULE_TABLE;
		
		$query = "SELECT * FROM $ev, $ev_sch, $sch 
		WHERE $ev.event_id = $ev_sch.event_id AND $sch.schedule_id = $ev_sch.schedule_id AND $ev.event_id = $event_id";
				
		return $this->executeQuery($query);
		
	}
	
	
	
	/*
	* Insert a single row of location data
	* @param $Location object
	* @param user id
	* @return Affected rows
	*
	*/	
	public function add($ScheduleData) {
		
		$sch = SCHEDULE_TABLE;
		
		$schedule_id = $this->getCurrentId() + 1;
					
		$schedule_type = $ScheduleData->getType();
		$start_date = $ScheduleData->getStartDate()->getTimeStamp();
		$stop_date = $ScheduleData->getStopDate()->getTimeStamp();
		$timespec = $ScheduleData->getTimeSpec();
		$org_timezone = $ScheduleData->getOriginalTimeZone();
		
				
		$query = "INSERT INTO $sch VALUES ($schedule_id, $schedule_type, $start_date, $stop_date, $timespec, $org_timezone)";
				
		$this->execute($query);
	
	}
	
	
	/*
	* Get the current location id in the system
	* @return $location_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$sch = SCHEDULE_TABLE;
		
		$query = "SELECT schedule_id FROM $sch ORDER BY schedule_id DESC LIMIT 0,1";
			
		
		$Resultset = $this->executeQuery($query);
		
	//	echo "herea";
		
		$data = $Resultset->fetchRow();
		
	//	echo "hereb";
		return $data[0];
		
	}
	
	
	
	public function delete($id) {
				
		$sch = SCHEDULE_TABLE;
		
		if(!is_array($id)) {
			
			$query = "DELETE FROM $sch WHERE schedule_id = $id";
			$this->execute($query);
				
		} else {
		
			while(list($ind, $val) = each($id)) {
				
				$query = "DELETE FROM $sch WHERE schedule_id = $val";
				$this->execute($query);
													
			}	
		}	
		
	}	
	
	
	public function deleteByEvent($id) {
				
		$Result = $this->getEventScheduleData($id);
		
		while($data = $Result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
			
			$this->delete($data[schedule_id]);		
		}
	}
	
	
					
}