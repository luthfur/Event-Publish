<?php
// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.php');

$AttachmentData = new AttachmentData($mdb2);

$Result = $AttachmentData->getOrphaned();

$attdata = array();

while($data = $Result->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
		$attdata[] = new Attachment($data);
		
}


echo "Attachment file cleanup started...<br />";

while(list($ind, $val) = each($attdata)) {
	echo "Removing file: " . $val->getFileName() . "<br />";
	@unlink(ATTACHMENT_DIR . $val->getFileName());
	$AttachmentData->delete($val->getId());
}

echo "Attachment file cleanup complete.<br />";

?>