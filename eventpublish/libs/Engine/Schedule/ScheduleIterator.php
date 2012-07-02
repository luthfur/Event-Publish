<?php

/*********************************************************
Time Sharp Scheduling Engine

ScheduleIterator Class - Iterates through a set of schedule items

Developed by Luthfur Rahman Chowdhury

September 19, 2006
**********************************************************/


class ScheduleIterator  {

	private $Schedules;			// ShecheduleItem array		
	private $pointer;
	private $size;
	
	
	function __construct($sched) {	
	
		$this->Schedules = $sched;
		$this->size = count($sched);
		
		$this->reset();
	
	}
	
	
	public function reset() {
	
		$this->pointer = -1;
	
	}
	
	
	public function next() {
		
		$this->pointer++;
		
		if($this->pointer < $this->size) return $this->Schedules[$this->pointer];
			
	}


}