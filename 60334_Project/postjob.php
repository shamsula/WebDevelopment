<!DOCTYPE html>
<html>
  <head>
  
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<script src=“/js/ajax.js"> </script> 



<script>
function showHint(str) {
    if (str.length == 0) { 
        document.getElementById("hello").innerHTML = "";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("hello").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "table_div1.php?p_title=" + str, true);
        xmlhttp.send();
    }
}
</script>



</head>
<body>
<?php // sectiona.php

session_start();



  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
   

if (isset($_POST['user'])   &&
    isset($_POST['title'])   && 
      
      isset($_POST['expiry']))
  { 
$stmt = $conn->prepare("INSERT INTO jobListing( title, expiry_date, employer_ID ) VALUES( ?, ?, ?)");
$stmt->bind_param("sss",$title,$expiry,$user);

$title= mysqli_real_escape_string($conn, $_POST['title'] );
$user=  mysqli_real_escape_string($conn, $_POST['user']);
$expiry=  mysqli_real_escape_string($conn, $_POST['expiry']);




if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
  }



}
  
  
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
$jid= $_REQUEST['ID'];
$uid= $_SESSION['username'];
?>
   
   </ul>
    </header>
<hr>



<div class="container">
  <form action="postjob.php" method="post">

     <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="user">Employee ID</label> 
      <input class="form-control" type="text" name="user" id="user" placeholder="Enter Your Employee ID here" value="<?php echo htmlspecialchars($uid); ?>" required> </div></div><br/> <br/>
       
<div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="title">Title</label> 
      <input class="form-control" type="text" name="title" id="title" placeholder="Enter the JOB TITLE here" required "> </div></div> <br/><br/> 
     
<div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="expiry">Expiry Date</label> 
      <input class="form-control" type="date" name="expiry" id="expiry" placeholder="Enter the Expiry Date of the job here"  required> </div></div><br/> <br/>
       


<div class="row">
     <div class="form-group col-lg-5 col-centered">
     <a class="btn btn-a" href="profile.php">Back to user profile</a> <input  type="submit" value="Post job" class="btn"> </div></div>

 </form>

</div> 



<footer class="footer">
    About us
  </footer>
</body>



</html>