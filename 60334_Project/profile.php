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
<body>

     <header class="header">
   <img id="logo" class=" logo " src="images/Logo.png" alt="This is the website logo on the header" align ="left" >
   <ul id="hlist">     
   <li ><a class="btn home" href="homepage.php">Home</a></li>
   <li><a class="btn btn-a " href="logout.php">Log Out</a></li>
   </ul>
    </header>
<hr>

<br>

<img id="logo" class="brand" src="images/brand.jpg" alt="This is the website logo near the job search feature" height="100" align="center" >

</h1> <br/> <br/>


<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Sign up for an account</h1> </h1> <br/> <br/>

<?php // sectiona.php

session_start();

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


?>

<div class="container">
  
<ul class="class="list-group">
<li ><a class="list-group-item btn home" href="editAccount.php">Edit Account</a></li>
<?php

 if( $_SESSION['type']==1){
echo "<li><a class=\"list-group-item btn home \" href=\"postjob.php\">  Post a Job  </a></li>";
echo "<li><a class=\"list-group-item btn home \" href=\"managejobs.php\">  Manage Jobs  </a></li>";
echo "<li><a class=\"list-group-item btn home \" href=\"viewapp.php\">  View Applications  </a></li>";
}

elseif( $_SESSION['type']==2){
echo "<li><a class=\"list-group-item btn home \" href=\"apply.php\">  Apply to Jobs Manually  </a></li>";
echo "<li><a class=\"list-group-item btn home \" href=\"profile.php\">  Manage Offers  </a></li>";
}
?>

</ul>

</div>

</div>

</div>





<footer class="footer">
    About us
  </footer>
</body>



</html>