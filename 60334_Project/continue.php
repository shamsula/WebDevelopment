<?php
 session_start();
  if (isset($_SESSION['username'])) // check whether logged-in/not
  {    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $forename = $_SESSION['fname'];
    $surname  = $_SESSION['lname'];
    //destroy_session_and_data();
    echo "Welcome back $forename.<br>
          Your full name is $forename $surname.<br>
          Your username is '$username'
          and your password is '$password'.";
        header('Location:homepage.php');      
     }
  // else  not logged-in
 //echo "Please <a href='authenticate.php'>click here</a> to log in.";

 function destroy_session_and_data()
  {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 1, '/');
    session_destroy();
  }
?>