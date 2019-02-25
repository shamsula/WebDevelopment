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
      <a href="logout.php"><button class="btn btn-outline-danger my-2 my-sm-0" type="submit" ><i class="fa fa-sign-out" aria-hidden="true" ></i> Logout</button></a>
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
		if (isset($_POST['aSN'])) {
			//We are adding an item
			
			
			//Get data from POST
			$aid = mysqli_real_escape_string($conn,$_POST['aID']);
			$aSN = mysqli_real_escape_string($conn,$_POST['aSN']);
			$aModel = mysqli_real_escape_string($conn,$_POST['aModel']);
			$aDesc = mysqli_real_escape_string($conn,$_POST['aDescription']);
			$aPrice = mysqli_real_escape_string($conn,$_POST['aPrice']);
			$aStock = mysqli_real_escape_string($conn,$_POST['aStock']);
			$aDate = mysqli_real_escape_string($conn,date("Y-m-d"));
			$aUser = mysqli_real_escape_string($conn,$_SESSION['login_user']);
			
			//Skillfully craft that beautiful SQL query
			$sql = "INSERT INTO Inventory VALUES ($aid, $aSN, '$aModel', '$aDesc', '$aUser', '$aDate', $aPrice, $aStock)";

			//Send it!!
			if ($conn->query($sql) === TRUE) {
				echo "New Item Added to Inventory!";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
			
			
			
		} else {
			//We are deleting an item
			$did = mysqli_real_escape_string($conn,$_POST['dID']);
			$dSN = mysqli_real_escape_string($conn,$_POST['dSN']);
			$dModel = mysqli_real_escape_string($conn,$_POST['dModel']);
			
			//Create the SQL Query
			$sql = "DELETE FROM Inventory WHERE ID=$did AND SN=$dSN AND Model='$dModel'";
			
			//Send the query
			if ($conn->query($sql) === TRUE) {
				echo "Record Removed successfully";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
		
	}
	
	//Reset the POST data so we don't perform multiple actions next time the add/del form is run
	$_POST = array();
	
	
	//Display add / remove options
	echo '<div class="container-fluid" >';
	
	echo '<div class="card"><h5 class="card-header button" data-toggle="collapse" href="#addItem" role="button" aria-expanded="false" aria-controls="addItem">Add New Inventory Item</h5>
	<div class="collapse" id="addItem"><div class="card-body">
	<br><br><form action="admin_inventory.php" method="POST">
	<input class="form-control" size="15" type="text" placeholder="Enter ID" name="aID" required><br>
	<input class="form-control" size="30" type="text" placeholder="Enter Serial Number" name="aSN" required><br>
	<input class="form-control" size="30" type="text" placeholder="Enter Model Number" name="aModel" required><br>
	<input class="form-control" size="120" type="text" placeholder="Enter Description" name="aDescription" required><br>
	<input class="form-control" size="15" type="text" placeholder="Price" name="aPrice" required><br>
	<input class="form-control" size="15" type="text" placeholder="Current Stock" name="aStock" required><br>
	<center><button class="btn btn-success my-2 my-sm-0" type="submit">Add Item</button></center></form></div></div></div><br><br>';
	
	echo '<div class="card"><h5 class="card-header button" data-toggle="collapse" href="#removeItem" role="button" aria-expanded="false" aria-controls="removeItem">Delete Inventory Item</h5>
	<div class="collapse" id="removeItem"><div class="card-body">
	<br><form action="admin_inventory.php" method="POST">
	<input class="form-control" type="text" placeholder="Enter ID" name="dID" required><br>
	<input class="form-control" type="text" placeholder="Enter Serial Number" name="dSN" required><br>
	<input class="form-control" type="text" placeholder="Enter Model" name="dModel" required><br>
	<center><button class="btn btn-success my-2 my-sm-0" type="submit">Delete Item</button></center></form></div></div></div>';
	
	echo '<br style="clear: left;" />';
	echo '</div>';
	
	
	//Display master list of users
	echo '<br><br><p>Master list of all Items in InvenTORY System:</p><br>';
	echo '<table id="example" class="table-hover table-bordered" style="width:100%">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>ID</th>';
	echo '<th>Serial</th>';
    echo '<th>Model</th>';
    echo '<th>Description</th>';
    echo '<th>Last Update By</th>';
    echo '<th>Last Update Date</th>';
	echo '<th>Price</th>';
    echo '<th>Stock</th>';
    echo '</th>';
    echo '</tr>';
    echo '</thead>';
    
   

	

	
	//Create a SQL Query to send
	$sql = "SELECT * FROM `Inventory`";
	$result = $conn->query($sql);
   
   	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			//Record the information to our User's table
			echo '<tr><td>' . $row["ID"] . '</td>';
			echo '<td>' . $row["SN"] . '</td>';
			echo '<td>' . $row["Model"] . '</td>';
			echo '<td>' . $row["Description"] . '</td>';
			echo '<td>' . $row["LastUpdateBy"] . '</td>';
			echo '<td>' . $row["LastUpdate"] . '</td>';
			echo '<td>' . $row["Price"] . '</td>';
			echo '<td>' . $row["Stock"] . '</td></tr>';
		}
	} else {
		//No users were found
		echo "<td>0 results</td>";
	}

    echo '</tr>';
    echo '</tfoot>';
    echo '</table><br><br>';
	
	
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
