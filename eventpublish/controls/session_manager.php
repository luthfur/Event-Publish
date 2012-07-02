<?php

$Session = new Session();

if(!$Session->check("account_id") || $Session->isExpired()) {
	header("Location: login.php");
}
	
?>