<?php

/*********************************************************
Time Sharp Event Publish

Location Class - Represents a contact in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Location  {

	private $location_id;
	private $location_title;
	private $location_desc;
	private $location_image;
	
	private $Address;
	
	function __construct($data=null, $id = null) {
		
		if($data == null) {
		
			$this->location_id = 0;
			$this->location_title = "";
			$this->location_desc = "";
		
			$this->Address = null;
			
			if($id != null) $this->location_id = $id;
			
			return;
		
		}
		
		$this->location_id = $data["location_id"];
		$this->location_title = $data["location_title"];
		$this->location_desc = $data["location_desc"];
		//$this->location_image = $data["location_image"];
		
		$address_data = array( "address1"=>$data["location_address1"],
								"address2"=>$data["location_address2"],
								"city"=>$data["location_city"],
								"state"=>$data["location_state"],
								"zip"=>$data["location_zip"],
								"phone"=>$data["location_phone"],
								"fax"=>$data["location_fax"]);
								
		$this->Address = new Address($address_data);
		
	}		
	
	
	public function setTitle($location_title) {
		$this->location_title = $location_title;
	}
	
	
	public function setDescription($location_desc) {
		$this->location_desc = $location_desc;
	
	}
	
		
	public function setAddress($Address) {
		$this->Address = $Address;
	}
	
	public function setImage($location_image) {
		$this->location_image = $location_image;
	}
			

	public function getId() {
		return $this->location_id;
	}
	
	
	public function getTitle() {
		return $this->location_title;
	}
	
	
	public function getDescription() {
		return $this->location_desc;
	
	}
	
		
	public function getAddress() {
		return $this->Address;
	}
	
	public function getImage() {
		return $this->location_image;
	}	
	
}