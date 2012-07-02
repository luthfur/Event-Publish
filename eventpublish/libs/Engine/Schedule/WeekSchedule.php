<?php

/*********************************************************
Time Sharp Scheduling Engine

WeekSchedule Class - Container for all scheduleitem belonging 
to a given week.

Developed by Luthfur Rahman Chowdhury

July 13, 2006
**********************************************************/


class WeekSchedule  {

	private $Week;				// Week object for this week
	private $Schedules;			// DaySchedule array		
	private $timezone;
	private $weekend;


	
	

	function __construct($d, $m, $y, $start_day, $timezone, $weekend, $DataSet) {
		
		
		$this->Week = new Week($d, $m, $y, $start_day);
		$this->timezone = $timezone;
		$this->weekend = $weekend;
			
		$this->Schedules = array();
		
		$Iterator = $this->Week->getDateIterator();
		
		
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
			
			
			$WeekStartDate = $this->Week->getWeekOf();
			$WeekStopDate = $this->Week->getWeekOf();
			$WeekStopDate->addDay(6);
			
			if($DataStartDate->compareDate($WeekStopDate) <= 0 && $DataStopDate->compareDate($WeekStartDate) >= 0) {
								
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
	* @return the Week object
	*/
	public function getWeek() {
		return $this->Week;
	}
	
	
	/*
	* @return the timezone of this schedule
	*/
	public function getTimeZone() {
		return $this->timezone;
	}
	
	
	
	/*
	* @return ScheduleIterator for this schedule
	*/
	public function getIterator() {
		return new ScheduleIterator($this->Schedules);
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
	
		//  set pointer
		$pointer = 0;
						
		// initialize the week date iterator					
		$Iterator = $this->Week->getDateIterator();
		
		
		// loop through each day of the week		
		while($thisDate = $Iterator->nextDay()) {
											
			if($thisDate->compareDate($DataStartDate) == 0) {
				
				// create current day with start time
				$StartTime = new SC_DateTime($DataStartDate->getDay(), $DataStartDate->getMonth(), $DataStartDate->getYear(), $DataStartDate->getHour(), $DataStartDate->getMinute()); 
				
				// create next or current day with stop time
				$StopTime = new SC_DateTime($DataStopDate->getDay(), $DataStopDate->getMonth(), $DataStopDate->getYear(), $DataStopDate->getHour(), $DataStopDate->getMinute());
				
				// Create the schedule item
				$Item = new ScheduleItem($StartTime->getTimeStamp(), $StopTime->getTimeStamp(), $ItemData->getTimeSpec(), $ItemData->getDetails());
				
				// Check if time has been specified	
				if($ItemData->getTimeSpec()) {
					$this->Schedules[$pointer]->addItem($Item);
				} else {
					$this->Schedules[$pointer]->addNoTimeItem($Item);
					return;
				}
				
				// Handle cross day items
				if ($DataStartDate->compareDate($DataStopDate) != 0) {
					
					$thisDate->addDay(1);
			
					$WeekStopDate = $this->Week->getWeekOf();
					$WeekStopDate->addDay(6);
					
					if($thisDate->compareDate($WeekStopDate) <= 0) {
						
						$pointer++;	
						$this->Schedules[$pointer]->addItem($Item);								
					
					} 
				
				}
				
				break;
			
			}
			
			$pointer++;
				
		}
			
			
		// handle cross day items that may spill into the first day of the week
		if ($DataStartDate->compareDate($DataStopDate) != 0) {
			
			// pointer to the first day of the week
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
			
			$DatePointer->removeDay(1);
			
			if($DatePointer->compareDate($DataStartDate) == 0) {
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
			}
		
				
		}
		// End Cross day item handler
				
		
	}	// End One day item handler
	
	
	
	
	
	/*
	*
	* Add an every day item to the schedule
	*
	* @param ItemData
	* @param DataStartDate containing shifted time
	* @param DataStopDate containing shifted time
	*/
	private function addEveryDayItem($ItemData, $DataStartDate, $DataStopDate) {
				
		$pointer = 0;
				
		$Iterator = $this->Week->getDateIterator();
		
		// check if cross day	
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			// loop through the days of the week
			while($thisDate = $Iterator->nextDay()) {
				
				// check if date is within data range								
				if($thisDate->compareDate($DataStartDate) >= 0 && $thisDate->compareDate($DataStopDate) < 0) {
					
					// create the item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
					// add item to schedule
					$this->Schedules[$pointer]->addItem($Item);
					
					// check if the next day is within the week
					$WeekStopDate = $this->Week->getWeekOf();
					$WeekStopDate->addDay(6);
					
					if ($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer + 1]->addItem($Item);
										
				}
				
				$pointer++;
				
			}
			
			
			// Deal with spill over from the day before the week
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
				
			$DatePointer->removeDay(1);
			
			if($DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				// create and add item to the first day of the week
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
			}
		
			
		
		} else {
			
			// regular non cross day items
			while($thisDate = $Iterator->nextDay()) {
												
				if($thisDate->compareDate($DataStartDate) >= 0 && $thisDate->compareDate($DataStopDate) <= 0) {
					
					// create item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
					
					// check if item time specification is set to no-time
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$pointer]->addItem($Item);
					} else {
						$this->Schedules[$pointer]->addNoTimeItem($Item);
					}
															
				}
				
				$pointer++;
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
								
		$this->addWeekly($ItemData, $DataStartDate, $DataStopDate, $start_day, $stop_day);		
			
	
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
	
		$pointer = 0;
		
		$Iterator = $this->Week->getDateIterator();
		
		
		// check if cross day
		if($DataStartDate->compareTime($DataStopDate) > 0) {
										
			while($thisDate = $Iterator->nextDay()) {
				
				// check if within data range							
				if(($thisDate->getDayOfWeek() == $DataStartDate->getDayOfWeek()) && $thisDate->compareDate($DataStartDate) >= 0 && $thisDate->compareDate($DataStopDate) < 0) {
					
					// check if the week falls in every other week
					if(Utilities::checkEveryOtherWeek($DataStartDate, $thisDate)) {
						
						// create and add the item
						$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
						$this->Schedules[$pointer]->addItem($Item);
						
						$WeekStopDate = $this->Week->getWeekOf();
						$WeekStopDate->addDay(6);
						
						// if next day is within range, add the item to it too
						if ($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer +  1]->addItem($Item);
													
					} else {
						
						// this week is not within every other week, so check for spill from previous week
						
						$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
				
						$DatePointer->removeDay(1);
						
						if(($DatePointer->getDayOfWeek() == $DataStartDate->getDayOfWeek()) && ($DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) <= 0)) {
						
							$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
							$this->Schedules[0]->addItem($Item);
						}
														
					
					} // end if (every other week check)
					
					return;
										
				}	// end if (data range and day of week check)
			
				$pointer++;
			
			}	// end while
		
		
		} else {
			
			// non cross day item handler 
			
			while($thisDate = $Iterator->nextDay()) {
				
				if($thisDate->getDayOfWeek() == $DataStartDate->getDayOfWeek() && $thisDate->compareDate($DataStartDate) >= 0 && $thisDate->compareDate($DataStopDate) <= 0) {
				
					if(Utilities::checkEveryOtherWeek($DataStartDate, $thisDate)) {
					
						$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
																
						if($ItemData->getTimeSpec()) {
							$this->Schedules[$pointer]->addItem($Item);
						} else {
							$this->Schedules[$pointer]->addNoTimeItem($Item);
						}

					
					}
				
				}
				
				$pointer++;
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
	
		$pointer = 0;
						
		$Iterator = $this->Week->getDateIterator();
					
		// cross day check
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			// cross day item handler
					
			while($thisDate = $Iterator->nextDay()) {
							
				// shift DatePointer to the original timezone for day of month comparisons
				$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
																			
				if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay() && $thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0) {
					
					// create and add item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
					$this->Schedules[$pointer]->addItem($Item);
					
					$WeekStopDate = $this->Week->getWeekOf();
					$WeekStopDate->addDay(6);
					
					// if the next day is within week, add item 
					if ($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer +  1]->addItem($Item);
					
				}
					
			
				
				$pointer++;
			
			}
						
			// check for spills from previous week					
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
				
			$DatePointer->removeDay(1);
			
			// shift DatePointer to the original timezone for day of month comparisons
			$DateCompare = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
							
			if($ItemData->getStartDate()->getDay() == $DateCompare->getDay() && $DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
					
			}
						
			
			
			
		// regular item handler
		}	else {
					
				while($thisDate = $Iterator->nextDay()) {

					$ShiftedDate = $thisDate;
			
					// shift DatePointer to the original timezone for day of month comparisons
					if($ItemData->getTimeSpec()) {
						$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
					}
																
					if ($ShiftedDate->getDay() == $ItemData->getStartDate()->getDay() && $thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0) {
														
								// create and add item					
						$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
						
						if($ItemData->getTimeSpec()) {
							$this->Schedules[$pointer]->addItem($Item);
						} else {
							$this->Schedules[$pointer]->addNoTimeItem($Item);
						}
											
					}

					
					$pointer++;
					
				}	// end day iteration
					
			
		}	// end if
			
		
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
	
		$pointer = 0;
		
		$Iterator = $this->Week->getDateIterator();
	
		
		if($DataStartDate->compareTime($DataStopDate) > 0) {
					
			while($thisDate = $Iterator->nextDay()) {
						
				if ($thisDate->getDay() == $DataStartDate->getDay() && $thisDate->getMonth() == $DataStartDate->getMonth() && ($thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0)) {
					
					// create and add item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
					$this->Schedules[$pointer]->addItem($Item);
					
					// if next day is within week, add item to it 
					$WeekStopDate = $this->Week->getWeekOf();
					$WeekStopDate->addDay(6);
			
					if ($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer +  1]->addItem($Item);
					
				}
			
				
				$pointer++;
			
			}
			
			
			// deal with spill from previous week
			
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
				
			$DatePointer->removeDay(1);
			
			if(($DatePointer->getDay() == $DataStartDate->getDay() && $DataStartDate->getMonth() == $DatePointer->getMonth()) && ($DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0)) {
				
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
				return;
			}
			
						
			
		}	else {
		
			while($thisDate = $Iterator->nextDay()) {
				
				if ($DataStartDate->getDay() == $thisDate->getDay() && $DataStartDate->getMonth() == $thisDate->getMonth() && $thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0) {
						
					// create and add item
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
					
					// filter no-time and timed item
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$pointer]->addItem($Item);
					} else {
						$this->Schedules[$pointer]->addNoTimeItem($Item);
					}
					
				}
								
				$pointer++;
				
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
	
		$pointer = 0;
				
		$Iterator = $this->Week->getDateIterator();
		
		// test for cross day item
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			// handle corss day item
			while($thisDate = $Iterator->nextDay()) {
			
				if ($DataStartDate->getDayOfWeek() == $thisDate->getDayOfWeek() && (Utilities::CheckPeriodic($ItemData->getStartDate(), $thisDate, $this->timezone, $ItemData->getOriginalTimeZone())) && ($thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0)) {
					
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
					
					$this->Schedules[$pointer]->addItem($Item);
					
					$WeekStopDate = $this->Week->getWeekOf();
					$WeekStopDate->addDay(6);
					
					// add item to next day if with in week
					if ($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer +  1]->addItem($Item);
						
					return;
				}
				
				$pointer++;
			
			}
			
			
			// handle spill from previous week
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
				
			$DatePointer->removeDay(1);
			
			if($DatePointer->getDayOfWeek() == $DataStartDate->getDayOfWeek() && Utilities::CheckPeriodic($ItemData->getStartDate(), $DatePointer, $this->timezone, $ItemData->getOriginalTimeZone()) && $DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
			
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
				
				return;
			}
						
			
		}	else {
			
			// to prevent check periodic from shifting time for non time items
				$timezone = 0;
				if($ItemData->getTimeSpec()) $timezone = $this->timezone;
				
			// handle non-crossday item
			while($thisDate = $Iterator->nextDay()) {
										
				if ($DataStartDate->getDayOfWeek() == $thisDate->getDayOfWeek() && Utilities::CheckPeriodic($ItemData->getStartDate(), $thisDate, $timezone, $ItemData->getOriginalTimeZone()) && $thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0) {
					
					$Item = Utilities::createItem($ItemData, $thisDate, $timezone);
					
					// filter no-time and timed item
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$pointer]->addItem($Item);
					} else {
						$this->Schedules[$pointer]->addNoTimeItem($Item);
					}
					
				}
				
