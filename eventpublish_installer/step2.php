<?php

include 'common.php';


// PHP version check
$version = phpversion();
$ver_array = explode(".", $version);

$Smarty->display("header.tpl");

if($ver_array[0] != 5) {
	
	// display version error
	$Smarty->display("version_error.tpl");
	
} else {
	
	// file writability check
	if(is_writable(ROOT_DIR . "dbconfig.php")) {
		
		// display the form
		$Smarty->display("form.tpl");
			
	} else {
		
		// display writable error
		$Smarty->display("writable_error.tpl");
		
	}
	
}

$Smarty->display("footer.tpl");






?>