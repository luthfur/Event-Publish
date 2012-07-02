<?php

/*********************************************************
Time Sharp Event Publish

Data Paging Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class Pager  {
	
	protected $total;		// total items to be paged
	protected $current;		// current page
	protected $per_page;	// number of items per page
	

	function __construct($total_items, $current_page, $per_page) {

		$this->total = $total_items;
		$this->current = (($current_page) ? $current_page : 1 );
		$this->per_page = $per_page;
	}	
		
	
	public function getNav() {
		
		$start_page_nav = $this->getStartNav();
		$total_pages = $this->getTotalPages();
		$page_nav = array();	
				
		$pg = 0;	
		
		// create the navigation pages:
		for($i=1; $i<11; $i++) {
			
			$pg = $start_page_nav + $i;
			
			if($pg > $total_pages) break;
				
			$page_nav[]	= $pg;
			
		}
		
		return $page_nav;
		
	}
	
	
	public function getCurrentPage() {
		return $this->current;			
	}
	
	
	public function getNextPage() {
		$page = $this->current + 1;		
		
		if($page <= $this->getTotalPages()) return $page;
		
		return 0;		
	}
	
	
	
	public function getPrevPage() {
		return $this->current - 1;
	}
	
	
	
	
	public function getTotalPages() {
		return ceil($this->total / $this->per_page); 
	}
	
	
	
	
	public function getFirstPointer() {
					
		return ($this->current * $this->per_page) - $this->per_page;
			
	}
	
		
	
	public function jumpForward() {
		$nav = $this->getNav();
		
		if($nav[count($nav) -1] < $this->getTotalPages()) return $nav[count($nav) -1] + 1;		
		
		return 0;	
	}
		
		
		
	public function jumpBack() {
		
		$nav = $this->getNav();
		
		return $nav[0] - 1;	
		
	}	
	
	
	private function getStartNav() {
		
		// calculate start of navigation
		$calc = $this->current / 10;
		$calc_array = explode(".", $calc);
		
		$val = $calc_array[0];
		$rem = $calc_array[1];
		
		if($rem == 0) {
			return ($val * 10) - 10;
		}
				
		$calc = floor($calc);
		
		return $calc * 10;
				
	}			
}