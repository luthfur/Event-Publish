<?php 

// Grab extension data
$extension = file("../../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);

$AttachmentData = new AttachmentData($mdb2);
$AttachmentData->delete(array($_POST[id]));

echo $_POST[id];
?>