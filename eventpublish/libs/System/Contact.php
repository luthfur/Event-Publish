<?php

/*********************************************************
Time Sharp Event Publish

Contact Class - Represents a contact in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Contact  {

	private $contact_id;
	private $ContactInfo;
			
	function __construct($data=null, $id = null) {
		
		if($data == null) {
		
			$this->contact_id = 0;
			$this->ContactInfo = null;
			
			if($id != null) $this->contact_id = $id;
			
			return;
		
		}
		
		$this->contact_id = $data["contact_id"];
		
		$contact_data = array( "address1"=>$data["contact_address1"],
								"address2"=>$data["contact_address2"],
								"city"=>$data["contact_city"],
								"state"=>$data["contact_state"],
								"zip"=>$data["contact_zip"],
								"phone"=>$data["contact_phone"],
								"fax"=>$data["contact_fax"],
								"name"=>$data["contact_name"],
								"email"=>$data["contact_email"],
								"cell"=>$data["contact_cell"]);
								

		$this->ContactInfo = new ContactInfo($contact_data);
		
	}		
	
		
	public function setContactInfo($ContactInfo) {
		$this->ContactInfo = $ContactInfo;
	}	
	
	
		

	public function getId() {
		return $this->contact_id;
	}
			
	public function getContactInfo() {
		return $this->ContactInfo;
	}	
	
}