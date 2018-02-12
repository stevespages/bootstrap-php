<?php

// This file is in a directory called 'functions/'. It is being tracked with git and pushed to GitHub

/*
 * MODELS
 */
 
function getAll($table_name, $pdo)
{
	$sql = "SELECT * FROM $table_name";
	$statement = $pdo->query($sql);
	return $statement;
}

/*
function save($table_name, $form_array, $pdo) {
		
		$fields = "";
		$values = "'";
		foreach($form_array as $key => $array) {
			$fields .= $key.", ";
			$values .= $array['value']."', '";
		}
		
		//get rid of the trailing comma and space
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -3);
		
		$sql = "INSERT INTO $table_name ($fields) VALUES ($values)";
		
		$statement = $pdo->prepare($sql);
		$statement->execute();
		return $statement;
	
	}
*/
// it is not obvious how to bind parameters when they are in array variables of varying length
function save($table_name, $form_array, $pdo) {
		
		$fields = "";
		$values = "'";
		foreach($form_array as $key => $array) {
			$fields .= $key.", ";
			$values .= $array['value']."', '";
		}
		
		//get rid of the trailing comma and space
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -3);
		
		//the question mark place holders should be generated so the right number is produced for the table in question
		$sql = "INSERT INTO $table_name ($fields) VALUES (?, ?, ?, ?)";
		
		$statement = $pdo->prepare($sql);
		$statement->execute([$values]);
		
		return $statement;
		
	}

/*
function saveB($pdo)
{
	$fields = "first_name, last_name";
	$first_name = "Be'cky";
	$last_name = "Br'own";
	$sql = "INSERT INTO person_2 ($fields) VALUES (?, ?)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$first_name, $last_name]);
	return $stmt;
}
*/

/* 
 * models/Table.class.php
 *
 * This class should be a cross application parent class for providing a useful PDO tool for interacting with databases.
 *
 *	Classes extending this class should be made for application specific PDO transactions with databases.
 *
 * One extension of this class should be made for each (major?) table in the database if it is necessary.
 * 
 * The class requires a PDO object as an argument ($db) when instantiating.
 *
 * The constructor function assigns the PDO object to the protected property, Table->dbObj referred to as $this->dbObj in the definition.
 */
 
 /*
 class Table {
  

   protected $db;


   public function __construct ( $db ) {
        $this->db = $db;
   }


   protected function makeStatement ($sql) {
        $statement = $this->db->prepare($sql);
        $statement->execute();
        return $statement;
   }
    
    
   public function getAll($table_name) {
   	
   	$sql = "SELECT * FROM $table_name";

		$statement = $this->makeStatement($sql);
	
   	return $statement;

	}
	
	
	public function deleteRow($table_name, $id) {

		$sql = "DELETE FROM $table_name WHERE id = $id";
		
		$statement = $this->makeStatement($sql);
		
		return $statement;
	}
	
	
	public function getRowToEdit($table_name, $id) {

		$sql = "SELECT * FROM $table_name WHERE id = $id";
		
		$statement = $this->makeStatement($sql);
		
		return $statement;
	}
	
	
	public function save($table_name, $form_array) {
		
		$fields = "";
		$values = "'";
		foreach($form_array as $key => $array) {
			$fields .= $key.", ";
			$values .= $array['value']."', '";
		}
		
		//get rid of the trailing comma and space
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -3);
		
		$sql = "INSERT INTO $table_name ($fields) VALUES ($values)";
		
		$this->makeStatement($sql);
		
		return $sql;
	
	}
*/
	
/*
	public function save($table_name, $form_array) {
		
		$stmt = $dbh->prepare("INSERT INTO REGISTRY (name, value) VALUES (?, ?)");
		$stmt->bindParam(1, $name);
		$stmt->bindParam(2, $value);		
		
		
		
		$fields = "";
		$values = "'";
		foreach($form_array as $key => $array) {
			$fields .= $key.", ";
			$values .= $array['value']."', '";
		}
		
		//get rid of the trailing comma and space
		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -3);
		
		$sql = "INSERT INTO $table_name ($fields) VALUES ($values)";
		
		$this->makeStatement($sql);
		
		return $sql;
	
	}	
*/
	
