<?php

/*********************************************************
Time Sharp Scheduling Engine

DaySchedule Class - Container for all scheduleitem in 
a day.

Developed by Luthfur Rahman Chowdhury

July 13, 2006
**********************************************************/


class DaySchedule  {

	private $day;				// Day of the month
	private $month;				// Month of the year
	private $year;				// Year
	private $timezone;			// time zone to which this schedule beongs to
	private $weekend;			// the first weekend 
	private $ScheduleItems;		// holds the schedule items belonging to this day
	private $NoTimeItems;		// holds the schedule items belonging to this day that has no time specified



	function __construct($d, $m, $y,  $weekend, $timezone, $DataSet=null) {
				
		$this->day = $d;
		$this->month = $m;
		$this->year = $y;
		$this->weekend = $weekend;
		$this->timezone = $timezone;
		$this->ScheduleItems = array();
		$this->NoTimeItems = array();
		
		//$this->ScheduleItems[0] = null;
		//$this->NoTimeItems[0] = null;
		
		if($DataSet) $this->insert($DataSet);	
		
	}	
	
	
	/*
	* Inserts all schedule data in the Schedules container.
	* 
	* @param ItemSet containing schedule data
	*/
	private function insert($DataSet) {
		
		while (list($ind, $ItemData) = each($DataSet)) {
			
			$DataStartDate = $ItemData->getStartDate();
			$DataStopDate = $ItemData->getStopDate();
						
			$thisDate = $this->getDate();
			
			if($thisDate->compareDate($DataStartDate) >= 0 && $thisDate->compareDate($DataStopDate) <= 0) {
								
				switch ($ItemData->getType()) {
						
						// Single day event check
						case 1:
							
							$this->addOneDayItem($ItemData, $DataStartDate, $DataStopDate);	
							break;					
						
						// Every day event check										
						case 2:
							
							$this->addEveryDayItem($ItemData, $DataStartDate, $DataStopDate);	
							break;
						
						// Every TUE THU check
						case 3:
							
							// get the day of week set
							$set = Utilities::getTueThuArray($ItemData, $DataStartDate);
								
							$this->addMultipleWeekItem($ItemData, $DataStartDate, $DataStopDate, $set);	
							break;
						
						// Every MON WED FRI check
						case 4:
							
							// get the day of week set
							$set = Utilities::getMonWedFriArray($ItemData, $DataStartDate);	
												
							$this->addMultipleWeekItem($ItemData, $DataStartDate, $DataStopDate, $set);	
							break;
						
						// Every Weekday check
						case 5:
							
							// get the day of week set
							$set = Utilities::getWeekdayArray($ItemData, $DataStartDate, $this->weekend);	
												
							$this->addMultipleWeekItem($ItemData, $DataStartDate, $DataStopDate, $set);	
							break;
						
						// Every Weekend check
						case 6:
														
							// get the day of week set
							$set = Utilities::getWeekendArray($ItemData, $DataStartDate, $this->weekend);	
												
							$this->addMultipleWeekItem($ItemData, $DataStartDate, $DataStopDate, $set);	
							break;
						
						// Every Week check
						case 7:
							
							$this->addWeekItem($ItemData, $DataStartDate, $DataStopDate);	
							break;
						
						// Every other week check
						case 8:
						
							$this->addEveryOtherWeekItem($ItemData, $DataStartDate, $DataStopDate);	
							break;
						
						// Every month check
						case 9:
						
							$this->addMonthItem($ItemData, $DataStartDate, $DataStopDate);	
							break;
						
						
						// Every year check
						case 10:
							
							$this->addYearItem($ItemData, $DataStartDate, $DataStopDate);	
							break;					
						
						// Every Monthly periodical check
						case 11:
							
							$this->addMonthlyPeriodicItem($ItemData, $DataStartDate, $DataStopDate);	
							break;
						
						// Every yearly periodical check	
						case 12:
														
							$this->addYearlyPeriodicItem($ItemData, $DataStartDate, $DataStopDate);	
							break;
							
					}	// end switch
			} 
			
		}	// End item data iteration
		
		
	}
	
	
	
