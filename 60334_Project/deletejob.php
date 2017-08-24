<?php // sectiona.php
session_start();
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);


if (
      isset($_REQUEST['ID']))
  { 




$ID=   mysqli_real_escape_string($conn, $_REQUEST['ID']);



$query  = " DELETE from `jobListing` Where `ID`='$ID' ";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
header('Location:managejobs.php');

}
  
  

?>