<?php // authenticate2.php
  require_once 'login.php';
  $connection = new mysqli($hn, $un, $pw, $db);

echo"<h1>hello there</h1>";

  if ($connection->connect_error) die($connection->connect_error);

  $rec_un = $_REQUEST['id'];

  $rec_pw = $_REQUEST['password'];


if (isset($_REQUEST['id']) &&
      isset($_REQUEST['password']))
{  


 
    $un_temp = mysql_entities_fix_string($connection, $rec_un);
    $pw_temp = mysql_entities_fix_string($connection, $rec_pw);
//echo "your querried pass is $pw_temp";
    $query = "SELECT * FROM client WHERE ID ='$un_temp'";
     $result = $connection->query($query);
//echo "your querry is $query";
     if (!$result) die($ection->error);
    
  

elseif ($result->num_rows)
	{       //echo " your pass is $rec_pw";
		$row = $result->fetch_array(MYSQLI_NUM); 
		$result->close();
		$salt1 = "jklmn";
                $salt2 = "p@s@*";
                $token = hash('ripemd128', "$salt1$pw_temp$salt2");
                  //echo "$row[5] <br>";
		  //echo $token;
                  //echo '<br>'.row[2];
                  //echo " your snatched id is $row[2]";
                  


if ($token == $row[5]) 
		{
			session_start();
			$_SESSION['username'] = $un_temp;
			$_SESSION['password'] = $pw_temp;
			$_SESSION['fname'] = $row[0];
			$_SESSION['lname']  = $row[1];
                        $_SESSION['type']   = $row[3];
			echo "$row[0] $row[1] : Hi $row[0],
				you are now logged in as '$row[2]'";
                                                           header('Location:continue.php');
		}
		else {
              
              echo("Invalid username/password combination");
              echo '<br/><br/><a class="btn home/" href="loginpage.php">Go Back</a><br/>';
              //header('Location:loginpage.php');
              die();
              //sleep(2);
              
}
	}
}

       else
       {
         header('Location:loginpage.php');    
  
         $connection->close();

        }
     


function mysql_entities_fix_string($connection, $string)
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

  function mysql_fix_string($connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }
?> // redirecting you