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
   <li><a class="btn btn-a " href="loginpage.php">Sign in</a></li>
   </ul>
    </header>
<hr>

<br>

<img id="logo" class="brand" src="images/brand.jpg" alt="This is the website logo near the job search feature" height="100" align="center" >

</h1> <br/> <br/>


<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Sign up for an account</h1> </h1> <br/> <br/>

<?php // sectiona.php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


if (isset($_POST['fname'])   &&
      isset($_POST['lname'])    &&
      isset($_POST['uid']) &&
      isset($_POST['acc_type'])     &&
      isset($_POST['dob'])     &&
      isset($_POST['pass']))
  { 
$stmt = $conn->prepare("INSERT INTO client(fname, lname, ID, client_type, DOB, password) VALUES(?,?, ?, ?, ?, ?)");
$stmt->bind_param("sssiss",$fname,$lname,$uid,$acc_type,$dob, $password);

$fname= mysqli_real_escape_string($conn, $_POST['fname'] );
$lname=  mysqli_real_escape_string($conn, $_POST['lname']);
$uid= mysqli_real_escape_string($conn,$_POST['uid']);

$acc_type= mysqli_real_escape_string($conn, $_POST['acc_type']);
$dob= mysqli_real_escape_string($conn, $_POST['dob']);
$password=   mysqli_real_escape_string($conn, $_POST['pass']);

$salt1 = "jklmn";
$salt2 = "p@s@*";
$password = hash('ripemd128', "$salt1$password$salt2");



if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }



}
  
  

?>


<div class="container">
  <form action="signup.php" method="post">

     <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="fname">First Name</label> 
      <input class="form-control" type="text" name="fname" id="fname" placeholder="Enter your First Name here"  required> </div></div><br/> <br/>
       
<div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="lname">Last Name</label> 
      <input class="form-control" type="text" name="lname" id="lname" placeholder="Enter your Last Name here" required > </div></div> <br/><br/> 
      

 <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="uid">User ID</label> 
      <input class="form-control" type="text" name="uid" id="uid" placeholder="Enter Your Preferred User ID here"  required> </div></div><br/> <br/>
       
<div class="row">


     <div class="form-group col-lg-5 col-centered">
<label for="id">Select your account type</label> <br/>
<select class="form-control" id="acc_type" name="acc_type" >
<?php
$query  = "SELECT * FROM client_types";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);

$rows = $result->num_rows;
for ($j = 0; $j < $rows ; ++$j)
  {

    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

  echo"   <option value=$row[0]>$row[1]</option>";
}

?>	

</select>
 </div></div> <br/><br/> 
      

 <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="dob">Enter Your Date of Birth</label> 
      <input class="form-control" type="date" name="dob" id="dob" placeholder="Enter DOB in the format shown"  required> </div></div><br/> <br/>
       
<div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="pass">Password</label> 
      <input class="form-control" type="password" name="pass" id="pass" placeholder="Enter your Password here" > </div></div> <br/><br/> 
      <a class="btn btn-a" href="homepage.html">Cancel</a> <input  type="submit" value="Register" class="btn">
  
</form>
</div>

</div>

</div>





<footer class="footer">
    About us
  </footer>
</body>



</html>