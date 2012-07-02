<?php

/*********************************************************
Time Sharp Event Publish

SystemSettings Class - Represents the complete set of system settings

Developed by Luthfur Rahman Chowdhury

January 20, 2008
**********************************************************/



class SystemSettings  {

	private $settings;

	function __construct($data) {
		
		if(!is_array($data)) {
			
			$this->settings = array();
		}
		
		$this->settings = $data;
	
	}		
	
	public function getValue($key) {
		return $this->settings[$key];
	}

	public function getAll() {
		return $this->settings;
	}
			
					
}