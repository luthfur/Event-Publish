<?php

/*********************************************************
Time Sharp Scheduling Engine

MonthSchedule Class - Container for all scheduleitem belonging 
to a given month.

Developed by Luthfur Rahman Chowdhury

July 13, 2006
**********************************************************/


class MonthSchedule  {

	private $Month;				// Month object for this month
	private $Schedules;			// DaySchedule array		
	private $timezone;
	private $weekend;


	function __construct($m, $y, $timezone, $weekend, $DataSet) {
		
		$this->Month = new Month($m, $y);
		$this->timezone = $timezone;
		$this->weekend = $weekend;
			
		$this->Schedules = array();
		
		$Iterator = $this->Month->getDateIterator();
			
		// initlialize schedule containers
		while($thisDate = $Iterator->nextDay()) {
				
			$this->Schedules[] = new DaySchedule($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(), $this->weekend, $this->timezone);
						
		}
		
		$this->insert($DataSet);
		
	}	
	
	
		
	
	/*
	* Inserts all schedule data in the Schedules container.
	* 
	* Arranges Items in chronological order
	* 
	* @param DataSet containing schedule data
	*/
	private function insert($DataSet) {
		
		while (list($ind, $ItemData) = each($DataSet)) {
			
			// Check if time has been specified			
			if($ItemData->getTimeSpec()) {
										
				// shift data start date to current timezone
				$DataStartDate = Utilities::shiftTime($ItemData->getStartDate(), 0, $this->timezone);
				$DataStopDate = Utilities::shiftTime($ItemData->getStopDate(), 0, $this->timezone);
				
			} else {
			
				$DataStartDate = $ItemData->getStartDate();
				$DataStopDate = $ItemData->getStopDate();
			
			}
			
			
			$MonthStartDate = new SC_DateTime(1,$this->Month->getMonthOfYear(), $this->Month->getYear());
			$MonthStopDate = new SC_DateTime($this->Month->getDaysInMonth(),$this->Month->getMonthOfYear(), $this->Month->getYear());
		
			
			if($DataStartDate->compareDate($MonthStopDate) <= 0 && $DataStopDate->compareDate($MonthStartDate) >= 0) {
				
								
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
			
		} 	
	
	}
	
	
	
	/*
	* @return ScheduleIterator for this schedule
	*/
	public function getIterator() {
		return new ScheduleIterator($this->Schedules);
	}
	
		
	
	/*
	* @param day
	* @param month
	* @param year
	*  
	* @return the schedule item container array
	*/
	public function getItemsByDate($d) {
	
		if($d <= $this->Month->getDaysInMonth() && $d >= 1) return $this->Schedules[$d - 1];
		
		return null;
	}
	
	
	
	/*
	* @return the Month object
	*/
	public function getMonth() {
		return $this->Month;
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
	
		if($DataStartDate->getMonth() == $this->Month->getMonthOfYear()) {
		
			// create current day with start time
			$StartTime = new SC_DateTime($DataStartDate->getDay(), $DataStartDate->getMonth(), $DataStartDate->getYear(), $DataStartDate->getHour(), $DataStartDate->getMinute()); 
			
			// create next or current day with stop time
			$StopTime = new SC_DateTime($DataStopDate->getDay(), $DataStopDate->getMonth(), $DataStopDate->getYear(), $DataStopDate->getHour(), $DataStopDate->getMinute());
			
			// Create the schedule item
			$Item = new ScheduleItem($StartTime->getTimeStamp(), $StopTime->getTimeStamp(), $ItemData->getTimeSpec(), $ItemData->getDetails());
			
			// Check if time has been specified	
			if($ItemData->getTimeSpec()) {
				$this->Schedules[$DataStartDate->getDay() - 1]->addItem($Item);
			} else {
				$this->Schedules[$DataStartDate->getDay() - 1]->addNoTimeItem($Item);
				return;
			} 
			
			
			// deal with cross day items
			if($DataStartDate->compareDate($DataStopDate) != 0 && $DataStopDate->getMonth() == $this->Month->getMonthOfYear()) {
			
				$this->Schedules[$DataStopDate->getDay() - 1]->addItem($Item);
					
			}
			
		
		// deal with cross day spill in
		} else if ($DataStopDate->getMonth() == $this->Month->getMonthOfYear()) {
			
			// create current day with start time
			$StartTime = new SC_DateTime($DataStartDate->getDay(), $DataStartDate->getMonth(), $DataStartDate->getYear(), $DataStartDate->getHour(), $DataStartDate->getMinute()); 
			
			// create next or current day with stop time
			$StopTime = new SC_DateTime($DataStopDate->getDay(), $DataStopDate->getMonth(), $DataStopDate->getYear(), $DataStopDate->getHour(), $DataStopDate->getMinute());
			
			// Create the schedule item
			$Item = new ScheduleItem($StartTime->getTimeStamp(), $StopTime->getTimeStamp(), $ItemData->getTimeSpec(), $ItemData->getDetails());
			
			$this->Schedules[0]->addItem($Item);
			
			
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
	
		$DatePointer = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
			
		while($DatePointer->compareDate($DataStopDate) <= 0 && $DatePointer->getMonth() == $this->Month->getMonthOfYear()) {
			
			// check if cross day	
			if($DataStartDate->compareTime($DataStopDate) > 0) {
			
				$PrevDate = new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear());
				$PrevDate->removeDay(1);
				
				if($PrevDate->compareDate($DataStartDate) >= 0) {
									
					// create and add item to the previous day
					$Item = Utilities::createItem($ItemData, $PrevDate, $this->timezone, 1);
					
					// add item to the current day
					$this->Schedules[$DatePointer->getDay() - 1]->addItem($Item);
					
				}
				
				
				if($DatePointer->compareDate($DataStopDate) < 0 && $DatePointer->compareDate($DataStartDate) >= 0) {
										
					// create and add item to this day
					$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					
					// add item to the current day
					$this->Schedules[$DatePointer->getDay() - 1]->addItem($Item);
					
				}
			
			
			// deal with regular item
			} else if($DatePointer->compareDate($DataStartDate) >= 0) {
				
				// create and add item to the previous day
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone);
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->Schedules[$DatePointer->getDay() - 1]->addItem($Item);
				} else {
					$this->Schedules[$DatePointer->getDay() - 1]->addNoTimeItem($Item);
				} 
			
			}
			
			$DatePointer->addDay(1);
			
		} // end while
	
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
		
