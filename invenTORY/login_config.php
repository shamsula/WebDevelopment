<?php

/*
	THIS IS WHERE WE USE THE READ ONLY DATABASE USER
	
	Database: aljoudi_311

	for Read Only access
	Username: aljoudi_toryread
	password: tory2018
*/
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'aljoudi_toryread');
   define('DB_PASSWORD', 'tory2018');
   define('DB_DATABASE', 'aljoudi_311');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>