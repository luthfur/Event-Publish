<?php

/*********************************************************
Time Sharp Event Publish

Calendar Class - Represents a calendar in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Calendar  {

	private $calendar_id;
	private $category_id;
	private $calendar_name;
	private $privacy_state;
	private $total_events;
	
	function __construct($data = null, $id = null) {
		
		if($data == null) {
			
			$this->calendar_id = 0;
			$this->category_id = 0;
			$this->calendar_name = "";
			$this->calendar_image = "";
			$this->calendar_icon = "";
			$this->privacy_state = 0;
			
			if($id != null) $this->calendar_id = $id;
			
			return;
			
		}
		
		$this->category_id = $data["category_id"];
		$this->calendar_id = $data["calendar_id"];
		$this->calendar_name = $data["calendar_name"];
		$this->privacy_state = $data["privacy_state"];
		$this->total_events = $data["total_events"];
	}	
	
	
	public function setCategoryId($category_id) {
		$this->category_id = $category_id;
	}

	public function setName($calendar_name) {
		$this->calendar_name = $calendar_name;
	}
		
	
	public function setTotalEvents($total_events) {
		$this->total_events = $total_events;
	}	
		
	
	public function setPrivacyState($privacy_state) {
		$this->privacy_state = $privacy_state;
	}
	
				

	public function getId() {
		return $this->calendar_id;
	}
	
	
	public function getCategoryId() {
		return $this->category_id;
	}
	
	public function getName() {
		return $this->calendar_name;
	}
			
	public function getPrivacyState() {
		return $this->privacy_state;
	}
	
	public function getTotalEvents() {
		return $this->total_events;
	}
	
}