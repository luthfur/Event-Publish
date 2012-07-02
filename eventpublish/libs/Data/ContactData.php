<?php

/*********************************************************
Time Sharp Event Publish

Contact Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class ContactData extends DataAccess {
	
	private $con;		// contact table name
	private $user;
	private $ev_con;

	function __construct($db) {
		
		// establish database object
		$this->mdb2 = $db;
		
		$this->con = CONTACT_TABLE;			// contact table
		$this->ev_con = EVCONTACT_TABLE;	
		$this->user = USER_TABLE;		// USER table
	}	
	
	
	/*
	* Get a single row of contact data
	* @param $contact_id
	* @return Resultset
	*
	*/	
	public function getSingle($contact_id) {
				
		$query = "SELECT * FROM $this->con WHERE $this->con.contact_id = " . $contact_id;
				
		return $this->executeQuery($query);
				
	}
	
	
	/*
	* Get multiple rows of contact data
	* @param user id
	* @param order by
	* @param order
	* @param limit
	* @return Resultset
	*
	*/	
	public function getList($user_id=null, $order_by = null, $order = null, $limit = null) {
		
		$query = "SELECT * FROM $this->con, $this->user WHERE $this->con.user_id = $this->user.user_id";
		
		if($user_id != null) $query .= " AND $this->user.user_id = " . $user_id;
			
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;			
						
		return $this->executeQuery($query);
				
	}
		
	
	
	
	public function getDetailedList($user_id=null, $keywords=null, $search_type=null, $order_by = null, $order = null, $limit = null) {
	
		$query = "SELECT * FROM $this->con, $this->user WHERE $this->con.user_id = $this->user.user_id";
		
		if($user_id != null) $query .= " AND $this->user.user_id = " . $user_id;
		
		if($search_type && $keywords) {
			
			$keyword_array = explode(" ", $keywords);
			
			$query .= " AND(";
			
			while (list($ind, $val) = each($keyword_array)) {
				
				if($ind > 0) $query .= " OR"; 
						
				if($search_type[0]) {
					 $query .= " $this->con.contact_name LIKE '%$val%'";
				}
								
				if($search_type[1]) {
					if($search_type[0]) $query .= " OR";
					 $query .= " $this->con.contact_email LIKE '%$val%'";
				}
				
				if($search_type[2]) {
					if($search_type[0] || $search_type[1]) $query .= " OR";
					 $query .= " $this->con.contact_address1 LIKE '%$val%' OR $this->con.contact_address2 LIKE '%$val%'";
				}
				
				if($search_type[3]) {
					if($search_type[0] || $search_type[1] || $search_type[2]) $query .= " OR";
					 $query .= " $this->con.contact_city LIKE '%$val%'";
				}
				
				if($search_type[4]) {
					if($search_type[0] || $search_type[1] || $search_type[2] || $search_type[3]) $query .= " OR";
					 $query .= " $this->con.contact_state LIKE '%$val%'";
				}
						
				
			}	
			
			$query .= ")";			
		}
			
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;	
				
		return $this->executeQuery($query);
		
	}
	
	
	
	/*
	* Insert a single row of contact data
	* @param $Location object
	* @param user id
	* @return Affected rows
	*
	*/	
	public function add($Contact, $user_id) {

		$contact_id = $this->getCurrentId() + 1;
		
		$ContactInfo = $Contact->getContactInfo();
		
		$name = $ContactInfo->getName();
		$email = $ContactInfo->getEmail();
		$cell = $ContactInfo->getCell();
				
		$Address = $Contact->getContactInfo()->getAddress();
		
		$address1 = $Address->getAddressLine1();
		$address2 = $Address->getAddressLine2();
		$city = $Address->getCity();
		$state = $Address->getState();
		$zip = $Address->getZip();
		$phone = $Address->getPhone();
		$fax = $Address->getFax();
		
				
		$query = "INSERT INTO $this->con VALUES ($contact_id, $user_id, '$name', '$address1', '$address2', '$city', '$state', '$zip', '$email', '$phone', '$fax', '$cell')";
				
		$this->execute($query);
					
	}
	
	
	
	
	/*
	* Update a single row of location data
	* @param $Location object
	* @return Affected rows
	*
	*/
	public function update($Contact) {
		
		$id = $Contact->getId();
		$ContactInfo = $Contact->getContactInfo();
		$contact_name = $ContactInfo->getName();
						
		$Address = $ContactInfo->getAddress();
		$contact_address1 = $Address->getAddressLine1();
		$contact_address2 = $Address->getAddressLine2();
		$contact_city = $Address->getCity();
		$contact_state = $Address->getState();
		$contact_zip = $Address->getZip();
		$contact_phone = $Address->getPhone();
		$contact_fax = $Address->getFax();
		$contact_cell = $ContactInfo->getCell();
		$contact_email = $ContactInfo->getEmail();
		
		$query = "UPDATE $this->con SET contact_name = '$contact_name', 
										contact_address1 = '$contact_address1',
										contact_address2 = '$contact_address2',
										contact_city = '$contact_city',
										contact_state = '$contact_state',
										contact_zip = '$contact_zip',
										contact_phone = '$contact_phone',
										contact_fax = '$contact_fax',
										contact_cell = '$contact_cell',
										contact_email = '$contact_email'
										WHERE contact_id = $id";
				
		return $this->execute($query);
		
	}
		
	
	/*
	* Delete one or more location rows
	* @param $location_id - array of location ids to be deleted
	* 
	*/
	public function delete($contact_id) {
		
		while(list($ind, $val) = each($contact_id)) {
			
			$query = "DELETE FROM $this->con WHERE contact_id = $val";
			$this->execute($query);
						
			$query = "UPDATE $this->ev_con SET contact_id = 0 WHERE contact_id = $val";
			$this->execute($query);
						
		}
	
	}
	
	
	/*
	* Get the current location id in the system
	* @return $location_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$query = "SELECT contact_id FROM $this->con ORDER BY contact_id DESC LIMIT 0,1";
						
		$Resultset = $this->executeQuery($query);
				
		$locationdata = $Resultset->fetchRow();
		
		return $locationdata[0];
		
	}
	
}