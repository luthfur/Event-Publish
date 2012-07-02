<?php

/*********************************************************
Time Sharp Event Publish

Event Data Paging Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class EventPager extends Pager  {
		
	private $DataSet;		// the Event Data set

	function __construct($DataSet, $current_page, $per_page) {

		$this->total = count($DataSet);
		$this->current = (($current_page) ? $current_page : 1 );
		$this->per_page = $per_page; 
		$this->DataSet = $DataSet;
				
	}		
	
	
	function getData() {
	
		return array_splice($this->DataSet, $this->getFirstPointer(), $this->per_page); 
	
	}
				
}