<?php

function sanitize_input($val)
{
    
	if(!get_magic_quotes_gpc()) return addslashes($val);
         
    return $val;
    
}


function clean_display($val)
{
    
	return stripslashes($val);
         
}


/*************** Check and verify email address ************************/
function check_mail($email) {

	if(!$email) { 
		
			return 0;
	
	} else {
	
		if(!ereg("^[^@ ]+@[^@ ]+\.[^@ \.]+$", $email, $trashed)) return 0;
	
	} 
	
	return 1;

}


/***************** Generate Password ************************/
function generate_pass() {
	
	$pass = md5(uniqid(rand(), 1));

	return substr($pass, 0, 8);

}


?>