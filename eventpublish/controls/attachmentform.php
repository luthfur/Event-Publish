<?php 

// Grab extension data
$extension = file("../ext.dat");
define("PHP_EXT", $extension[0]);

require_once('common.' . PHP_EXT);


$upload_dir = $att_dir;



/************ main page variables *******************************/

$Smarty->assign('today_date', $today_date);

/****************************************************************/

// preset variables
$successful_upload = false;
$upload_try = false;


// grab all the file ids for attachment
$file_ids = "";
if ($_POST['file_ids'] != "") $file_ids = $_POST['file_ids'];	// grab file ids after an attachment upload is attempteds
if ($_GET['file_ids'] != "") $file_ids = $_GET['file_ids'];		// grab file ids on error

		
if($_FILES['selected_file']['error'] == 0 && isset($_FILES['selected_file'])) {
	
	$upload_try = true;
	
	// upload the file	
	$upload_file = $upload_dir . basename($_FILES['selected_file']['name']);
	
	// parse file parts
	$file_parts = explode(".", basename($_FILES['selected_file']['name']));
	$file_type = $file_parts[count($file_parts) - 1];
	$file_name = "";
	
	// calculate file size in KB
	$file_size = $_FILES["selected_file"]["size"] / 1024;
	
		
	if($file_size > MAX_UPLOAD_SIZE) {
		
		// file size exceeds maximum
		$error_message = "File size must be less than: " . MAX_UPLOAD_SIZE . "KB.";
	
	} else if (!in_array($file_type, $_ALLOWED_UPLOAD_TYPE)) {
		
		// file type not allowed
		$error_message = "." . $file_type . " file attachments are not allowed.";
	
	} else {
	
		// reassemble file name
		for ($i=0; $i<count($file_parts) - 1; $i++) {
			$file_name .= $file_parts[$i];
		}
		
		// check the number of copies of file already exists
		$count = 0;
		while(file_exists($upload_file)) {
			$count++;
			$upload_file = $upload_dir . $file_name . "($count)." . $file_type;
			
		}	
		
		// reassemble file name with extension
		if($count != 0)	$file_name = $file_name . "($count)";
		$file_name .= "." . $file_type;
		
		
		// upload file
		if (move_uploaded_file($_FILES['selected_file']['tmp_name'], $upload_file)) $successful_upload = true;
		
		$error_message = "Upload failed.";
	
	}
	
	
	
	$AttachmentData = new AttachmentData($mdb2);
	
	
	if($successful_upload == true) {
		
		// On successful upload, add attachment data to DB
					
		$Attachment = new Attachment();
		
		$Attachment->setFileName($file_name);
		$Attachment->setFileType($file_type);
		$Attachment->setFileSize($file_size);
		$Attachment->setDateAdded(time());
		
		$Attachment->setDesc($_POST['file_desc']);
		$Attachment->setApproved($approved);
		
		$AttachmentData->add($Attachment, 0);
			
		if($file_ids != "") $file_ids .= ",";
		$file_ids .= $AttachmentData->getCurrentId();
				
	}
			
} // end  if




// Reassemble file id string. 
// Get all the attachments for this event:


$AttachmentData = new AttachmentData($mdb2);

$attdata = array();
$idset = explode(",", $file_ids);

if(count($idset) != 0 && $idset[0] != "") {
		
	$ResultSet = $AttachmentData->getList($idset);
	
	while($data = $ResultSet->fetchRow(MDB2_FETCHMODE_ASSOC)) {
		
		$attdata[] = new Attachment($data);
		
	}

}
$attachment_ids = explode(",", $file_ids);

$Smarty->assign('attdata', $attdata);

$Smarty->assign('attachment_string', $file_ids);
$Smarty->assign('attachment_ids', $attachment_ids);

$Smarty->assign('upload_try', $upload_try);
$Smarty->assign('successful_upload', $successful_upload);
$Smarty->assign('att_error_message', $error_message);


// display the header
$Smarty->display('attachment_header.tpl');

$Smarty->display('attachment_form.tpl');

$Smarty->display('attachment_footer.tpl');



?>