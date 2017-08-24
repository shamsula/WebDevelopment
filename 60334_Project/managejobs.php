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
<script type="text/javascript"src="https://www.gstatic.com/charts/loader.js"></script>


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

<h1 class="span4 offset4 text-center">Here are the Jobs you Posted</h1> </h1> <br/> <br/>

</div> </div>


<br?>
<?php
if (isset($_SESSION['username'])&&$_SESSION['type']=1){
$user = $_SESSION['username'];
 $query  = "SELECT * FROM jobListing where employer_ID= '$user'";
  $result = $conn->query($query);
  if (!$result) die($conn->error);
$rows = $result->num_rows;
echo '<body> <div id="table_ajax"> <table> <thead> <tr> <td>';
echo 'ID </td>  <td> Title</td> <td> Location</td> <td>Date Posted</td> <td>Deadline</td>';
if($_SESSION['type']==1){ echo '<td>'   . 'Delete A job'   . '</td>';};
echo'</tr></thead> <tbody>';


for ($j = 0 ; $j < $rows ; ++$j)
  { echo '<tr>';
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    echo '<td>'   . $row['ID']   . '</td>';
    echo '<td>'    . $row['title']    . '</td>';
    echo '<td>'    . $row['location']    . '</td>';
    echo '<td>'    . $row['date_posted']    . '</td>';
    echo '<td>'    . $row['expiry_date']    . '</td>';
    if($_SESSION['type']==1){ $IDo = $row['ID']; echo '<td>' .'<a href="deletejob.php?ID='. $IDo. '">'   . 'Delete'   . '</td>';};
    echo '</tr>';
  }
 echo '</div> </tbody> </table>'; 
  $result->close();
  
}
?>
<br/>

<div class="row-fluid">

<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Job to Employer Ratios</h1> </h1> <br/> <br/>

</div> </div>


<?php //piechart section


 $query= <<<_END

SELECT employer_ID,count(*) as cnt
FROM jobListing
group by employer_ID;

_END;



$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);

$rows = $result->num_rows;
$category = new SplFixedArray($rows);
$count = new SplFixedArray($rows);
for ($j = 0; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
    $category[$j] = $row[0] ;

    $cnt[$j] = $row[1] ;

}  

?>
<script type="text/javascript">var category =<?php echo json_encode($category); ?>;</script> 
<script type="text/javascript">var cnt =<?php echo json_encode($cnt); ?>;</script>
<script type="text/javascript" src="js/piechart.js"></script>


<div class="row-fluid">

<div class="span4 offset4 text-center">


<div id="piechart" align="center"> </div>
<a class="btn btn-a" href="profile.php">Back to user profile</a>
</div> </div>




<br/>


<footer class="footer">
    About us
  </footer>
</body>



</html>