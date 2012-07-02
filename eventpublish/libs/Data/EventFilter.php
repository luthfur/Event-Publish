<?php

/*********************************************************
Time Sharp Event Publish

Event Filter Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class EventFilter  {
	
	
	private $user_id;
	private $keywords;
	private $location_id;
	private $calendar_id;
	private $category_id;
	private $event_type;
	
	private $start_date;
	private $stop_date;


	private $search_tags;
	private $search_title;
	private $search_desc;
	
	private $approved = NULL;
	private $cancelled = NULL;
	private $published = NULL;
	
	private $date_range = 0;
	
	private $time_zone;
	
	
	public function setUserId($uid) {
		$this->user_id = $uid;
	}
	
	public function getUserId() {
		return $this->user_id;
	}
	
	public function setKeywords($keywords) {
		$this->keywords = $keywords;
	}
	
	public function getKeywords() {
		return $this->keywords;
	}	
	
	
	public function setTimeZone($time_zone) {
		$this->time_zone = $time_zone;
	}
	
	public function getTimeZone() {
		return $this->time_zone;
	}
	
	public function setLocationId($lid) {
		$this->location_id = $lid;
	}
	
	public function getLocationId() {
		return $this->location_id;
	}
	
	public function setCalendarId($cid) {
		$this->calendar_id = $cid;
	}
	
	public function getCalendarId() {
		return $this->calendar_id;
	}
		
		
	public function setCategoryId($catid) {
		$this->category_id = $catid;
	}
	
	public function getCategoryId() {
		return $this->category_id;
	}	
	
	
	public function setEventType($type) {
		$this->event_type = $type;
	}
	
	public function getEventType() {
		return $this->event_type;
	}	
	
	
	public function setPublished($published) {
		$this->published = $published;
	}
	
	public function getPublished() {
		return $this->published;
	}	
	
	public function setDateRange($start_date, $stop_date) {
		$this->start_date = $start_date;
		$this->stop_date = $stop_date;
		$this->date_range = 1;
	}
	
	public function getStartDate() {
		return $this->start_date;
	}	
	
	public function getStopDate() {
		return $this->stop_date;
	}
	
	public function getDateRange() {
		return $this->date_range;
	}
	
	
	public function setCancelled($cancelled) {
		$this->cancelled = $cancelled;
	}
	
	public function getCancelled() {
		return $this->cancelled;
	}	
	
	
	public function setApproved($approved) {
		$this->approved = $approved;
	}
	
	public function getApproved() {
		return $this->approved;
	}
	
	
	public function setKeywordSearch($title=0, $desc=0, $tags=0) {
		$this->search_title = $title;
		$this->search_desc = $desc;
		$this->search_tags = $tags;
		
	}
	
	public function searchTitle() {
		return $this->search_title;
	}
	
	public function searchDesc() {
		return $this->search_desc;
	}
	
	public function searchTags() {
		return $this->search_tags;
	}
	
	
}