				$pointer++;
				
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
	
		$pointer = 0;
		
		$Iterator = $this->Week->getDateIterator();
		
		if($DataStartDate->compareTime($DataStopDate) > 0) {
			
			// handle cross day item		
			while($thisDate = $Iterator->nextDay()) {
			
				if($DataStartDate->getDayOfWeek() == $thisDate->getDayOfWeek() && Utilities::CheckPeriodic($ItemData->getStartDate(), $thisDate, $this->timezone, $ItemData->getOriginalTimeZone()) && $thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0) {
					
					// shift thisDate to the original timezone for month comparisons
					$ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
										
					if( $ItemData->getStartDate()->getMonth() == $ShiftedDate->getMonth() ) {
					
						$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
						
						$this->Schedules[$pointer]->addItem($Item);
						
						$WeekStopDate = $this->Week->getWeekOf();
						$WeekStopDate->addDay(6);
						
						// add item to next day if within week
						if($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer + 1]->addItem($Item);
						
						return;
						
					}
				}
				
				$pointer++;
			
			}
			
			
			// handle spill from the previous week
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
				
			$DatePointer->removeDay(1);
			
			if($DatePointer->getDayOfWeek() == $DataStartDate->getDayOfWeek() && Utilities::CheckPeriodic($ItemData->getStartDate(), $DatePointer, $this->timezone, $ItemData->getOriginalTimeZone()) && $DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->compareDate($DataStopDate) < 0) {
				
				$ShiftedDate = Utilities::shiftTime(new SC_DateTime($DatePointer->getDay(), $DatePointer->getMonth(), $DatePointer->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
										
				if( $ItemData->getStartDate()->getMonth() == $ShiftedDate->getMonth() ) {
					
					$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
					$this->Schedules[0]->addItem($Item);
					return;
				
				}			
				
			}
						
			
		}	else {
			
			
			$timezone = 0;
			if($ItemData->getTimeSpec()) $timezone = $this->timezone;
					
			// handle non-cross day item
			while($thisDate = $Iterator->nextDay()) {
										
				if ($DataStartDate->getDayOfWeek() == $thisDate->getDayOfWeek() && Utilities::CheckPeriodic($ItemData->getStartDate(), $thisDate, $timezone, $ItemData->getOriginalTimeZone()) && $thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0) {
					
					$ShiftedDate = $thisDate;
					
					if($ItemData->getTimeSpec()) $ShiftedDate = Utilities::shiftTime(new SC_DateTime($thisDate->getDay(), $thisDate->getMonth(), $thisDate->getYear(),$DataStartDate->getHour(),$DataStartDate->getMinute()), $this->timezone, $ItemData->getOriginalTimeZone());
										
					if( $ItemData->getStartDate()->getMonth() == $ShiftedDate->getMonth() ) {
					
						$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone);
						
						// filter no-time and timed item
						if($ItemData->getTimeSpec()) {
							$this->Schedules[$pointer]->addItem($Item);
						} else {
							$this->Schedules[$pointer]->addNoTimeItem($Item);
						}
					
					}
					
				}
				
				$pointer++;
				
			}
			
			
		}
		
	
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
		
		$pointer = 0;
		
		$Iterator = $this->Week->getDateIterator();
		
		// check if item is a cross day item
		if($start_day != $stop_day) {
			
			// handle cross day item
			while($thisDate = $Iterator->nextDay()) {
				
				if($thisDate->compareDate($DataStopDate) < 0 && $thisDate->compareDate($DataStartDate) >= 0 && $thisDate->getDayOfWeek() == $start_day) {
				
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 1);
						
						$this->Schedules[$pointer]->addItem($Item);
						
						$WeekStopDate = $this->Week->getWeekOf();
						$WeekStopDate->addDay(6);
						
						// add item to next day if within the week
						if ($Item->getStopTime()->compareDate($WeekStopDate) <= 0) $this->Schedules[$pointer + 1]->addItem($Item);
							
						break;
				
				}
				
				$pointer++;
			
			}
			
			// handle item spills from the previous week
			$DatePointer = new SC_DateTime(0,0,0,0,0,0,$this->Week->getWeekOf()->getTimeStamp());
					
			$DatePointer->removeDay(1);
			
			if($DatePointer->compareDate($DataStopDate) <= 0 && $DatePointer->compareDate($DataStartDate) >= 0 && $DatePointer->getDayOfWeek() == $start_day) {
			
				$Item = Utilities::createItem($ItemData, $DatePointer, $this->timezone, 1);
				$this->Schedules[0]->addItem($Item);
				
				return;
			}
			
		} else {
			
			// handle regular item			
			while($thisDate = $Iterator->nextDay()) {
								
				if($thisDate->compareDate($DataStopDate) <= 0 && $thisDate->compareDate($DataStartDate) >= 0 && $thisDate->getDayOfWeek() == $start_day) {
										
					$Item = Utilities::createItem($ItemData, $thisDate, $this->timezone, 0);
						
					// filter no-time and timed item
					if($ItemData->getTimeSpec()) {
						$this->Schedules[$pointer]->addItem($Item);
					} else {
						$this->Schedules[$pointer]->addNoTimeItem($Item);
					}
														
					break;
				
				}
				
				$pointer++;
			
			}
			
		
		}
		
	
	
	}
	
	
	
}