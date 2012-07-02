<?php

/*********************************************************
Time Sharp Event Publish

Calendar Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class CalendarData extends DataAccess  {
	
	private $cal;		// calendar table name
	private $cat;		// category table name
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
		
		$this->cal = CALENDAR_TABLE;		// calendar table
		$this->cat = CATEGORY_TABLE;		// category table
			
	}	
	
	
	/*
	* Get a single row of calendar data
	* @param $calendar_id
	* @return Resultset
	*
	*/	
	public function getSingle($calendar_id) {
				
		$query = "SELECT * FROM $this->cal, $this->cat WHERE $this->cal.category_id = $this->cat.cat_id AND calendar_id = " . $calendar_id;
		
		return $this->executeQuery($query);
				
	}
	
	
	/*
	* Get multiple rows of calendar data
	* @param order by
	* @param order
	* @param limit
	* @return Resultset
	*
	*/	
	public function getList($cat_id=null, $order_by = null, $order = null, $limit = null) {
		
		$query = "SELECT * FROM $this->cal, $this->cat WHERE $this->cal.category_id = $this->cat.cat_id";
		
		if($cat_id != null) $query .= " AND cat_id = " . $cat_id;
		
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;			
						
		//echo "$query";
		return $this->executeQuery($query);
				
	}
	
	
	
	/*
	* Insert a single row of calendar data
	* @param $Calendar object
	* @return Affected rows
	*
	*/	
	public function add($Calendar) {
		
		$query = "SELECT calendar_id FROM $this->cal ORDER BY calendar_id DESC LIMIT 0,1";
		
		$Resultset = $this->executeQuery($query);
		
		$calendardata = $Resultset->fetchRow();
		$calendar_id = $calendardata[0] + 1;
		
		$category_id = $Calendar->getCategoryId();
		$calendar_name = $Calendar->getName();
		$privacy_state = $Calendar->getPrivacyState();
				
		$query = "INSERT INTO $this->cal VALUES ($calendar_id, $category_id, '$calendar_name')";
				
		return $this->execute($query);
				
	}
	
	
	
	
	/*
	* Update a single row of calendar data
	* @param $Calendar object
	* @return Affected rows
	*
	*/
	public function update($Calendar) {
		
		$calendar_id = $Calendar->getId();
		$category_id = $Calendar->getCategoryId();
		$calendar_name = $Calendar->getName();
		$privacy_state = $Calendar->getPrivacyState();
		
		$query = "UPDATE $this->cal SET category_id = $category_id, calendar_name = '$calendar_name' WHERE calendar_id = $calendar_id";
		
		return $this->execute($query);
		
	}
	
	
	
	/*
	* Update a single row of calendar data with the new calendar name
	* @param $Calendar object
	* @return Affected rows
	*
	*/
	public function updateName($Calendar) {
		
		$calendar_id = $Calendar->getId();
		$calendar_name = $Calendar->getName();
		
		$query = "UPDATE $this->cal SET calendar_name = '$calendar_name' WHERE calendar_id = $calendar_id";
		
		return $this->execute($query);
		
	}
	
	
	
	/*
	* Update a single row of calendar data with the new category
	* @param $Calendar object
	* @return Affected rows
	*
	*/
	public function updateCategory($Calendar) {
		
		$calendar_id = $Calendar->getId();
		$category_id = $Calendar->getCategoryId();
		
		$query = "UPDATE $this->cal SET category_id = $category_id WHERE calendar_id = $calendar_id";
		
		return $this->execute($query);
		
	}
	
	
	
	public function getEvents($id) {
		
		$tb = EVCALENDAR_TABLE;
		
		$query = "SELECT * FROM $tb WHERE calendar_id = $id";
	
		return $this->executeQuery($query);
				
	}
	
	
	/*
	* Delete one or more calendar rows
	* @param $calendar_id - array of calendar ids to be deleted
	* @return MDB2_Error on error
	*
	*/
	public function delete($calendar_id) {
		
		if(is_array($calendar_id)) {
		
		while(list($ind, $val) = each($calendar_id)) {
			
			$query = "DELETE FROM $this->cal WHERE calendar_id = $val";
			$Affected = $this->execute($query);
			
			if (PEAR::isError($Affected)) {
				die($Affected->getMessage());
			}
			
		}
		
		} else {
		
			$query = "DELETE FROM $this->cal WHERE calendar_id = $calendar_id";
			$Affected = $this->execute($query);
			
			if (PEAR::isError($Affected)) {
				die($Affected->getMessage());
			}
		
		}
	
	}
	
	
	
	/*
	* Get the current calendar_id in the system
	* @return $calendar_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$query = "SELECT calendar_id FROM $this->cal ORDER BY calendar_id DESC LIMIT 0,1";
						
		$Resultset = $this->executeQuery($query);
				
		$cal_data = $Resultset->fetchRow();
		
		return $cal_data[0];
		
	}
		
					
}