<?php

/*********************************************************
Time Sharp Event Publish

Address Class - Represents an address in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Address  {

	private $address1;
	private $address2;
	private $city;
	private $state;
	private $zip;
	
	private $phone;
	private $fax;

	function __construct($data=null) {
		
		if($data == null) {
			
			$this->address1 = "";
			$this->address2 = "";
			$this->city = "";
			$this->state = "";
			$this->zip = "";
			$this->phone = "";
			$this->fax = "";
			
			return;
			
		}
		$this->address1 = $data["address1"];
		$this->address2 = $data["address2"];
		$this->city = $data["city"];
		$this->state = $data["state"];
		$this->zip = $data["zip"];
		$this->phone = $data["phone"];
		$this->fax = $data["fax"];
		
	}		
	
	
	public function setAddressLine1($address1) {
		$this->address1 = $address1;
	}
	
	
	public function setAddressLine2($address2) {
		$this->address2 = $address2;
	}
	
	
	public function setCity($city) {
		$this->city = $city;
	}
	
	
	public function setState($state) {
		$this->state = $state;
	}
	
	public function setZip($zip) {
		$this->zip = $zip;
	}
	
	
	public function setPhone($phone) {
		$this->phone = $phone;
	}
	
	public function setFax($fax) {
		$this->fax = $fax;
	}
	
	
			
	public function getAddressLine1() {
		return $this->address1;
	}
	
	
	public function getAddressLine2() {
		return $this->address2;
	}
	
	
	public function getCity() {
		return $this->city;
	}
	
	
	public function getState() {
		return $this->state;
	}
	
	public function getZip() {
		return $this->zip;
	}
	
	
	public function getPhone() {
		return $this->phone;
	}
	
	public function getFax() {
		return $this->fax;
	}
	
	
}