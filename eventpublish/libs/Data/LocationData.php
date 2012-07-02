<?php

/*********************************************************
Time Sharp Event Publish

Location Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class LocationData extends DataAccess {
		
	private $loc;		// location table name
	private $loc_user;
	private $user;
	private $ev_loc;

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
		
		$this->loc = LOCATION_TABLE;			// location table
		$this->loc_user = LOCUSER_TABLE;		// location user table
		$this->user = USER_TABLE;				// user table
		$this->ev_loc = EVLOCATION_TABLE;
	}
	
	/*
	* Get a single row of location data
	* @param $location_id
	* @return Resultset
	*
	*/	
	public function getSingle($location_id) {
				
		$query = "SELECT * FROM $this->loc, $this->user, $this->loc_user 
				WHERE $this->loc.location_id = $this->loc_user.location_id AND 
				$this->user.user_id = $this->loc_user.user_id AND $this->loc.location_id = " . $location_id;
		
		return $this->executeQuery($query);
				
	}
	
	
	/*
	* Get multiple rows of location data
	* @param user id
	* @param order by
	* @param order
	* @param limit
	* @return Resultset
	*
	*/	
	public function getList($user_id=null, $order_by = null, $order = null, $limit = null) {
		
		$query = "SELECT * FROM $this->loc, $this->user, $this->loc_user 
				WHERE $this->loc.location_id = $this->loc_user.location_id AND $this->user.user_id = $this->loc_user.user_id";
		
		if($user_id != null) $query .= " AND $this->user.user_id = " . $user_id;
			
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;	
				
		return $this->executeQuery($query);
				
	}
	
	public function getDetailedList($user_id=null, $keywords=null, $search_type=null, $order_by = null, $order = null, $limit = null) {
	
		$query = "SELECT * FROM $this->loc, $this->user, $this->loc_user 
				WHERE $this->loc.location_id = $this->loc_user.location_id AND $this->user.user_id = $this->loc_user.user_id";
		
		if($user_id != null) $query .= " AND $this->user.user_id = " . $user_id;
		
		if($search_type && $keywords) {
			
			$keyword_array = explode(" ", $keywords);
			
			$query .= " AND(";
			
			while (list($ind, $val) = each($keyword_array)) {
								
				if($search_type[0]) {
					 $query .= " $this->loc.location_title LIKE '%$val%'";
				}
				
				if($search_type[1]) {
					if($search_type[0]) $query .= " OR";
					 $query .= " $this->loc.location_address1 LIKE '%$val%' OR $this->loc.location_address2 LIKE '%$val%'";
				}
				
				if($search_type[2]) {
					if($search_type[0] || $search_type[1]) $query .= " OR";
					 $query .= " $this->loc.location_city LIKE '%$val%'";
				}
				
				if($search_type[3]) {
					if($search_type[0] || $search_type[1] || $search_type[2]) $query .= " OR";
					 $query .= " $this->loc.location_state LIKE '%$val%'";
				}
				
				if($search_type[4]) {
					if($search_type[0] || $search_type[1] || $search_type[2] || $search_type[3]) $query .= " OR";
					 $query .= " $this->loc.location_zip LIKE '%$val%'";
				}
			}	
			
			$query .= ")";			
		}
			
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;	
				
		return $this->executeQuery($query);
		
	}
	
	
	
	
	/*
	* Insert a single row of location data
	* @param $Location object
	* @param user id
	* @return Affected rows
	*
	*/	
	public function add($Location, $user_id) {

		$location_id = $this->getCurrentId() + 1;
			
		
		$title = $Location->getTitle();
		$desc = $Location->getDescription();
		$image = $Location->getImage();
				
		$Address = $Location->getAddress();
		
		$address1 = $Address->getAddressLine1();
		$address2 = $Address->getAddressLine2();
		$city = $Address->getCity();
		$state = $Address->getState();
		$zip = $Address->getZip();
		$phone = $Address->getPhone();
		$fax = $Address->getFax();
		
				
		$query = "INSERT INTO $this->loc VALUES ($location_id, '$title', '$address1', '$address2', '$city', '$state', '$zip', '$phone', '$fax', '$desc', '$image')";
				
		$this->execute($query);
	
		$query = "INSERT INTO $this->loc_user VALUES ($user_id, $location_id)";
				
		$this->execute($query);
				
	}
	
	
	
	
	/*
	* Update a single row of location data
	* @param $Location object
	* @return Affected rows
	*
	*/
	public function update($Location) {
		
		$id = $Location->getId();
		$title = $Location->getTitle();
		$desc = $Location->getDescription();
		$image = $Location->getImage();
				
		$Address = $Location->getAddress();
		$address1 = $Address->getAddressLine1();
		$address2 = $Address->getAddressLine2();
		$city = $Address->getCity();
		$state = $Address->getState();
		$zip = $Address->getZip();
		$phone = $Address->getPhone();
		$fax = $Address->getFax();

		$query = "UPDATE $this->loc SET location_title = '$title', 
										location_address1 = '$address1',
										location_address2 = '$address2',
										location_city = '$city',
										location_state = '$state',
										location_zip = '$zip',
										location_phone = '$phone',
										location_fax = '$fax',
										location_desc = '$desc',
										location_image = '$image'
										WHERE location_id = $id";
			
				
		return $this->execute($query);
		
	}
		
	
	/*
	* Delete one or more location rows
	* @param $location_id - array of location ids to be deleted
	* 
	*/
	public function delete($location_id) {
		
		while(list($ind, $val) = each($location_id)) {
			
			$query = "DELETE FROM $this->loc WHERE location_id = $val";
			$this->execute($query);
					
			$query = "DELETE FROM $this->loc_user WHERE location_id = $val";
			$this->execute($query);
			
			$query = "UPDATE $this->ev_loc SET location_id = 0 WHERE location_id = $val";
			$this->execute($query);
						
		}
	
	}
	
	
	/*
	* Get the current location id in the system
	* @return $location_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$query = "SELECT location_id FROM $this->loc ORDER BY location_id DESC LIMIT 0,1";
				
		$Resultset = $this->executeQuery($query);
			
		$locationdata = $Resultset->fetchRow();
		
		return $locationdata[0];
		
	}
	
	
					
}