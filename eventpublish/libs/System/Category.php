<?php

/*********************************************************
Time Sharp Event Publish

Category Class - Represents a category in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Category  {

	private $cat_id;
	private $cat_name;
	private $cat_image;
	private $Calendars;

	function __construct($data = null, $id = null) {
		
		if($data == null) {
		
			$this->cat_id = 0;
			$this->cat_name = "";
			$this->cat_image = "";
			
			$this->Calendar = null;
			
			if($id != null) $this->cat_id = $id;
			
			return;
		
		}
		
		$this->cat_id = $data["cat_id"];
		$this->cat_name = $data["cat_name"];
		$this->cat_image = $data["cat_image"];
		
		$this->Calendars = null;

	}		
	
	
	public function setName($cat_name) {
		$this->cat_name = $cat_name;
	}
	
	
	public function setImage($cat_image) {
		$this->cat_image = $cat_image;
	}
	
	public function setCalendars($Calendars) {
		$this->Calendars = $Calendars;
	}
	
	

	public function getId() {
		return $this->cat_id;
	}
		
	public function getName() {
		return $this->cat_name;
	}
	
	
	public function getImage() {
		return $this->cat_image;
	}
	
	public function getCalendars() {
		return $this->Calendars;
	}
			
}