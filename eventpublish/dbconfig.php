<?php
		
		/***************************************************
		dbconfig.php
		
		Table constant definitions and database connection
		settings.
		
		****************************************************/
		
		
		$dsn = array(
			'phptype'  => 'mysql',
			'username' => 'root',
			'password' => '',
			'hostspec' => 'localhost',
			'database' => 'ep_test'
		);
		
		$options = array(
			'debug'       => 2,
			'portability' => MDB2_PORTABILITY_ALL,
		);
		
		define("ACCOUNT_TABLE", "epub_account");
		define("USER_TABLE", "epub_user");
		define("CALENDAR_TABLE", "epub_calendar");
		define("CATEGORY_TABLE", "epub_category");
		define("EVENT_TABLE", "epub_event");
		define("CONTACT_TABLE", "epub_contact");
		define("LOCATION_TABLE", "epub_location");
		define("ATTACHMENT_TABLE", "epub_attachment");
		define("SCHEDULE_TABLE", "epub_schedule");
				
		define("EVCALENDAR_TABLE", "epub_eventcalendar");
		define("EVCONTACT_TABLE", "epub_eventcontact");
		define("EVTAG_TABLE", "epub_eventtag");
		define("EVSCHEDULE_TABLE", "epub_eventschedule");
		define("EVUSER_TABLE", "epub_eventuser");	
		define("EVLOCATION_TABLE", "epub_eventlocation");
		define("LOCUSER_TABLE", "epub_locationuser");
		define("TIMEZONE_TABLE", "epub_timezone");
		define("SETTINGS_TABLE", "epub_settings");
		//define('USER_TIMEZONE', 2);
		
		?>