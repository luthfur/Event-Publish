<?php

/*********************************************************
Time Sharp Event Publish

Account Settings Class - Represents account setting information
in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class AccountSettings  {

	private $account_timezone;
	private $account_perpage;
	
	function __construct($data) {
				
		$this->account_timezone = $data["account_timezone"];
		$this->account_perpage = $data["account_perpage"];
			
		
	}		
	
	public function getTimeZone() {
		return $this->account_timezone;
	}
	

	public function getPerPage() {
		return $this->account_perpage;
	}
	
				
}