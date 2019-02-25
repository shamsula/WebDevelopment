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

//Need to dynamically create this table after running query through scheduled_updater.php
if($_SESSION['isAuthenticated'] == 1 || $_SESSION['isAdmin'] == 1){
	echo'<center><h2 class="display-4">Admin Panel</h2></center><br><hr>';
	echo '<center><br><br>';
	echo '<a href="admin_users.php"><button class="btn btn-outline-primary" action="admin_users.php">Edit Employees/Users</button></a><br><br><br>';
	echo '<a href="admin_inventory.php"><button class="btn btn-outline-primary" action="admin_inventory.php">Edit Inventory</button></a><br><br><br>';
	//echo '<a href="admin_companies.php"><button action="admin_companies.php">Edit Companies/Payouts</button></a>';
	echo '</center>';

}else{
	//User needs to login
	echo '<br><br><br><center><p>Please Login before continuing.</p></center>';
	
}
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
