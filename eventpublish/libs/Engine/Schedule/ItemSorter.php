<?php

/*********************************************************
Time Sharp Scheduling Engine

Item Sort Class - Container that will sort the supplied schedule item.

Developed by Luthfur Rahman Chowdhury

September 26, 2006
**********************************************************/



class ItemSorter  {

	private $items; 		// items to be sorted
	private $size;			// total number of items

	/*
	* Constructor
	*
	* @param array of items
	*
	*/
	
	function __construct($items) {
				
		$this->items = $items;
		
		$this->size = count($items);
						
	}
	
	
	
	/*
	* Sort all the items in the heap
	*
	* @return sorted array of items
	*/
	public function sort() {
	
		$this->quickSort(0,$this->size - 1);
		
		return $this->items;
		
	}
	
	
	
	private function quickSort($p,$q) {
	
		if($p < $q) {
		
			$j = $this->partition($p, $q);
			$this->quickSort($p, $j - 1);
			$this->quickSort($j + 1, $q);
		
		}
		
	}
	
	
	private function partition($left,$right) {
	
		$pivotValue = $this->items[$left];
   		$this->swap($left, $right); // Move pivot to end
    
		$storeIndex = $left;
	 
		for($i=$left; $i<=$right - 1; $i++) {
						
			if($this->items[$i]->getStartTime()->compare($pivotValue->getStartTime()) <= 0) {
				$this->swap($storeIndex, $i);
				$storeIndex++;
			}
			
		}
		$this->swap($right, $storeIndex);	
		return $storeIndex;
			
	 }
	 
	 
	 
	private function swap($i,$j) {
		
		$p = $this->items[$i];
		$this->items[$i] = $this->items[$j];
		$this->items[$j] = $p;
	}
	
	
	
}

