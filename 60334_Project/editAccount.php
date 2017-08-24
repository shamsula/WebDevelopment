<!DOCTYPE html>
<html>
  <head>
  </head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<script src="js/ajax.js"></script>
<body>

     <header class="header">
   <img id="logo" class=" logo " src="images/Logo.png" alt="This is the website logo on the header" align ="left" >
   <ul id="hlist">     
   <li ><a class="btn home" href="homepage.php">Home</a></li>
   <li><a class="btn btn-a " href="loginpage.php">Sign in</a></li>
   </ul>
    </header>
<hr>

<br>

<img id="logo" class="brand" src="images/brand.jpg" alt="This is the website logo near the job search feature" height="100" align="center" >

</h1> <br/> <br/>


<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Make Changes to personal details</h1> </h1> <br/> <br/>

<?php // sectiona.php
session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


if (
      isset($_POST['pass']))
  { 



$ID=$_SESSION['username'];
$password=   mysqli_real_escape_string($conn, $_POST['pass']);

$salt1 = "jklmn";
$salt2 = "p@s@*";
$password = hash('ripemd128', "$salt1$password$salt2");

$query  = " UPDATE `client` SET `password`='$password' WHERE `ID`='$ID'";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
header('Location:logout.php');

}
  
  

?>


<div class="container">
  <form action="editAccount.php" method="post">
     
     <div class="row">
     <div class="form-group col-lg-5 col-centered">
     <label for="fname">Change Name</label> 
     <a class="btn btn-a " id="nchange">Change</a>
     <div id="nchange1" >
      <label for="fname">Change First Name</label> 
      <input class="form-control" type="text" name="fname" id="fname" placeholder="New First Name"  > 
      <label for="lname">Change Last Name</label> 
      <input class="form-control" type="text" name="lname" id="lname" placeholder="New Last Name"  > </div></div></div> <br/><br/> 
      

      
<div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="pass">Update Password</label> 
      <a class="btn btn-a " id="pchange">Change</a>
      <div id="pchange1" >
      <input class="form-control" type="password" name="pass" id="pass" placeholder="Enter your New Password here"  > </div> </div></div> <br/><br/> 
      
<a class="btn btn-a" href="profile.php">Cancel</a> <input  type="submit" value="Submit Changes" class="btn">
  
</form>
</div>

</div>

</div>






<footer class="footer">
    About us
  </footer>
</body>



</html>