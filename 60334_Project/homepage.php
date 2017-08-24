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
<script src=“/js/ajax.js"> </script> 

<body>
<?php // sectiona.php

session_start();



  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
   

?>

 
     <header class="header">
   <img id="logo" class=" logo " src="images/Logo.png" alt="This is the website logo on the header" align ="left" >
   <ul id="hlist">     
   <li ><a class="btn home" href="homepage.php">Home</a></li>
<?php
 if( $_SESSION['username']){
 $puttyy=$_SESSION['username'];
 $sess= "Log out $puttyy";
echo "<li><a class=\"btn btn-a \" href=\"profile.php\">  Profile  </a></li>";
    echo "<li><a class=\"btn btn-a \" href=\"logout.php\">  $sess  </a></li>";
}
 else {
 $sess="Sign in";

     echo "<li><a class=\"btn btn-a \" href=\"loginpage.php\">  $sess </a></li>";
}
?>
   
   </ul>
    </header>
<hr>

<br>

<img id="logo" class="brand" src="images/brand.jpg" alt="This is the website logo near the job search feature" height="100" align="center" >

</h1> <br/> <br/>

<div class="row-fluid">

<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Find a Job</h1> </h1> <br/> <br/>

<div class="container">
  <form name="ajax" method="post" action="search.php"">

     <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="keyword">Keyword</label> 
      <input class="form-control" type="text" name="keyword" id="keyword" placeholder="Enter the job search term here"  required onkeyup="searchtitle();"> </div></div><br/> <br/>
       <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="location">Location</label> 
      <input class="form-control" type="text" name="location" id="location" placeholder="Enter the job location here" > </div></div> <br/><br/> 
      <input  type="submit" value="Find Jobs" class="btn">
  </form>


<?php
// require_once 'table_div.php';
?>


</div>




</div>

</div>


<footer class="footer">
    About us
  </footer>
</body>



</html>