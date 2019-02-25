<?php

/*  This is basic connection information. This can change if the server is moved.  */
/*
Some MySQL information for us regarding authentication. Use these credentials when accessing through PHP or MyPHPAdmin

Database: aljoudi_311

for Read Only access
Username: aljoudi_toryread
password: tory2018

For transactions (read and write but only to transaction table)
Username: aljoudi_inventory
Password: tory2018

For full administrative SQL access to all tables
Username: aljoudi_toryedit
Password: tory2018
*/

//Global variables that hold the contents of the database
$users_db = array(array());
$inventory_db = array();


UPDATE_LOCAL_VAR();
/*

*/
function CHECK_TIME(){
	
}
/*
	THIS FUNCTION WILL QUERY THE SQL DATABASE FOR ALL ITEMS WITHIN THE DATABASE
	OTHER FUNCTIONS WILL PULL DATA FROM THIS UPDATER PAGE
*/
function UPDATE_LOCAL_VAR(){
	
	$servername = "localhost";
	$username = "aljoudi_inventory";
	$password = "tory2018";
	$dbname = "aljoudi_311";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

	//Check the Users' table first
	
	//Create a SQL Query to send
	$sql = "SELECT * FROM `Users`";
	$result = $conn->query($sql);
	
	$i = 0;

	//Check if we get any valid results back
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//Record the information to our User's table
			$users_db[$row["ID"]] = array($row["Username"], $row["Password"], $row["auth"]);
			echo "ID: $i - Username: " . $users_db[$i][1] . " - Password: " . $users_db[$i][2]["Password"] . " - Authentication: " . $users_db[$i][3]["auth"];
			$i = $i + 1;
		}
	} else {
		echo "0 results";
	}


	$conn->close();
}

/*
	THIS FUNCTION WILL WRITE ALL LOCAL INFORMATION TO THE TABLES
	IN THE DATABASE.
*/
function UPDATE_DATABASE_VAR(){
	
}


?>