	/*
	* @return the schedule item container array
	*/
	public function getItems() {
		
		$ItemSorter = new ItemSorter($this->ScheduleItems);
	
		return $ItemSorter->sort();
		
	}
	
		
	
	/*
	* @return the schedule item container array for no time items
	*/
	public function getNoTimeItems() {
		return $this->NoTimeItems;
	}
	
	
	/*
	* @param scheduleitem to be inserted
	*/
	public function addItem($Item) {
		
		$this->ScheduleItems[] = $Item;
	}
	
		
	
		/*
	* @param scheduleitem to be inserted
	*/
	public function addNoTimeItem($Item) {
		
		$this->NoTimeItems[] = $Item;
	}
	
		
	
	/*
	* @false if DaySchedule is empty, true if not
	*/
	public function hasItems() {
		
		return (((count($this->ScheduleItems) + count($this->NoTimeItems)) != 0) ? 1 : 0);
	}
	
	
	/*
	* @return the DateTime object for this day
	*/
	public function getDate() {
		return new SC_DateTime($this->day, $this->month, $this->year);
	}
	
	
	/*
	* @return the timezone of this schedule
	*/
	public function getTimeZone() {
		return $this->timezone;
	}
	
	
	
	
	/*
	*
	* Add one day item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*/
	private function addOneDayItem($ItemData, $DataStartDate, $DataStopDate) {
		
		// create current day with start time
		$StartTime = new SC_DateTime($DataStartDate->getDay(), $DataStartDate->getMonth(), $DataStartDate->getYear(), $DataStartDate->getHour(), $DataStartDate->getMinute()); 
			
		// create next or current day with stop time
		$StopTime = new SC_DateTime($DataStopDate->getDay(), $DataStopDate->getMonth(), $DataStopDate->getYear(), $DataStopDate->getHour(), $DataStopDate->getMinute());
				
		// Create the schedule item
		$Item = new ScheduleItem($StartTime->getTimeStamp(), $StopTime->getTimeStamp(), $ItemData->getTimeSpec(), $ItemData->getDetails());
				
		$thisDate = $this->getDate();
		
		if($DataStartDate->getDay() == $thisDate->getDay() || $DataStopDate->getDay() == $thisDate->getDay()) {
			
			// Check if time has been specified	
			if($ItemData->getTimeSpec()) {
				$this->addItem($Item);
			} else {
				$this->addNoTimeItem($Item);
			} 
						
		}
			
	}
	
	
	
	
	/*
	*
	* Add an every day item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*/
	private function addEveryDayItem($ItemData, $DataStartDate, $DataStopDate) {
		
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			$DatePointer = $this->getDate();
			$DatePointer->removeDay(1);
			
			if($DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				
				$this->addItem($Item);
				
			}
			
			$thisDate = $this->getDate();
			
			if($thisDate->compareDate($DataStartDate) >= 0 && $thisDate->compareDate($DataStopDate) < 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
				
				$this->addItem($Item);
				
			}
			
		
		} else {
		
			// create the item
			$Item = Utilities::createItem($ItemData, $this->getDate(), $this->timezone, 0);
			
			// Check if time has been specified	
			if($ItemData->getTimeSpec()) {
				$this->addItem($Item);
			} else {
				$this->addNoTimeItem($Item);
			} 				
			
		}
		
		
		
	}
	
	
	
	
	/*
	*
	* Add a Set of weekly item
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	* @param set containing the days of week
	*
	*/	
	private function addMultipleWeekItem($ItemData, $DataStartDate, $DataStopDate, $set) {
	
		// add items to each day of week
		while(list($ind, $start_day) = each($set)) {
			
			// add item to the week
			$this->addWeekly($ItemData, $DataStartDate, $DataStopDate, $start_day, $stop_day);		
		
		}
	
	}
	
	
	
	
	/*
	*
	* Add a weekly recurring item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*
	*/		
	private function addWeekItem($ItemData, $DataStartDate, $DataStopDate) {
									
		$start_day = $DataStartDate->getDayOfWeek();
			
		$this->addWeekly($ItemData, $DataStartDate, $DataStopDate, $start_day);		
			
	
	}	
	
	
	
	
	/*
	*
	* Helper Method Add a weekly item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	* @param start day of the week
	* @param stop day of the week
	*
	*/
	
	private function addWeekly($ItemData, $DataStartDate, $DataStopDate, $start_day) {
		
		$stop_day = (($DataStartDate->compareTime($DataStopDate) > 0) ? (($start_day + 1) % 7) : $start_day );	
		
		// if this day or previous day is doesnot have an item return		
		$DatePointer = $this->getDate();
				
		if($DatePointer->getDayOfWeek() != $start_day) {
						
			if($start_day == $stop_day) return;
			
			$DatePointer->removeDay(1);
			
			if($DatePointer->getDayOfWeek() != $start_day) return;
			
		}
				
								
		if ($DatePointer->compareDate($DataStartDate) >= 0) {
			
			// check if cross day	
			if($start_day != $stop_day && $DatePointer->compareDate($DataStopDate) < 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				
				$this->addItem($Item);
				
				return;
				
			} else if($start_day == $stop_day && $DatePointer->compareDate($DataStopDate) <= 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 0);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->addItem($Item);
				} else {
					$this->addNoTimeItem($Item);
				} 	
			
			} // end cross day if
		
		} 	// end if	
		
	}	
	
	
	
	/*
	*
	* Add an every other week recurring item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*
	*/	
	private function addEveryOtherWeekItem($ItemData, $DataStartDate, $DataStopDate) {
		
		$start_day = $DataStartDate->getDayOfWeek();
		$stop_day = (($DataStartDate->compareTime($DataStopDate) > 0) ? (($start_day + 1) % 7) : $start_day );
		
		$DatePointer = $this->getDate();
						
		if ($DatePointer->getDayOfWeek() == $start_day && Utilities::checkEveryOtherWeek($DataStartDate, $DatePointer)) {
			
			// check if cross day	
			if($DataStartDate->compareTime($DataStopDate) > 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				
				$this->addItem($Item);
				
				return;
				
			} else {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 0);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->addItem($Item);
				} else {
					$this->addNoTimeItem($Item);
				} 	
			
			}
		
		// check for cross day spill in	
		} else if($DataStartDate->compareTime($DataStopDate) > 0 && $DatePointer->getDayOfWeek() == $stop_day ) {
			
			$DatePointer->removeDay(1);
			
			if(Utilities::checkEveryOtherWeek($DataStartDate, $DatePointer)) {
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					
				$this->addItem($Item);
				
			}
		
		}
	
	}
	
	
	
	/*
	*
	* Add a monthly recurring item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*
	*/		
	private function addMonthItem($ItemData, $DataStartDate, $DataStopDate) {
			
		$DatePointer = $this->getDate();
		$ShiftedDate = $DatePointer;
		
		// shift DatePointer to the original timezone for day of month comparisons
		if($ItemData->getTimeSpec()) {
			$ShiftedDate = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
		}	
						
		if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay()) {
					
			// check if cross day	
			if($DataStartDate->compareTime($DataStopDate) > 0) {
												
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				
				$this->addItem($Item);
				
				return;
				
			} else {
							
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 0);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->addItem($Item);
				} else {
					$this->addNoTimeItem($Item);
				} 	
			
			}
		
		// check for cross day spill in	
		} else if ($DataStartDate->compareTime($DataStopDate) > 0) {
			
			$DatePointer->removeDay(1);
			
			$ShiftedDate = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
			
			if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay()) {
		
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					
				$this->addItem($Item);
			
			}
		
		}
	
	}
	
	
	
	/*
	*
	* Add a yearly recurring item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*
	*/	
	private function addYearItem($ItemData, $DataStartDate, $DataStopDate) {
	
		$DatePointer = $this->getDate();
		
		if ($DatePointer->getMonth() == $DataStartDate->getMonth() && $DatePointer->getDay() == $DataStartDate->getDay()) {
			
			// check if cross day	
			if($DataStartDate->compareTime($DataStopDate) > 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				
				$this->addItem($Item);
				
				return;
				
			} else {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 0);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->addItem($Item);
				} else {
					$this->addNoTimeItem($Item);
				} 	
			
			}
		
		// check for cross day spill in	
		} else if ($DataStartDate->compareTime($DataStopDate) > 0)  {
			
			$DatePointer->removeDay(1);
			
			if ($DatePointer->getMonth() == $DataStartDate->getMonth() && $DatePointer->getDay() == $DataStartDate->getDay()) {
		
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					
				$this->addItem($Item);
			
			}
		
		}
	}
	
	
	
	
		/*
	*
	* Add a monthly periodic recurring item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*
	*/
	
	private function addMonthlyPeriodicItem($ItemData, $DataStartDate, $DataStopDate) {
		
		
		$start_day = $DataStartDate->getDayOfWeek();
		$stop_day = (($DataStartDate->compareTime($DataStopDate) > 0) ? (($start_day + 1) % 7) : $start_day );
		
		$DatePointer = $this->getDate();
				
		// to prevent check periodic from shifting time for non time items
		$timezone = 0;
		if($ItemData->getTimeSpec()) $timezone = $this->timezone;
		
		if ($DatePointer->getDayOfWeek() == $start_day && Utilities::CheckPeriodic($ItemData->getStartDate(), $DatePointer, $timezone, $ItemData->getOriginalTimeZone())) {
			
			// check if cross day	
			if($DataStartDate->compareTime($DataStopDate) > 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $timezone, 1);
				
				$this->addItem($Item);
				
				return;
				
			} else {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $timezone, 0);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->addItem($Item);
				} else {
					$this->addNoTimeItem($Item);
				} 	
			
			}
		
		// check for cross day spill in	
		} else if ($DataStartDate->compareTime($DataStopDate) > 0)  {
			
			$DatePointer->removeDay(1);
			
			if ($DatePointer->getDayOfWeek() == $start_day && Utilities::CheckPeriodic($ItemData->getStartDate(), $DatePointer, $this->timezone, $ItemData->getOriginalTimeZone())) {
		
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					
				$this->addItem($Item);
			
			}
		
		}
		
	}
	
	
	
	
	/*
	*
	* Add a yearly periodic recurring item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*
	*/
	private function addYearlyPeriodicItem($ItemData, $DataStartDate, $DataStopDate) {
		
		$start_day = $DataStartDate->getDayOfWeek();
		$stop_day = (($DataStartDate->compareTime($DataStopDate) > 0) ? (($start_day + 1) % 7) : $start_day );
				
		$DatePointer = $this->getDate();
		$ShiftedDate = $DatePointer;
		$CompStartDate = $DataStartDate;		// for month comparison
		$timezone = 0;
		
		// shift thisDate to the original timezone for month comparisons
		if($ItemData->getTimeSpec()) {
			$timezone = $this->timezone;  // to prevent check periodic from shifting time for non time items
			$ShiftedDate = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
			$CompStartDate = $ItemData->getStartDate(); // for month comparison
		}	
								
		if ($DatePointer->getDayOfWeek() == $start_day && $CompStartDate->getMonth() == $ShiftedDate->getMonth() && Utilities::CheckPeriodic($ItemData->getStartDate(), $DatePointer, $timezone, $ItemData->getOriginalTimeZone())) {
			
		
			// check if cross day	
			if($DataStartDate->compareTime($DataStopDate) > 0) {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $timezone, 1);
				
				$this->addItem($Item);
				
				return;
				
			} else {
				
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $timezone, 0);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->addItem($Item);
				} else {
					$this->addNoTimeItem($Item);
				} 	
			
			}
		
		// check for cross day spill in	
		} else if ($DataStartDate->compareTime($DataStopDate) > 0)  {
			
			$DatePointer->removeDay(1);
			
			// shift datepointer to the original timezone for month comparisons
			$ShiftedDate = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
		
			if ($DatePointer->getDayOfWeek() == $start_day && $ItemData->getStartDate()->getMonth() == $ShiftedDate->getMonth() && Utilities::CheckPeriodic($ItemData->getStartDate(), $DatePointer, $this->timezone, $ItemData->getOriginalTimeZone())) {
		
				// create the item
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					
				$this->addItem($Item);
			
			}
		
		}
		
		
	}
	
	
	
	

}