		$DateLooper = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
	
		// loop until stop day of week is reached		
		while ($DateLooper->getDayOfWeek() != $stop_day) $DateLooper->addDay(1);
		
		
			
		// check if cross day	
		if($start_day != $stop_day) {
		
			$LastDayOfMonth = new SC_DateTime($this->Month->getDaysInMonth(), $this->Month->getMonthOfYear(), $this->Month->getYear());
			
			// move date looper to the start day
			$DateLooper->removeDay(1);
		
			while ($DateLooper->compareDate($DataStopDate) < 0 && $DateLooper->compareDate($LastDayOfMonth) <= 0) {
							
				$DatePointer = new SC_DateTime($DateLooper->getDay(), $DateLooper->getMonth(), $DateLooper->getYear());
				
				// save the stop day
				$DatePointer->addDay(1);
				
				if($DatePointer->compareDate($DataStartDate) > 0) {
				
					$Item = Utilities::createItem($ItemData, $DateLooper, $this->timezone, 1);
					
					if($DatePointer->getMonth() == $this->Month->getMonthOfYear())	$this->Schedules[$DatePointer->getDay() - 1]->addItem($Item);
					
					if($DateLooper->getMonth() == $this->Month->getMonthOfYear())	$this->Schedules[$DateLooper->getDay() - 1]->addItem($Item);
				
				}
				
				$DateLooper->addWeek(1);
				
			}	// end while
					
			
		} else {
		
			while ($DateLooper->compareDate($DataStopDate) <= 0 && ($DateLooper->getMonth() == $this->Month->getMonthOfYear())) {
				
				$Item = Utilities::createItem($ItemData, $DateLooper, $this->timezone);
				
				if($DateLooper->compareDate($DataStartDate) >= 0) {
					// Check if time has been specified	
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$DateLooper->getDay() - 1]->addItem($Item);
					} else {
						$this->Schedules[$DateLooper->getDay() - 1]->addNoTimeItem($Item);
					} 
					
				}
								
