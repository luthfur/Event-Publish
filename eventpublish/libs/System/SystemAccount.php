<?php

/*********************************************************
Time Sharp Event Publish

System Account Class - Represents a account in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class SystemAccount  {

	private $account_id;
	private $user_name;
	private $password;
	private $date_set;
	private $active;
	private $account_type;
	private $AccountSettings;	
	
	function __construct($data) {
				
		$this->user_name = $data["user_name"];
		$this->password = $data["password"];
		$this->date_set = $data["account_date_set"];
		$this->account_type = $data["account_type"];
		$this->active = $data["account_active"];
		$this->account_id = $data["account_id"];
		
		$settings_data["account_timezone"] = $data["account_timezone"];
		$settings_data["account_perpage"] = $data["account_perpage"];
				
		$this->AccountSettings = new AccountSettings($settings_data);	
		
		
	}		
	
	public function getAccountId() {
		return $this->account_id;
	}
	

	public function getUserName() {
		return $this->user_name;
	}
	
	
	
	public function getDateSet() {
		return $this->date_set;
	}
	
	
	public function isActive() {
		return $this->active;
	}
		
		
	public function checkPassword($pass) {
		if(md5($pass) == $this->password) return true;
		
		return false;
	}		
	
	public function getPassword(){
		return $this->password;
	}
	
	
	public function getSettings() {
		return $this->AccountSettings;
	}
	
	public function getAccountType() {
		return $this->account_type;
	}
	
				
}