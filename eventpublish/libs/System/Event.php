<?php

/*********************************************************
Time Sharp Event Publish

Event Class - Represents an event in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/


class Event  {

	private $event_id;
	private $event_title;
	private $text_time;
	private $event_desc;
	private $tags;
	private $capacity;
	private $comments;
	
	private $approved;
	private $published;
	private $cancelled;
	private $allow_register;
		
	private $Contact;
	private $Calendar;
	private $ScheduleInfo;
	private $Location;
	private $User;
	private $Attachments;
		

	function __construct($data=null, $id = null) {
		
		if($data == null) {
		
			$this->event_id = 0;
			$this->event_title = "";
			$this->text_time = "";
			$this->event_desc = "";
			$this->tags = "";
			$this->capacity = 0;
			
			$this->approved = 0;
			$this->published = 0;
			$this->cancelled = 0;
			$this->allow_register = 0;
			
			$this->Contact = null;
			$this->Location = null;
			$this->Calendar = array();
			$this->User = null;
			$this->Attachments = null;
			$this->ScheduleInfo = array();
			
			if($id != null) $this->event_id = $id;
			
			return;
		
		}
		
		$this->event_id = $data["event_id"];
		$this->event_title = $data["event_title"];
		$this->text_time = $data["text_time"];
		$this->event_desc = $data["event_desc"];
		$this->tags = ((trim($data["event_tags"]) != "") ? explode(",", $data["event_tags"]) : array());
		$this->capacity = $data["capacity"];
		
		$this->approved = $data["approved"];
		$this->published = $data["published"];
		$this->cancelled = $data["cancelled"];
		$this->allow_register = $data["allow_register"];
												
								
		$this->Contact = new Contact($contact_data);
		$this->Location = new Location($data);
		$this->User = new SystemUser($data);
		
		$this->Calendar = array();
		$this->Calendar[] = new Calendar($data);
		
		$this->ScheduleInfo = array();
		//$this->ScheduleInfo[] = new EventScheduleData($data, 1);
	
	}		
			
	
	
	public function setTitle($event_title) {
		$this->event_title = $event_title;
	}
	
	
	public function setTextTime($text_time) {
		$this->text_time = $text_time;
	}
	
	
	public function setDesc($event_desc) {
		$this->event_desc = $event_desc;
	}
	
	
	public function setTags($tags) {
		$this->tags = explode(",", $tags);
	}
	
	public function setCapacity($capacity) {
		$this->capacity = $capacity;
	}
	
	
	public function setApproved($approved) {
		$this->approved = $approved;
	}
	
	public function setPublished($published) {
		$this->published = $published;
	}
	
	
	public function setCancelled($cancelled) {
		$this->cancelled = $cancelled;
	}
	
	public function SetAllowRegistration($allow_register) {
		$this->allow_register = $allow_register;
	}
	
	
	public function setLocation($Location) {
		$this->Location = $Location;
	}
	
	
	public function setContact($Contact) {
		$this->Contact = $Contact;
	}
	
	
	public function setPublishedBy($User) {
		$this->User = $User;
	}
	
	
	public function setCalendar($Calendar) {
		$this->Calendar[] = $Calendar;
	}
	
	
	
	public function setAttachments($Attachments) {
		$this->Attachments = $Attachments;
	}
	
	public function setScheduleInfo($ScheduleInfo) {
		$this->ScheduleInfo[] = $ScheduleInfo;
	}
	
	public function setComments($comments) {
		$this->comments = $comments;
	}
	
	public function getId() {
		return $this->event_id;
	}
	
	
	public function getTitle() {
		return $this->event_title;
	}
	
	
	public function getTextTime() {
		return $this->text_time;
	}
	
	
	public function getDesc() {
		return $this->event_desc;
	}
	
	
	public function getTags() {
		return $this->tags;
	}
	
	public function getCapacity() {
		return $this->capacity;
	}
	
	
	public function isApproved() {
		return $this->approved;
	}
	
	public function isPublished() {
		return $this->published;
	}
	
	
	public function isCancelled() {
		return $this->cancelled;
	}
	
	public function allowRegistration() {
		return $this->allow_register;
	}
	
	
	public function getLocation() {
		return $this->Location;
	}
	
	
	public function getContact() {
		return $this->Contact;
	}
	
	
	public function getPublishedBy() {
		return $this->User;
	}
	
	
	public function getCalendar() {
		
		if(count($this->Calendar) == 0) return $this->Calendar[0];
		
		return $this->Calendar;
	}
	
	
	
	public function getAttachments() {
		return $this->Attachments;
	}
	
	public function getScheduleInfo() {
		return $this->ScheduleInfo;
	}
	
	public function getComments() {
		return $this->comments;
	}
	
}