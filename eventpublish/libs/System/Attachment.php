<?php

/*********************************************************
Time Sharp Event Publish

Attachment Class - Represents a attachment to an event in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Attachment  {

	private $attachment_id;
	private $file_name;
	private $file_type;
	private $file_size;
	private $file_desc;
	private $file_added;
	private $file_approved;
	

	function __construct($data = null, $id = null) {
		
		if($data == null) {
		
			$this->attachment_id = 0;
			$this->file_name = "";
			$this->file_type = "";
			$this->file_size = "";
			$this->file_desc = "";
			$this->file_added = "";
			$this->file_approved = 0;
			
			if($id != null) $this->attachment_id = $id;
			
			return;
		
		}
		
		
		$this->attachment_id = $data["attachment_id"];
		$this->file_name = $data["file_name"];
		$this->file_type = $data["file_type"];
		$this->file_size = $data["file_size"];
		$this->file_desc = $data["file_desc"];
		$this->file_added = $data["file_added"];
		$this->file_approved = $data["file_approved"];

	}		
	
	
	public function setFileName($file_name) {
		$this->file_name = $file_name;
	}
	
	
	
	public function setFileType($file_type) {
		$this->file_type = $file_type;
	}
	
	
	public function setFileSize($file_size) {
		$this->file_size = $file_size;
	}
	
	
	public function setDesc($file_desc) {
		$this->file_desc = $file_desc;
	}
	
	
	
	public function setDateAdded($file_added) {
		$this->file_added = $file_added;
	}
	
	
	public function setApproved($file_approved) {
		$this->file_approved = $file_approved;
	}
	
	
	
	
	public function getId() {
		return $this->attachment_id;
	}
	
	
	public function getFileName() {
		return $this->file_name;
	}
	
	
	public function getFileSize() {
		return $this->file_size;
	}
	
	public function getFileType() {
		return $this->file_type;
	}
	
	
	public function getDesc() {
		return $this->file_desc;
	}
	
	
	public function getDateAdded() {
		return $this->file_added;
	}
	
	
	public function isApproved() {
		return $this->file_approved;
	}
	
			
}