				$DateLooper->addWeek(1);
				
			}	// end while
		
		}// end if 
		
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
	
		$DateStartLooper = new SC_DateTime($DataStartDate->getDay(), $DataStartDate->getMonth(), $DataStartDate->getYear());
		$DateStopLooper = new SC_DateTime($DataStartDate->getDay(), $DataStartDate->getMonth(), $DataStartDate->getYear());
		
		$FirstDayOfMonth = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		if($DataStartDate->compareTime($DataStopDate) > 0) $DateStopLooper->addDay(1);
				
		while ($DateStartLooper->compareDate($FirstDayOfMonth) < 0 && $DateStopLooper->compareDate($FirstDayOfMonth) < 0 && $DateStartLooper->compareDate($DataStopDate) < 0) {
			
			$DateStartLooper->addWeek(2);
			$DateStopLooper->addWeek(2);
						
		}
		
		
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			$LastDayOfMonth = new SC_DateTime($this->Month->getDaysInMonth(), $this->Month->getMonthOfYear(), $this->Month->getYear());
			
			while ($DateStartLooper->compareDate($DataStopDate) < 0 && $DateStartLooper->compareDate($LastDayOfMonth) <= 0) {
				
				if($DateStartLooper->compareDate($DataStartDate) >= 0) {
				
					$Item = Utilities::createItem($ItemData, $DateStartLooper, $this->timezone,1);
					
					if($DateStartLooper->getMonth() == $this->Month->getMonthOfYear()) $this->Schedules[$DateStartLooper->getDay() - 1]->addItem($Item);
					
					if($DateStopLooper->getMonth() == $this->Month->getMonthOfYear()) $this->Schedules[$DateStopLooper->getDay() - 1]->addItem($Item);
									
				}
				
				$DateStartLooper->addWeek(2);
				$DateStopLooper->addWeek(2);
				
			
			}	// end while
		
		} else {
			
			while ($DateStartLooper->compareDate($DataStopDate) <= 0 && $DateStartLooper->getMonth() == $this->Month->getMonthOfYear()) {
				
				if($DateStartLooper->compareDate($DataStartDate) >= 0) {
				
					$Item = Utilities::createItem($ItemData, $DateStartLooper, $this->timezone);
					
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$DateStartLooper->getDay() - 1]->addItem($Item);
					} else {
						$this->Schedules[$DateStartLooper->getDay() - 1]->addNoTimeItem($Item);
					} 
					
				}
				
				$DateStartLooper->addWeek(2);
							
			} // end while
		
		}	// end if
	
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
			
		$LastDayOfMonth = new SC_DateTime($this->Month->getDaysInMonth(), $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			// loop through each day in month
			for($i=1; $i<=$this->Month->getDaysInMonth(); $i++) {
				
				$thisDate = new SC_DateTime($i, $this->Month->getMonthOfYear(), $this->Month->getYear());
				
				// shift DatePointer to the original timezone for day of month comparisons
				$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
																			
				if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay() && $thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0) {
					
					// create and add item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
					$this->Schedules[$i - 1]->addItem($Item);
					
					
					// if the next day is within week, add item 
					if ($Item->getStopTime()->compareDate($LastDayOfMonth) <= 0) $this->Schedules[$i]->addItem($Item);
					
				}
				
				
			}
			
			// check for spills from previous week					
			$DatePointer = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
				
			$DatePointer->removeDay(1);
			
			// shift DatePointer to the original timezone for day of month comparisons
			$DateCompare = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
							
			if($ItemData->getStartDate()->getDay() == $DateCompare->getDay() && $DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
					
			}
		
		} else {
			
			// loop through each day in month
			for($i=1; $i<=$this->Month->getDaysInMonth(); $i++) {
				
				$thisDate = new SC_DateTime($i, $this->Month->getMonthOfYear(), $this->Month->getYear());
									
				$ShiftedDate = $thisDate;
		
				// shift DatePointer to the original timezone for day of month comparisons
				if($ItemData->getTimeSpec()) {
					$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
				}
															
				if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay() && $thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0) {
													
					// create and add item					
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
					
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$i - 1]->addItem($Item);
					} else {
						$this->Schedules[$i - 1]->addNoTimeItem($Item);
					}
										
				}
				
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
		
		
		$LastDayOfMonth = new SC_DateTime($this->Month->getDaysInMonth(), $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			// loop through each day in month
			for($i=1; $i<=$this->Month->getDaysInMonth(); $i++) {
				
				$thisDate = new SC_DateTime($i, $this->Month->getMonthOfYear(), $this->Month->getYear());
				
				// shift DatePointer to the original timezone for day of month comparisons
				$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
																			
				if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay() && $ShiftedDate->getMonth() == $ItemData->getStartDate()->getMonth() && $thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0) {
					
					// create and add item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
					$this->Schedules[$i - 1]->addItem($Item);
					
					
					// if the next day is within week, add item 
					if ($Item->getStopTime()->compareDate($LastDayOfMonth) <= 0) $this->Schedules[$i]->addItem($Item);
					
				}
				
				
			}
			
			// check for spills from previous week					
			$DatePointer = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
				
			$DatePointer->removeDay(1);
			
			// shift DatePointer to the original timezone for day of month comparisons
			$DateCompare = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
							
			if($ItemData->getStartDate()->getDay() == $DateCompare->getDay()  && $DateCompare->getMonth() == $ItemData->getStartDate()->getMonth()  && $DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
					
			}
		
		} else {
			
			// loop through each day in month
			for($i=1; $i<=$this->Month->getDaysInMonth(); $i++) {
				
				$thisDate = new SC_DateTime($i, $this->Month->getMonthOfYear(), $this->Month->getYear());
									
				$ShiftedDate = $thisDate;
		
				// shift DatePointer to the original timezone for day of month comparisons
				if($ItemData->getTimeSpec()) {
					$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
				}
															
				if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay()  && $ShiftedDate->getMonth() == $ItemData->getStartDate()->getMonth()  && $thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0) {
													
					// create and add item					
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
					
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$i - 1]->addItem($Item);
					} else {
						$this->Schedules[$i - 1]->addNoTimeItem($Item);
					}
										
				}
				
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
				
		$DateLooper = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		$LastDayOfMonth = new SC_DateTime($this->Month->getDaysInMonth(), $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		while($DateLooper->getDayOfWeek() != $DataStartDate->getDayOfWeek()) $DateLooper->addDay(1);
				
		
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			$DateLooper->removeWeek(1);		
			$DatePointer = new SC_DateTime($DateLooper->getDay(), $DateLooper->getMonth(), $DateLooper->getYear() );
			$DatePointer->addDay(1);
			
			while ($DateLooper->compareDate($LastDayOfMonth) <= 0 && $DateLooper->compareDate($DataStopDate) < 0) {
												
				if(Utilities::CheckPeriodic($ItemData->getStartDate(), $DateLooper, $this->timezone, $ItemData->getOriginalTimeZone()) && $DateLooper->compareDate($DataStartDate) >= 0) {
					
					$Item = Utilities::createItem($ItemData, $DateLooper, $this->timezone, 1);
										
					if($DateLooper->getMonth() == $this->Month->getMonthOfYear()) $this->Schedules[$DateLooper->getDay() - 1]->addItem($Item);
					
					if($DatePointer->getMonth() == $this->Month->getMonthOfYear()) $this->Schedules[$DatePointer->getDay() - 1]->addItem($Item);
					
				}			
				
				$DateLooper->addWeek(1);
				$DatePointer->addWeek(1);
				
			}								
		
		} else {
						
			while ($DateLooper->compareDate($LastDayOfMonth) <= 0 && $DateLooper->compareDate($DataStopDate) <= 0) {
						
				if(Utilities::CheckPeriodic($ItemData->getStartDate(), $DateLooper, $this->timezone, $ItemData->getOriginalTimeZone()) && $DateLooper->compareDate($DataStartDate) >= 0) {
							
					$Item = Utilities::createItem($ItemData, $DateLooper, $this->timezone);
			
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$DateLooper->getDay() - 1]->addItem($Item);
					} else {
						$this->Schedules[$DateLooper->getDay() - 1]->addNoTimeItem($Item);
					} 
						
				}
				
				$DateLooper->addWeek(1);
			
			} // end while
					
		
		} // end if
		
	
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
		
		$DateLooper = new SC_DateTime(1, $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		$LastDayOfMonth = new SC_DateTime($this->Month->getDaysInMonth(), $this->Month->getMonthOfYear(), $this->Month->getYear());
		
		while($DateLooper->getDayOfWeek() != $DataStartDate->getDayOfWeek()) $DateLooper->addDay(1);
					
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
		
			$DateLooper->removeWeek(1);	
			$DatePointer = new SC_DateTime($DateLooper->getDay(), $DateLooper->getMonth(), $DateLooper->getYear() );
			$DatePointer->addDay(1);
				
			while ($DateLooper->compareDate($LastDayOfMonth) <= 0 && $DateLooper->compareDate($DataStopDate) < 0) {
			
				
				// shift thisDate to the original timezone for month comparisons
				$ShiftedDate = Utilities::shiftTime(new SC_DateTime($DateLooper->getDay(), $DateLooper->getMonth(), $DateLooper->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
													
				if($ItemData->getStartDate()->getMonth() == $ShiftedDate->getMonth() && Utilities::CheckPeriodic($ItemData->getStartDate(), $DateLooper, $this->timezone, $ItemData->getOriginalTimeZone()) && $DateLooper->compareDate($DataStartDate) >= 0) {
					
					$Item = Utilities::createItem($ItemData, $DateLooper, $this->timezone, 1);
										
					if($DateLooper->getMonth() == $this->Month->getMonthOfYear()) $this->Schedules[$DateLooper->getDay() - 1]->addItem($Item);
					
					if($DatePointer->getMonth() == $this->Month->getMonthOfYear()) $this->Schedules[$DatePointer->getDay() - 1]->addItem($Item);
				
				}			
				
				$DateLooper->addWeek(1);
				$DatePointer->addWeek(1);
			}
		
		} else {
		
			
			while ($DateLooper->compareDate($LastDayOfMonth) <= 0 && $DateLooper->compareDate($DataStopDate) <= 0) {
				
				$ShiftedDate = $DateLooper;
									
				// shift thisDate to the original timezone for month comparisons
				if($ItemData->getTimeSpec())  $ShiftedDate = Utilities::shiftTime(new SC_DateTime($DateLooper->getDay(), $DateLooper->getMonth(), $DateLooper->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
								
				if($ItemData->getStartDate()->getMonth() == $ShiftedDate->getMonth() && Utilities::CheckPeriodic($ItemData->getStartDate(), $DateLooper, $this->timezone, $ItemData->getOriginalTimeZone()) && $DateLooper->compareDate($DataStartDate) >= 0) {
					
					$Item = Utilities::createItem($ItemData, $DateLooper, $this->timezone);
			
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$DateLooper->getDay() - 1]->addItem($Item);
					} else {
						$this->Schedules[$DateLooper->getDay() - 1]->addNoTimeItem($Item);
					} 
						
				}
				
				$DateLooper->addWeek(1);
			
			} // end while
			
			
		
		} // end if
		
		
	}
		
	
	
}