/*	
	public function updateRow($table_name, $form_array, $id) {
		
		$field_value = "";
		foreach($form_array as $key => $array) {
			$field_value .= $key;
			$field_value .= " = '";
			$field_value .= $array['value'];
			$field_value .= "', ";
		}
		// get rid of the trailing comma
		$field_value = substr($field_value, 0, -2);
		
		$sql = "UPDATE $table_name SET $field_value WHERE id = $id";
		
		$statement = $this->makeStatement($sql);
		
		//return $sql; // for debugging
	}
}
*/
 
 
/*
 * VIEWS
 */
 
 function showForm($action, $form_array)	{
	$form = "<form method='post' action=".$action.">";
	foreach($form_array as $key => $value) {
		$form .= "<p><label>".$form_array[$key]['form_label'];
		if($form_array[$key]['type']=='select') {
			$form .= " <select name='".$form_array[$key]['name']."'>";
			foreach($form_array[$key]['options'] as $key_2 => $value_2) {
				$form .= "<option value=".$key_2.">".$value_2."</option>";
			}
			$form .= "</select";
		} else {
			
			/*
			$form .= " <input name='".$form_array[$key]['name']
				."' type='".$form_array[$key]['type']
				."' value='".$form_array[$key]['value']
				."'";
			*/
			
			$form .= ' <input name="'.$form_array[$key]["name"]
				.'" type="'.$form_array[$key]["type"]
				.'" value="'.$form_array[$key]["value"]
				.'"';
				
			if($form_array[$key]['required']=='required') {
				$form .=" required";
			}				
		}
	$form .=	"></label> ".$form_array[$key]['error_mssg']."</p>";
	}
	$form .= "<input type='submit'> <a href='index.php'> Cancel </a></form></br>";
	return $form;
}


function createTable($statement, $editable=null)
{
	$table = "<div><table border=1>";
	while($row = $statement->fetchObject())
	{
		$table .= "<tr>";
		foreach($row as $key => $value)
		{
			$table .= "<td>".$value."</td>";
		}
		if($editable) {
			$table .= "<td><a href='index.php?pg=edit&id=".$row->id."'>Edit?</a></td>";
			$table .= "<td><a href='index.php?pg=delete&id=".$row->id."'>Delete?</a></td>";
		}
		$table .= "</tr>";
	}
	$table .= "</table></div>";
	return $table;
}
 
/*
 * CONTROLLERS
 */ 

// Note that this function implements a form of whitelisting of user entered $_POST data. Obviously...
// ... the user entered values can not be anticipated but the names of the keys of $_POST elements ...
// ... are only accessed if they are in the $form_array. There is no mechanism to change the values of ...
// ... name elements in the $form_array except by hardcoding them. 
function assignPostToFormArray($form_array)
{
	foreach($form_array as $key => $array)
	{
		$form_array[$key]['value'] = htmlentities($_POST[$form_array[$key]['name']]);
	}
	return $form_array;
}

// $db and $table_name arguments are only required if using a validation test which requires access to the database.
// A test needs to recognise 
function validateFormArray($form_array, $db=null, $table_name=null)
{
	
	foreach($form_array as $key => $array)
	{
		// from Symfony documentation web site
		if($form_array[$key]['validate']=='not_blank')
		{
			if(false === $form_array[$key]['value'] || (empty($form_array[$key]['value']) && '0' != $form_array[$key]['value']))
			{
				$form_array[$key]['error_mssg'] .= 'This field can not be empty';
			}
		}
		if($form_array[$key]['validate']=='FILTER_VALIDATE_EMAIL')
		{
			if (!filter_var($form_array[$key]['value'], FILTER_VALIDATE_EMAIL))
			{
    			$form_array[$key]['error_mssg'] .= "Please enter a valid email address";
			}	
		}
		if($form_array[$key]['validate']=='unique')
		{
			$column  = $form_array[$key]['name'];
			$sql = ("SELECT * FROM $table_name WHERE $column = ?");
			$stmt = $db->prepare($sql);
			$stmt->execute([$form_array[$key]['value']]);
			$row = $stmt->fetchObject();
			if($row !=  null)
			{
				$form_array[$key]['error_mssg'] .= 'That is already in the database. Please use another value';
			}
		}
	}
	
	return $form_array;
}


function isFormValid($form_array)
{
	$is_form_valid = true;
	foreach($form_array as $key => $array)
	{
		if($form_array[$key]['error_mssg'] != "")
		{
			$is_form_valid = false;
		}
	}
	return $is_form_valid;
}
