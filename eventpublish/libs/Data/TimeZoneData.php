<?php

/*********************************************************
Time Sharp Event Publish

TimeZone Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class TimeZoneData extends DataAccess  {
	
	private $tz;		// time zone table name
		

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;

		$this->tz = TIMEZONE_TABLE;		// timezone table
			
	}	
	
	
	/*
	* Get a single list of time zone data
	* @param $timezone_id
	* @return Resultset
	*
	*/	
	public function getList() {
				
		$query = "SELECT * FROM $this->tz ORDER BY tzid ASC";
		
		$tz = array();
		
		$tz_results = $this->executeQuery($query);
		
		$counter = 0;
		
		while ($tz_data = $tz_results->fetchRow("MDB2_FETCH_ASSOC")) {
			
			$tz[$counter][0] = $tz_data[0];
			
			// need to trim since tz data in db contains \n
			$tz[$counter][1] = trim($tz_data[1]);
			
			$counter++;
		}
		
		return $tz;
		
				
	}
			
					
}