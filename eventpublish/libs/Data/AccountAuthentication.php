<?php

/*********************************************************
Time Sharp Event Publish

Account Authentication Class

Developed by Luthfur Rahman Chowdhury

February 28th, 2008
**********************************************************/



class AccountAuthentication extends DataAccess {
	
	private $acc;		// account table name
	private $user;		// user table name
	

	function __construct($db) {
		
		// establish database object
		$this->mdb2 = $db;
		
		$this->acc = ACCOUNT_TABLE;			// account table
		$this->user = USER_TABLE;			// user table
	
	}	
	
		
	/*
	* Get a single row of account data
	* @param $account_id
	* @return Resultset
	*
	*/	
	public function check($user_name, $password) {
				
		$query = "SELECT * FROM $this->acc, $this->user WHERE $this->acc.user_name = '" . $user_name . "' AND $this->acc.password = MD5('". $password ."') AND $this->acc.user_id = $this->user.user_id";
						
		$results = $this->executeQuery($query);
		
		$account_data = $results->fetchRow(MDB2_FETCHMODE_ASSOC);
				
		return (($results->numRows() > 0) ? $account_data: 0);
				
	}
	
	
	
	public function checkEmail($user_name, $email) {
				
		$query = "SELECT * FROM $this->acc, $this->user  WHERE $this->acc.user_name = '" . $user_name . "' AND $this->user.user_email = '$email' AND $this->acc.user_id = $this->user.user_id";
						
		$results = $this->executeQuery($query);
		
		$account_data = $results->fetchRow(MDB2_FETCHMODE_ASSOC);
				
		return (($results->numRows() > 0) ? $account_data['account_id']: 0);
				
	}
	
	
}