<?php

/*********************************************************
Time Sharp Event Publish

Database Result Paging Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class ResultPager extends Pager  {
		
	private $Resultset;		// the Event Data set

	function __construct($Resultset, $current_page, $per_page) {

		$this->total = $Resultset->numRows();
		$this->current = (($current_page) ? $current_page : 1 );
		$this->per_page = $per_page; 
		$this->Resultset = $Resultset;
				
	}		
	
	
	public function getData() {
		
		$to = $this->getFirstPointer() + ($this->per_page - 1);
		
		$collector = array();
		
		foreach (range($this->getFirstPointer(), $to) as $rowNum) {
			if (!($row = $this->Resultset->fetchRow(MDB2_FETCHMODE_ASSOC, $rowNum))) {
				break;
			}
			$collector[] = $row;
		}
		
		return $collector;
	
	}
				
}