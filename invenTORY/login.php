<?php
/*
	THIS IS NOT A SECURE WAY TO PERFORM LOGIN AUTHENTICATION
	
	There is no hashing or encryption here. The Username and Password is sent through a POST in plain text.
	
	The database also does not store hashes or encrypted Passwords, it stores them in plain text.
	
	These are little things that we can do to security harden the system at a later date.
	
	
	For now, this configuration will do. For proof of concept.
	
	User Authentication as Administrator
	Username: admin
	Password: tory2018
*/

//Need to have session_start.php at the beginning of each page, the session variables are not passed otherwise
session_start();
include("login_config.php");
   

   
if($_SERVER["REQUEST_METHOD"] == "POST") {
    
	// Check connection
	if ($db->connect_error) {
		die("Connection failed: " . $db->connect_error);
	} 

	//Get POST information
	$myusername = $_POST['Username'];
    $mypassword = $_POST['Password'];
	//Check the Users' table first
	
	echo $_POST['Username'];
	echo $_POST['Password'];
	
	//Create a SQL Query to send
	$sql = "SELECT * FROM `Users`";
	$result = $db->query($sql);
	
	//Check if we get any valid results back
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//Record the information to our User's table
			if($myusername == $row["Username"] && $mypassword == $row["Password"]){
				
				echo "Login Successful!<br><br>";
				
				$_SESSION['isAuthenticated'] = 1;
				$_SESSION['login_user'] = $myusername;
				
				//User can login. Are they an administrator?
				if($row["auth"] == -1){
					$_SESSION['isAdmin'] = 1;
				}else{
					$_SESSION['isAdmin'] = 0;
				}
				
				//Redirect to Index
				flush();
				header("Location: index.php");
				die('should have redirected by now');
				
				//NEED TO BREAK THE WHILE LOOP, otherwise it tries authenticating with all user accounts found in database
				break;
				
			}else{
				echo "Incorrect Username or Password!<br><br>";
				$_SESSION['isAuthenticated'] = 0;
				$_SESSION['login_user'] = "N/A";
				$_SESSION['isAdmin'] = 0;
			}
		}
	} else {
		//No users were found
		echo "0 results";
	}
   
   //echo "Session user: ";
   //echo $_SESSION['login_user'];
   //echo "authentication: " . $_SESSION['isAdmin'];
}

?>
<html>
<head>
    <title>invenTORY</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
	
	
	
</head>
<body>
<header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">InvenTORY</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="./index.php">Home <span class="sr-only">(current)</span></a>
      </li>
	  <?php if($admin==1){
		  
		echo '<li class="nav-item">';
		echo '	<a class="nav-link" href="#">Admin</a>';
		echo '</li> ';
	  } ?>
      <li class="nav-item">
        <a class="nav-link" href="account.php">Account</a>
      </li>
	  <?php
		//Only show stock in or out if the user is authenticated
		if($admin == 1 || $auth_user == 1){
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="#">Make_Sale</a>';
			echo '</li>';
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="#">Refund_Sale</a>';
			echo '</li>';
		}
		?>
	  
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Under Construction</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="document.getElementById('id01').style.display='block'"><i class="fa fa-sign-in" aria-hidden="true" ></i> Login</button>
    </form>
  </div>
</nav><br>
	
</header>

	<form action="login.php" method="POST">
    <div class="container">
	<div class="form-signin">
      <label for="uname"><b>Username</b></label>
      <input class="form-control" type="text" placeholder="Enter Username" name="Username" required><br>

      <label for="psw"><b>Password</b></label>
      <input class="form-control" type="Password" placeholder="Enter Password" name="Password" required><br>
        
      <button class="btn btn-success" type="submit">Login</button>
      
    </div>
	</div>

    
  </form>
</body>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>
<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</html>	