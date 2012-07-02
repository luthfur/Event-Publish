<?php


$ACCOUNT_TABLE = ACCOUNT_TABLE;
$USER_TABLE = USER_TABLE;
$CALENDAR_TABLE = CALENDAR_TABLE;
$CATEGORY_TABLE = CATEGORY_TABLE;
$EVENT_TABLE = EVENT_TABLE;
$CONTACT_TABLE = CONTACT_TABLE;
$LOCATION_TABLE = LOCATION_TABLE;
$ATTACHMENT_TABLE = ATTACHMENT_TABLE;
$SCHEDULE_TABLE = SCHEDULE_TABLE;
				
$EVCALENDAR_TABLE = EVCALENDAR_TABLE;
$EVCONTACT_TABLE = EVCONTACT_TABLE;
$EVTAG_TABLE = EVTAG_TABLE;
$EVSCHEDULE_TABLE = EVSCHEDULE_TABLE;
$EVUSER_TABLE = EVUSER_TABLE;
$EVLOCATION_TABLE = EVLOCATION_TABLE;
$LOCUSER_TABLE = LOCUSER_TABLE;
$TIMEZONE_TABLE = TIMEZONE_TABLE;
$SETTINGS_TABLE = SETTINGS_TABLE;
		
		


$sql = array(
"DROP TABLE IF EXISTS $ACCOUNT_TABLE",

"CREATE TABLE $ACCOUNT_TABLE (
  `account_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL,
  `account_date_set` int(11) default NULL,
  `account_type` tinyint(1) NOT NULL,
  `account_active` tinyint(1) NOT NULL default '0',
  `account_timezone` int(3) NOT NULL,
  `account_perpage` int(3) NOT NULL,
  PRIMARY KEY  (`account_id`)
) ENGINE=InnoDB",


"DROP TABLE IF EXISTS $ATTACHMENT_TABLE",

"CREATE TABLE $ATTACHMENT_TABLE (
  `attachment_id` bigint(20) NOT NULL,
  `event_id` bigint(20) NOT NULL,
  `file_name` varchar(100) NOT NULL,
  `file_type` varchar(10) NOT NULL,
  `file_size` int(5) NOT NULL,
  `date_added` int(11) NOT NULL,
  `file_desc` varchar(200) NOT NULL,
  `file_approved` tinyint(1) NOT NULL,
  PRIMARY KEY  (`attachment_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $CALENDAR_TABLE",

"CREATE TABLE $CALENDAR_TABLE (
  `calendar_id` bigint(20) NOT NULL auto_increment,
  `category_id` bigint(20) NOT NULL,
  `calendar_name` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`calendar_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $CATEGORY_TABLE",

"CREATE TABLE $CATEGORY_TABLE (
  `cat_id` bigint(20) NOT NULL auto_increment,
  `cat_name` varchar(200) NOT NULL default '',
  PRIMARY KEY  (`cat_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $CONTACT_TABLE",

"CREATE TABLE $CONTACT_TABLE (
  `contact_id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) NOT NULL,
  `contact_name` varchar(100) NOT NULL default '',
  `contact_address1` varchar(200) NOT NULL default '',
  `contact_address2` varchar(200) NOT NULL default '',
  `contact_city` varchar(200) NOT NULL default '',
  `contact_state` varchar(200) NOT NULL default '',
  `contact_zip` varchar(15) NOT NULL default '',
  `contact_email` varchar(200) NOT NULL default '',
  `contact_phone` varchar(20) NOT NULL default '',
  `contact_fax` varchar(20) NOT NULL default '',
  `contact_cell` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`contact_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $EVENT_TABLE",

"CREATE TABLE $EVENT_TABLE (
  `event_id` bigint(20) NOT NULL auto_increment,
  `event_title` varchar(200) NOT NULL default '',
  `text_time` varchar(150) NOT NULL default '',
  `event_desc` text NOT NULL,
  `capacity` int(12) NOT NULL,
  `approved` tinyint(1) NOT NULL default '0',
  `published` tinyint(1) NOT NULL,
  `cancelled` tinyint(1) NOT NULL,
  `allow_register` tinyint(1) NOT NULL,
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $EVCALENDAR_TABLE",

"CREATE TABLE $EVCALENDAR_TABLE (
  `event_id` bigint(20) NOT NULL default '0',
  `calendar_id` bigint(20) NOT NULL default '0'
) ENGINE=InnoDB",


"DROP TABLE IF EXISTS $EVCONTACT_TABLE",

"CREATE TABLE $EVCONTACT_TABLE (
  `event_id` bigint(20) NOT NULL default '0',
  `contact_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $EVLOCATION_TABLE",

"CREATE TABLE $EVLOCATION_TABLE(
  `event_id` bigint(20) NOT NULL default '0',
  `location_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $EVSCHEDULE_TABLE",

"CREATE TABLE $EVSCHEDULE_TABLE (
  `event_id` bigint(20) NOT NULL default '0',
  `schedule_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`schedule_id`),
  UNIQUE KEY `schedule_id` (`schedule_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $EVTAG_TABLE",

"CREATE TABLE $EVTAG_TABLE (
  `event_id` bigint(20) NOT NULL,
  `tag` varchar(50) NOT NULL
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $EVUSER_TABLE",

"CREATE TABLE $EVUSER_TABLE(
  `event_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`event_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $LOCATION_TABLE",
"CREATE TABLE $LOCATION_TABLE (
  `location_id` bigint(20) NOT NULL,
  `location_title` varchar(200) NOT NULL default '',
  `location_address1` varchar(200) NOT NULL default '',
  `location_address2` varchar(200) NOT NULL default '',
  `location_city` varchar(100) NOT NULL default '',
  `location_state` varchar(100) NOT NULL default '',
  `location_zip` varchar(100) NOT NULL default '',
  `location_phone` varchar(20) NOT NULL default '0',
  `location_fax` varchar(20) NOT NULL default '0',
  `location_desc` text NOT NULL,
  `location_image` varchar(200) NOT NULL,
  PRIMARY KEY  (`location_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $LOCUSER_TABLE",
"CREATE TABLE $LOCUSER_TABLE (
  `user_id` bigint(20) NOT NULL,
  `location_id` bigint(20) NOT NULL,
  PRIMARY KEY  (`location_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $SCHEDULE_TABLE",
"CREATE TABLE $SCHEDULE_TABLE (
  `schedule_id` bigint(20) NOT NULL auto_increment,
  `schedule_type` tinyint(1) NOT NULL default '0',
  `start_date` int(11) NOT NULL default '0',
  `stop_date` int(11) NOT NULL default '0',
  `timespec` tinyint(1) NOT NULL default '0',
  `org_timezone` int(3) NOT NULL,
  PRIMARY KEY  (`schedule_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $USER_TABLE",
"CREATE TABLE $USER_TABLE (
  `user_id` bigint(20) NOT NULL,
  `user_full_name` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $SETTINGS_TABLE",
"CREATE TABLE $SETTINGS_TABLE (
  `setting_id` bigint(20) NOT NULL auto_increment,
  `settings_name` varchar(50) NOT NULL,
  `settings_value` varchar(200) NOT NULL,
  PRIMARY KEY  (`setting_id`)
) ENGINE=InnoDB",



"DROP TABLE IF EXISTS $TIMEZONE_TABLE",
"CREATE TABLE $TIMEZONE_TABLE (
  `timezone_id` bigint(20) NOT NULL,
  `tzid` varchar(200) NOT NULL
) ENGINE=InnoDB");

?>