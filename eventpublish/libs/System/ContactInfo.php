<?php

/*********************************************************
Time Sharp Event Publish

Contact Class - Represents a contact in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class ContactInfo  {

	private $contact_name;
	private $contact_email;
	private $contact_cell;
	
	private $Address;
	
	function __construct($data=null) {
		
		if($data == null) {
		
			$this->contact_id = 0;
			$this->contact_name = "";
			$this->contact_email = "";
			$this->contact_cell = "";
			$this->Address = null;
						
			return;
		
		}
		
		$this->contact_name = $data["name"];
		$this->contact_email = $data["email"];
		$this->contact_cell = $data["cell"];
				
		$this->Address = new Address($data);
		
	}		
	
	
	public function setName($contact_name) {
		$this->contact_name = $contact_name;
	}
	
	
	public function setEmail($contact_email) {
		$this->contact_email = $contact_email;
	}
	
	
	public function setCell($contact_cell) {
		$this->contact_cell = $contact_cell;
	}
	
	
	public function setAddress($Address) {
		$this->Address = $Address;
	}	
	
	
	
	public function getName() {
		return $this->contact_name;
	}
	
	
	public function getEmail() {
		return $this->contact_email;
	}
	
	
	public function getCell() {
		return $this->contact_cell;
	}
	
	
	public function getAddress() {
		return $this->Address;
	}	
	
}