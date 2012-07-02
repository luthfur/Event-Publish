<?php

/***************************************************
main.php

Contains includes for all classes and configuration
file used by the system, and other settings.

****************************************************/



require_once(ROOT_DIR . 'libs/Smarty/libs/Smarty.class.php');
require_once(ROOT_DIR . 'libs/Engine/Date/Load.php');
require_once(ROOT_DIR . 'libs/Engine/Schedule/Load.php');
require_once(ROOT_DIR . 'libs/System/Load.php');
require_once(ROOT_DIR . 'libs/Data/Load.php');
require_once(ROOT_DIR . 'dbconfig.php');				// database configuration

// System Constants
define (EP_PAGE_TITLE, "Event Publish 1.0");
define(EP_SESSION_LENGTH, 3);

?>