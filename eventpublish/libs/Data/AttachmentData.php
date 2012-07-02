<?php

/*********************************************************
Time Sharp Event Publish

Attachment Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class AttachmentData extends DataAccess {
		
	private $att;		
	private $ev;


	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
		
		$this->att = ATTACHMENT_TABLE;			// attachment table
		$this->ev = EVENT_TABLE;				// event table

	}	
	
	
	/*
	* Get a single row of location data
	* @param $location_id
	* @return Resultset
	*
	*/	
	public function getSingle($attachment_id) {
				
		$query = "SELECT * FROM $this->att, $this->ev
				WHERE $this->att.attachment_id = " . $attachment_id;
		
		echo $query;
		
		return $this->executeQuery($query);
				
	}
	
	
	
	/*
	* Get all files that are not attached to an event
	*
	* @return Resultset
	*
	*/
	
	public function getOrphaned() {
		
		$query = "SELECT * FROM $this->att WHERE $this->att.event_id = 0";
				
		return $this->executeQuery($query);
	}
	
	
	/*
	* Get all files that are pending approval
	*
	* @return Resultset
	*
	*/
	public function getUnapproved() {
		
		$query = "SELECT * FROM $this->att, $this->ev WHERE $this->att.event_id = $this->ev.event_id";
		
		$query .= " AND $this->att.file_approved = 0";
		
		return $this->executeQuery($query);
	}
	
	
	
	/*
	* Get attachments belonging to an event
	*
	* @param $event_id
	* @param $approved - whether to get approved attachments
	*
	* @return Resultset
	*
	*/
	public function getEventAttachment($event_id, $approved = NULL) {
		
		$query = "SELECT * FROM $this->att, $this->ev WHERE $this->att.event_id = $this->ev.event_id";
		
		$query .= " AND $this->ev.event_id = $event_id";
		
		if(!is_null($approved)) $query .= " AND $this->att.file_approved = $approved";
		
		return $this->executeQuery($query);
		
	}
	
	
	
	/*
	* Get multiple rows of location data
	* @param ids - list of file ids
	* @param order by
	* @param order
	* @param limit
	* @return Resultset
	*
	*/	
	public function getList($ids=null, $order_by = null, $order = null, $limit = null) {
		
		$query = "SELECT * FROM $this->att";
			
		if(count($ids) != 0) {
			
			$query .= " WHERE ";
			
			while (list($ind, $val) = each($ids)) {
				
				if($ind != 0) $query .= " OR ";
				if($val != "") $query .= " $this->att.attachment_id = $val";
				
			}
					
		}	
					
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;			
					
		return $this->executeQuery($query);
				
	}
	
	
	
	
	
	/*
	* Insert a single row of attachment data
	* @param $Attachment object
	* @param event id
	* 
	*
	*/	
	public function add($Attachment, $event_id) {

		$attachment_id = $this->getCurrentId() + 1;
			
		
		$file_name = $Attachment->getFileName();
		$file_type = $Attachment->getFileType();
		$file_size = $Attachment->getFileSize();
				
		$date_added = $Attachment->getDateAdded();
		
		$file_desc = $Attachment->getDesc();
		$file_approved = $Attachment->isApproved();
		
		
				
		$query = "INSERT INTO $this->att VALUES ($attachment_id, $event_id, '$file_name', '$file_type', '$file_size', $date_added, '$file_desc', $file_approved)";
				
		$this->execute($query);
	
				
	}
	
	
	
	
	/*
	* Set the event id for the specified file
	* @param attachment_id
	* @param event id	* 
	*
	*/
	public function updateEvent($attachment_id, $event_id) {
		
		$query = "UPDATE $this->att SET event_id = $event_id WHERE attachment_id = $attachment_id";
			
		return $this->execute($query);
	}
	
	
	
	
	/*
	* Remove Attachments for an event
	* @param event id	* 
	*
	*/
	public function removeAttachments($event_id) {
		
		$query = "UPDATE $this->att SET event_id = 0 WHERE event_id = $event_id";
			
		return $this->execute($query);
	}
	
	
	
	/*
	* Update a single row of attachment data
	* @param $Attachment object
	* @return Affected rows
	*
	*/
	public function update($Attachment) {
		
		$attachment_id = $Attachment->getId();
					
		$file_name = $Attachment->getFileName();
		$file_type = $Attachment->getFileType();
		$file_size = $Attachment->getFileSize();
				
		$date_added = $Attachment->getDateAdded();
		
		$file_desc = $Attachment->getDesc();
		$file_approved = $Attachment->isApproved();

		$query = "UPDATE $this->att SET file_name = '$file_name', 
										file_type = '$file_type',
										file_size = '$file_size',
										date_added = $date_added,
										file_desc = '$file_desc',
										file_approved = '$file_approved',
										WHERE attachment_id = $attachment_id";
			
		return $this->execute($query);
		
	}
		
		
	
	/*
	* Delete one or more attachment rows
	* @param $attachment_id - array of attachment ids to be deleted
	* 
	*/
	public function delete($attachment_id) {
		
		if(is_array($attachment_id)) {
		
			while(list($ind, $val) = each($attachment_id)) {
				
				$query = "DELETE FROM $this->att WHERE attachment_id = $val";
							
				$Affected = $this->execute($query);
				
				if (PEAR::isError($Affected)) {
					die($Affected->getMessage());
				}
							
			}
		
		} else {
			
			$query = "DELETE FROM $this->att WHERE attachment_id = $attachment_id";
			
			$Affected = $this->execute($query);
				
				if (PEAR::isError($Affected)) {
					die($Affected->getMessage());
				}
			
		}
	
	}
	
	
	/*
	* Get the current attachment id in the system
	* @return $attachment_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$query = "SELECT attachment_id FROM $this->att ORDER BY attachment_id DESC LIMIT 0,1";
		
		$Resultset = $this->executeQuery($query);
				
		$data = $Resultset->fetchRow();
		
		return $data[0];
		
	}
						
}