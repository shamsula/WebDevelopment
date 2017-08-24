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


 <br/> 

<div class="row-fluid">

<div class="span4 offset4 text-center">

<h1 class="span4 offset4 text-center">Search Results</h1> </h1> <br/> <br/>

<?php
if (isset($_REQUEST['keyword'])){
$keyword = $_REQUEST['keyword'];
$query  = "SELECT * FROM jobListing where title like '%$keyword%'";
if(isset($_REQUEST['location'])!=""){
$location = $_REQUEST['location'];
$query  = "SELECT * FROM jobListing where title like '%$keyword%' AND location like '%$location%'";

}
 
  $result = $conn->query($query);
  if (!$result) die($conn->error);
$rows = $result->num_rows;
echo '<body> <div id="table_ajax"> <table> <thead> <tr> <td>';
echo 'ID </td>  <td> Title</td> <td> Location</td> <td>Date Posted</td> <td>Deadline</td>';
if($_SESSION['type']==2){ echo '<td>'   . 'Apply Now'   . '</td>';};
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
    if($_SESSION['type']==2){ $IDo = $row['ID']; echo '<td>' .'<a href="apply.php?ID='. $IDo. '">'   . 'apply'   . '</td>';};
    echo '</tr>';
  }
 echo '</div> </tbody> </table>'; 
  $result->close();
  $conn->close();
}
?>

<br/>

<div class="container">
  <form name="ajax" method="post" action="search.php">

     <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="keyword">Keyword</label> 
      <input class="form-control" type="text" name="keyword" id="keyword" placeholder="Enter the job search term here"   > </div></div><br/> 
       <div class="row">
     <div class="form-group col-lg-5 col-centered">
      <label for="location">Location</label> 
      <input class="form-control" type="text" name="location" id="location" placeholder="Enter the job location here" > </div></div> <br/> 
      <input  type="submit" value="Find Jobs" class="btn">
  </form>




<br/>


</div>

<br/>




</div>

</div>


<footer class="footer">
    About us
  </footer>
</body>



</html>