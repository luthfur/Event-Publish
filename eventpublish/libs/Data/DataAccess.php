<?php

/*********************************************************
Time Sharp Event Publish

Data Access Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class DataAccess  {
	
	
	protected $mdb2;
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
	
	}	
	
		
	/**************** Helper Methods for Query executions  ****************************/
		
	public function executeQuery($query) {
		
		$this->mdb2->connect();
				
		$ResultSet = $this->mdb2->query($query);
		
		$this->mdb2->disconnect();
		
		if (PEAR::isError($ResultSet)) {
			die($ResultSet->getMessage() . ": " . $query);
		}
		
		return $ResultSet;
		
	}
	
	
	
	public function execute($query) {
					
		$this->mdb2->connect();
				
		$Affected = $this->mdb2->exec($query);
		
		$this->mdb2->disconnect();
		
		if (PEAR::isError($Affected)) {
			die($Affected->getMessage() . ": " . $query);
		}
		
		return $Affected;
		
	}
	
	/********************************************************************************/
	
					
}