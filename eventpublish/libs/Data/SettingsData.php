<?php

/*********************************************************
Time Sharp Event Publish

Settings Data Class

Developed by Luthfur Rahman Chowdhury

January 20, 2008
**********************************************************/



class SettingsData extends DataAccess {
	
	private $s;		// settings table name
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
		
		$this->s = SETTINGS_TABLE;
			
	}	
	
	
	/*
	* Get a single row of category data
	* @param $location_id
	* @return Resultset
	*
	*/	
	public function load() {
				
		$query = "SELECT * FROM $this->s";
		
		$results = $this->executeQuery($query);
		
		$settings = array();
		
		while($data = $results->fetchRow(MDB2_FETCHMODE_ASSOC)) {
					$settings[$data[settings_name]] = $data[settings_value];
		}
		
				
		return new SystemSettings($settings);
				
	}
	
	
	/*
	* Insert a single row of category data
	* @param $Category object
	* @return Affected rows
	*
	*/	
	public function save($settings_data) {
				
		while(list($ind, $val) = each($settings_data)) {
		
			$query = "UPDATE $this->s SET settings_value = '$val' WHERE settings_name = '$ind'";
			$this->execute($query);
		}
		
				
	}
	
					
}