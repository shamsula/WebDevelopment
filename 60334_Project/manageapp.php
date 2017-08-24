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

<br/>

<div class="row-fluid">

<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Here are the Jobs you Applied to</h1> </h1> <br/> <br/>

</div> </div>


<br?>
<?php
if (isset($_SESSION['username'])&&$_SESSION['type']==2){
$user = $_SESSION['username'];
 $query  = "SELECT * FROM jobListing,JobApplications,client where applicant_ID= '$user'AND client.ID = applicant_ID AND job_ID = jobListing.ID";
  $result = $conn->query($query);
  if (!$result) die($conn->error);
$rows = $result->num_rows;
echo '<body> <div id="table_ajax"> <table> <thead> <tr> <td>';
echo 'Employer ID </td>  <td> Job Title</td> <td> Job ID</td> <td>Date Posted</td> <td>Deadline</td>';
if($_SESSION['type']==2){ echo '<td>'   . 'Delete Application'   . '</td>';};
echo'</tr></thead> <tbody>';


for ($j = 0 ; $j < $rows ; ++$j)
  { echo '<tr>';
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo '<td>'   . $row['employer_ID']   . '</td>';
    echo '<td>'    . $row['title']    . '</td>';
    echo '<td>'    . $row['Job_ID']    . '</td>';
    echo '<td>'    . $row['date_posted']    . '</td>';
    echo '<td>'    . $row['expiry_date']    . '</td>';
    if($_SESSION['type']==2){ $IDo = $row['Job_ID']; echo '<td>' .'<a href="deleteapp2.php?ID='. $IDo. '">'   . 'Delete'   . '</td>';};
    echo '</tr>';
  }
 echo '</div> </tbody> </table>'; 
  $result->close();
  $conn->close();
}
?>
<br/>

<div class="row-fluid">

<div class="span4 offset4 text-center">

<a class="btn btn-a" href="profile.php">Back to user profile</a>

</div> </div>




<br/>


<footer class="footer">
    About us
  </footer>
</body>



</html>
