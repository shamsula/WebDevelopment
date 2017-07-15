<html>
<body>
<?php // sectiona.php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
 
if (isset($_POST['fname'])   &&
      isset($_POST['lname'])    &&
      isset($_POST['user_types']) &&
      isset($_POST['email'])     &&
      isset($_POST['password']))
  {
   


$stmt = $conn->prepare("INSERT INTO user_profiles(fname, lname, usercode, email, password) VALUES(?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss",$fname,$lname,$user_types,$email,$password);

$fname= mysqli_real_escape_string($conn, $_POST['fname'] );
$lname=  mysqli_real_escape_string($conn, $_POST['lname']);
$user_types= mysqli_real_escape_string($conn,$_POST['user_types']);

$email= mysqli_real_escape_string($conn, $_POST['email']);
$password=   mysqli_real_escape_string($conn, $_POST['password']);

if (!$stmt->execute()) {
    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}



  }


$query  = "SELECT * FROM user_codes";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);


echo <<<_END
  <form action="sectiona.php" method="post"><pre>
First Name <input type="text" name="fname">
Last Name <input type="text" name="lname">
User Type <select name="user_types"> 

_END;
      
$rows = $result->num_rows;
for ($j = 0; $j < $rows ; ++$j)
  {

    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

  echo"   <option value=$row[0]>$row[1]</option>";
}

echo <<<_END
</select>
Email <input type="text" name="email">
Password <input type="password" name="password">
<input type="submit" value="submit">
  </pre></form>
_END;

 $result->close();
  $conn->close();
?>  
</body>
</html>