<?php

/*********************************************************
Time Sharp Event Publish

SystemUser Class - Represents a My Events User in the system

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class SystemUser  {

	private $user_id;
	private $ContactInfo;		// contact information for the user
	private $SystemAccount;		// account information for the user
	

	function __construct($data, $id=null) {
		
		if($data == null) {
			
			if($id != null) $this->user_id = $id;
			$this->ContactInfo = null;
			return;
		}
		
		
		$this->user_id = $data["user_id"];
		
		
		$contact_data = array( "address1"=>"",
								"address2"=>"",
								"city"=>"",
								"state"=>"",
								"zip"=>"",
								"fax"=>"",
								"phone"=>"",
								"name"=>$data["user_full_name"],
								"email"=>$data["user_email"],
								"cell"=>"");
								
								
		$this->ContactInfo = new ContactInfo($contact_data);	
			
		$this->SystemAccount = new SystemAccount($data);
	
	}		
	
	public function getAccount() {
		return $this->SystemAccount;
	}

	public function getContactInfo() {
		return $this->ContactInfo;
	}
	
	public function getUserId() {
		return $this->user_id;
	}
		
					
}