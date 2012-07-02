<?php

/*********************************************************
Time Sharp Event Publish

Account Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class AccountData extends DataAccess {
	
	private $acc;		// account table name
	private $user;		// user table name
	

	function __construct($db) {
		
		// establish database object
		$this->mdb2 = $db;
		
		$this->acc = ACCOUNT_TABLE;			// contact table
		$this->user = USER_TABLE;	
	
	}	
	
	
	/*
	* Get a single row of account data
	* @param $account_id
	* @return Resultset
	*
	*/	
	public function getSingle($account_id) {
				
		$query = "SELECT * FROM $this->acc, $this->user WHERE $this->acc.user_id = $this->user.user_id AND $this->acc.account_id = " . $account_id;
				
		return $this->executeQuery($query)->fetchRow(MDB2_FETCHMODE_ASSOC);
				
	}
	
	
	/*
	* Get a single row of account data
	* @param $account_id
	* @return Resultset
	*
	*/	
	public function checkUserName($user_name) {
				
		$query = "SELECT * FROM $this->acc WHERE $this->acc.user_name = '" . $user_name . "'";
				
		$results = $this->executeQuery($query);
		
		return $results->numRows();
				
	}
	
	
	/*
	* Get multiple rows of account data
	* @param order by
	* @param order
	* @param limit
	* @return Resultset
	*
	*/	
	public function getList($order_by = null, $order = null, $limit = null) {
		
		$query = "SELECT * FROM $this->acc, $this->user WHERE $this->acc.user_id = $this->user.user_id ";
					
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;			
						
		return $this->executeQuery($query);
				
	}
		
	
	
	
	/*
	* Insert a single row of account data
	* @param $SystemAccount object
	* @return Affected rows
	*
	*/	
	public function add($User) {
		
		$full_name = $User->getContactInfo()->getName();
		$email = $User->getContactInfo()->getEmail();
		
		$Account = $User->getAccount();
				
		$account_id = $this->getCurrentAccountId() + 1;
		$user_id = $this->getCurrentUserId() + 1;
		
		$user_name = $Account->getUserName();
		$password = $Account->getPassword();
		$account_date_set = $Account->getDateSet();
		$account_type = $Account->getAccountType();
		$active = $Account->isActive();
		
		$Settings = $Account->getSettings();
		$time_zone = $Settings->getTimeZone();
		$per_page = $Settings->getPerPage();
						
		$query = "INSERT INTO $this->acc VALUES ($account_id, $user_id, '$user_name', md5('" . $password . "'), $account_date_set, $account_type,  $active, $time_zone, $per_page)";
						
		$this->execute($query);
		
		$query = "INSERT INTO $this->user VALUES($user_id, '$full_name', '$email')";
		
		$this->execute($query);
					
	}
	
	
	
	
	/*
	* Update a single row of account data
	* @param $Account object
	* @return Affected rows
	*
	*/
	public function update($User) {
		
		$full_name = $User->getContactInfo()->getName();
		$email = $User->getContactInfo()->getEmail();
		$user_id = $User->getUserId();
		
		$Account = $User->getAccount();
				
		$account_id = $Account->getAccountId();		
		$user_name = $Account->getUserName();
		$password = $Account->getPassword();
		$account_type = $Account->getAccountType();
	
		
		
				
		$query = "UPDATE $this->acc SET account_type = $account_type WHERE account_id = $account_id";
						
		$this->execute($query);
		
		$query = "UPDATE $this->user SET user_full_name = '$full_name', user_email = '$email' WHERE user_id = $user_id";
				
		$this->execute($query);
		
	}
	
	
	
	
	public function updateSettings($AccountSettings, $account_id) {
		
		$timezone = $AccountSettings->getTimeZone();
		$per_page = $AccountSettings->getPerPage();
		
		$query = "UPDATE $this->acc SET account_timezone = $timezone, account_perpage = $per_page WHERE account_id = $account_id";
		
		$this->execute($query);
	
	}
	
	
	
	public function changePassword($password, $account_id) {
					
		$query = "UPDATE $this->acc SET password = md5('$password') WHERE account_id = $account_id";
		
		$this->execute($query);
	
	}
	
	
		
	
	/*
	* Delete one or more account rows
	* @param $account_id - array of account ids to be deleted
	* 
	*/
	public function delete($account_id, $user_id) {
												
		$query = "DELETE FROM $this->acc WHERE account_id = $account_id";
		$this->execute($query);
					
		$query = "DELETE FROM $this->user WHERE user_id = $user_id";
		$this->execute($query);		
	
	}
	
	
	/*
	* Delete one or more account rows
	* @param $account_id - array of account ids to be deleted
	* 
	*/
	public function reassign($old_user_id, $new_user_id) {
		
		$c = CONTACT_TABLE;
		$l = LOCUSER_TABLE;
		$eu = EVUSER_TABLE;
				
		$query = "UPDATE $c SET user_id = $new_user_id WHERE user_id = $old_user_id";
		$this->execute($query);					
		
		$query = "UPDATE $l SET user_id = $new_user_id WHERE user_id = $old_user_id";
		$this->execute($query);	
		
		$query = "UPDATE $eu SET user_id = $new_user_id WHERE user_id = $old_user_id";
		$this->execute($query);	
		
			
	}
	
	
	
	/*
	* Get the current account id in the system
	* @return $account_id - current id in the system
	* 
	*/
	public function getCurrentAccountId() {
		
		$query = "SELECT account_id FROM $this->acc ORDER BY account_id DESC LIMIT 0,1";
						
		$Resultset = $this->executeQuery($query);
				
		$acc_data = $Resultset->fetchRow();
		
		return $acc_data[0];
		
	}
	
	
	/*
	* Get the current account id in the system
	* @return $account_id - current id in the system
	* 
	*/
	public function getCurrentUserId() {
		
		$query = "SELECT user_id FROM $this->user ORDER BY user_id DESC LIMIT 0,1";
						
		$Resultset = $this->executeQuery($query);
				
		$user_data = $Resultset->fetchRow();
		
		return $user_data[0];
		
	}
	
}