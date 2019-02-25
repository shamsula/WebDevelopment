<?php

include('session.php');


/*
	User Authentication as Administrator
	Username: admin
	Password: tory2018
*/

//Are we authenticated?
//$_SESSION['isAuthenticated']
//$_SESSION['login_user']
//$_SESSION['isAdmin']


//If a user has an authentication of -1, they are treated as an administrator. Anything else is treated as a normal user for now,
//but there are no other differences as of yet. Someone with Auth of 2 has the same permissions as someone with Auth 1 or 0.
//-1 IS ADMIN


?>
<html>
<head>
    <title>invenTORY</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
        <a class="nav-link" href="http://311.aljoudi.myweb.cs.uwindsor.ca/invenTORY/index.php">Home <span class="sr-only">(current)</span></a>
      </li>
	  <?php if($_SESSION['isAdmin'] == 1){
		  
		echo '<li class="nav-item">';
		echo '	<a class="nav-link" href="admin_panel.php">Admin_Panel</a>';
		echo '</li> ';
	  } ?>
      <li class="nav-item">
        <a class="nav-link" href="account.php">Account</a>
      </li>
	  <?php
		//Only show stock in or out if the user is authenticated
		if($_SESSION['isAdmin'] || $_SESSION['isAuthenticated'] == 1){
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="make_sale.php">Make_Sale</a>';
			echo '</li>';
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="refund_sale.php">Refund_Sale</a>';
			echo '</li>';
			echo '<li class="nav-item">';
			echo '<a class="nav-link" href="report_generator.php">Generate_Reports</a>';
			echo '</li>';
		}
		?>
	  
      <li class="nav-item">
        <a class="nav-link disabled" href="#">Under Construction</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="login.php">
      <?php
	  //Check if session has started. If not, redirect to login.php
	    if(!isset($_SESSION['login_user'])){
			header("location:login.php");
		}
		?>
      <a href="login.php"><button class="btn btn-outline-success my-2 my-sm-0" type="submit" ><i class="fa fa-sign-in" aria-hidden="true" ></i> Login</button></a>
    </form>
  </div>
</nav><br>
	
</header>

<!-- Inventory List -->
<div class ="container">

<?php

	//Database information
	//troyedit is needed to access user table
    $servername = "localhost";
	$username = "aljoudi_toryedit"; 
	$password = "tory2018";
	$dbname = "aljoudi_311";
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 

//Need to dynamically create this table after running query through scheduled_updater.php
if($_SESSION['isAuthenticated'] == 1 || $_SESSION['isAdmin'] == 1){

	
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		//Determine what action we are taking
		if (isset($_POST['aPassword'])) {
			//We are adding a user
			
			
			//Get data from POST
			$aid = mysqli_real_escape_string($conn,$_POST['aID']);
			$ausername = mysqli_real_escape_string($conn,$_POST['aUsername']);
			$apassword = mysqli_real_escape_string($conn,$_POST['aPassword']);
			$aauth = mysqli_real_escape_string($conn,$_POST['aAuth']);
			$asuspended = mysqli_real_escape_string($conn,$_POST['aSuspended']);
			
			$sql = "INSERT INTO `Users` (`ID`, `Username`, `Password`, `auth`, `Suspended`) VALUES ($aid, '$ausername', '$apassword', $aauth, $asuspended)";

			if ($conn->query($sql) === TRUE) {
				echo "New user created successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			
			
		} else {
			//We are deleting a user
			$dusername = mysqli_real_escape_string($conn,$_POST['dUsername']);
			$did = mysqli_real_escape_string($conn,$_POST['dID']);
			$sql = "DELETE FROM `Users` WHERE ID=$did AND Username='$dusername'";
			
			if($_POST['dID'] == 1 && $_POST['dUsername'] == 'admin'){
				echo 'YOU CANNOT DELETE THE ADMIN YOU TWIT!';
			} else {

				if ($conn->query($sql) === TRUE) {
					echo "User".$dusername. "has been removed successfully (for greater good)";
				} else {
					echo "Error: " . $sql . "<br>" . $conn->error;
				}
			}
		}
		
	}
	
	//Reset the POST data so we don't perform multiple actions next time the add/del form is run
	$_POST = array();
	
	
	//Display add / remove options
	echo '<div class="container-fluid" >';
	echo '<div class="card"><h5 class="card-header button" data-toggle="collapse" href="#addUserr" role="button" aria-expanded="false" aria-controls="addUserr">Add a User Account</h5>
	<div class="collapse" id="addUserr">
	<div class="card-body " ><form action="admin_users.php" method="POST"><input class="form-control" type="text" placeholder="Enter ID" name="aID" required><br><br><input class="form-control" type="text" placeholder="Enter Username" name="aUsername" required><br><br><input class="form-control"  type="Password" placeholder="Enter Password" name="aPassword" required><br><br>
		<input class="form-control"  type="text" placeholder="Enter Authentication" name="aAuth" required><br><br><input class="form-control" type="text" placeholder="Is Suspended?" name="aSuspended" required><br><br><button class="btn btn-success my-2 my-sm-0" type="submit">Add User</button></form></center></div></div></div><br>';
	echo '<div class="card"><h5 class="card-header" data-toggle="collapse" href="#removeUserr" role="button" aria-expanded="false" aria-controls="removeUserr">Delete User Account</h5>
	<div class="collapse" id="removeUserr">
	<div class="card-body"><form action="admin_users.php" method="POST"><input class="form-control" type="text" placeholder="Enter ID" name="dID" required><br><br><input class="form-control" type="text" placeholder="Enter Username" name="dUsername" required><br><br><button class="btn btn-success my-2 my-sm-0" type="submit">Delete User</button></form></center></div></div></div>';
	echo '<br style="clear: left;" />';
	echo '</div><br>';
	
	
	//Display master list of users
	echo '<br><br><p>Master list of all Users in system:</p><br>';
	echo '<table id="example" class="table-hover table-bordered" style="width:100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
	echo '<th>Username</th>';
    echo '<th>Password</th>';
    echo '<th>Authorization</th>';
	echo '<th>Suspended</th>';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    
   

	

	
	//Create a SQL Query to send
	$sql = "SELECT * FROM `Users`";
	$result = $conn->query($sql);
   
   	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//Record the information to our User's table
			echo '<tr><td>' . $row["ID"] . '</td>';
			echo '<td>' . $row["Username"] . '</td>';
			echo '<td>' . $row["Password"] . '</td>';
			echo '<td>' . $row["auth"] . '</td>';
			if($row["Suspended"]==1){echo '<td>True</td></tr>';}else{echo '<td>False</td></tr>';}
		}
	} else {
		//No users were found
		echo "<td>0 results</td>";
	}

    echo '</tr>';
    echo '</tfoot>';
    echo '</table>';
	
	
}else{
	//User needs to login
	echo '<br><br><br><center><p>Please Login before continuing.</p></center>';
	
}

	$conn->close();
	
?>



</div>

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
