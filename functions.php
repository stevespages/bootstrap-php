<?php

// This file is in a directory called 'functions/'. It is being tracked with git and pushed to GitHub


/*
 * MODELS
 */
 
function deleteRow($table_name, $id, $pdo)
{
    $sql = "DELETE FROM $table_name WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    return $statement;
}	

function getAll($table_name, $pdo)
{
    $sql = "SELECT * FROM $table_name";
    $statement = $pdo->query($sql);
    return $statement;
}
	
function getRowToEdit($table_name, $id, $pdo)
{
    $sql = "SELECT * FROM $table_name WHERE id = ?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$id]);
    return $statement;
}

// it is not obvious how to bind parameters when they are in array variables of varying length
function save($table_name, $form_array, $pdo)
{
    $fields = "";
    $values = array();
    foreach($form_array as $key => $array) {
        $fields .= $key.", ";
        $values[] .= $array['value'];
    }
    //get rid of the trailing comma and space
    $fields = substr($fields, 0, -2);
    //$values = substr($values, 0, -3);
    //the question mark place holders should be generated so the right number is produced for the table in question
    $sql = "INSERT INTO $table_name ($fields) VALUES (?, ?, ?, ?)";
    $statement = $pdo->prepare($sql);
    $statement->execute($values);
    return $values;
}
/* duplicate?
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
*/

// !! not using prepared statements properly
function updateRow($table_name, $form_array, $id, $pdo)
{
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
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement;
}


/*
 * VIEWS
 */
 
 // !! Needs to be able to preselect options in drop downs including when...
 // ...editing a row repopulates the form.
 
 /* comment out while working on selected attribute for select options
 function showForm($action, $form_array)
 {
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
*/

 function showForm($action, $form_array)
 {
    $form = "<form method='post' action=".$action.">";
    foreach($form_array as $key => $value) {
        $form .= "<p><label>".$form_array[$key]['form_label'];
        if($form_array[$key]['type']=='select') {
            $form .= " <select name='".$form_array[$key]['name']."'>";
            foreach($form_array[$key]['options'] as $key_2 => $value_2) {
                $form .= '<option value="'.$key_2.'"';
                if($key_2 == $form_array[$key]['value']) {
                    $form .= ' selected';
                }
                $form .= '>'.$value_2.'</options>';
                

            }
        $form .= "</select";
        } else {
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
		if($form_array[$key]['validate']=='unique' AND !isset($_GET['id']))
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
