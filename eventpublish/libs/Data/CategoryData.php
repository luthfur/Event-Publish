<?php

/*********************************************************
Time Sharp Event Publish

Calendar Data Class

Developed by Luthfur Rahman Chowdhury

November 15, 2006
**********************************************************/



class CategoryData extends DataAccess {
	
	private $cat;		// category table name
	

	function __construct($db) {
					
		// establish database object
		$this->mdb2 = $db;
		
		$this->cat = CATEGORY_TABLE;
			
	}	
	
	
	/*
	* Get a single row of category data
	* @param $location_id
	* @return Resultset
	*
	*/	
	public function getSingle($category_id) {
				
		$query = "SELECT * FROM $this->cat WHERE cat_id = " . $category_id;
		
		return $this->executeQuery($query);
				
	}
	
	
	/*
	* Get multiple rows of category data
	* @param order by
	* @param order
	* @param limit
	* @return Resultset
	*
	*/	
	public function getList($order_by = null, $order = null, $limit = null) {
		
		$query = "SELECT * FROM $this->cat";
				
		if($order_by != null && $order != null) $query .= " ORDER BY " . $order_by . " $order";
		
		if($limit != null) $query .= " LIMIT " . $limit;			
						
		//echo "$query";
		return $this->executeQuery($query);
				
	}
	
	
	
	/*
	* Insert a single row of category data
	* @param $Category object
	* @return Affected rows
	*
	*/	
	public function add($Category) {
		
		$query = "SELECT cat_id FROM $this->cat ORDER BY cat_id DESC LIMIT 0,1";
		
		$Resultset = $this->executeQuery($query);
		
		$catdata = $Resultset->fetchRow();
		$category_id = $catdata[0] + 1;
		
		$category_name = $Category->getName();
		$calendar_image = $Category->getImage();
				
		$query = "INSERT INTO $this->cat VALUES ($category_id, '$category_name')";
		
		//echo $query;
		
		return $this->execute($query);
				
	}
	
	
	
	
	/*
	* Update a single row of category data
	* @param $Category object
	* @return Affected rows
	*
	*/
	public function update($Category) {
		
		$category_id = $Category->getId();
		$category_name = $Category->getName();
		$category_image = $Category->getImage();

		
		$query = "UPDATE $this->cat SET cat_name = '$category_name' WHERE cat_id = $category_id";
			
		//echo $query;
		
		return $this->execute($query);
		
	}
		
	
	/*
	* Delete one or more category rows
	* @param $category_id - array of category ids to be deleted
	* @return MDB2_Error on error
	*
	*/
	public function delete($category_id) {
		
		if(is_array($category_id)){
		
		while(list($ind, $val) = each($category_id)) {
			
			$query = "DELETE FROM $this->cat WHERE cat_id = $val";
			$Affected = $this->execute($query);
			
			if (PEAR::isError($Affected)) {
				die($Affected->getMessage());
			}
			
		}
		
		} else {
			
			$query = "DELETE FROM $this->cat WHERE cat_id = $category_id";
			$Affected = $this->execute($query);
			
			if (PEAR::isError($Affected)) {
				die($Affected->getMessage());
			}
		}
	
	}	
	
	
	
	/*
	* Get the current category_id in the system
	* @return $category_id - current id in the system
	* 
	*/
	public function getCurrentId() {
		
		$query = "SELECT cat_id FROM $this->cat ORDER BY cat_id DESC LIMIT 0,1";
						
		$Resultset = $this->executeQuery($query);
				
		$cat_data = $Resultset->fetchRow();
		
		return $cat_data[0];
		
	}
					
}