<?php

/*
	THIS WILL VERIFY THE SESSION, IF THERE IS NO SESSION ACTIVE IT WILL REDIRECT TO THE LOGIN PAGE
*/
   include('login_config.php');
   session_start();
   
   if(!isset($_SESSION['login_user'])){
	header("Location: login.php");
	die();
   }
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"SELECT Username FROM `Users` WHERE Username='$user_check'");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['Username'];
   
   
   /*
   
   
   //Trying to figure out why we can't login anymore
   echo "SESSION DEBUG = User: " . $_SESSION['login_user'] . " = isAdmin: " . $_SESSION['isAdmin'] . " = isAuthenticated: " . $_SESSION['isAuthenticated'];
   
   Blocking this out for now, trying to debug login
   
   //Check if session variable is set
   if(!isset($_SESSION['login_user'])){
	   
	  //Redirect to login page
      header("location:login.php");
   }
   
   */
?>