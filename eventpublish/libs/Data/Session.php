<?php
		
/***********************************************************************
Session Class

This module has been developed by Luthfur R. Chowdhury.
	
(c)2008 TimeSharp  All Rights Reserved.
************************************************************************/

class Session {
	
	 public function __construct()
    {
       session_start();
    }

	/************************ Register Session ******************************/
	public function register($data) {
		
		// set session variables
		while(list($ind, $val) = each($data)){
			$_SESSION[$ind] = $val;
		}
		
		// set expiry
		$_SESSION['accexp_expire'] = time() + (EP_SESSION_LENGTH * 60 * 60);

				
	}

	
	/********************** Check if session has been registered ***************/
	public function check($value) {
	
		if(isset($_SESSION[$value])) {
			return 1;
		} else {
			return 0;
		}
	}
	
	
	public function isExpired() {
	
		if(time() > $_SESSION['accexp_expire']) {
			return 1;
		} else {
			return 0;
		}
	}
	
	
	public function resetExpiry() {
	
		$_SESSION['accexp_expire'] = time() + (EP_SESSION_LENGTH * 60 * 60);
	}
	
	
	/*************************** Get user Data *****************************/
	public function getData() {
	
		return $_SESSION;
	
	}
	
	
	public function getSessionValue($field) {
	
		return $_SESSION[$field];
	
	}
	
	
	
	/*************************** Destroy Session *******************************/
	public function destroy() {
	
		session_destroy();	
	
	}
	


}