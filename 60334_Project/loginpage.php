<html>
  <head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>

 
     <header class="header">
   <img id="logo" class=" logo " src="images/Logo.png" alt="This is the website logo on the header" align ="left" >
   <ul id="hlist">     
   <li ><a class="btn home" href="homepage.php">Home</a></li>
    </ul>
    </header>
<hr>

<br>





<div class="row-fluid">

<div class="span4 offset4 text-center">

<img id="logo" class="brand" src="images/brand.jpg" alt="This is the website logo near the job search feature" height="100" align="center" >
	<br/> <br/> 
	<h1 class="span4 offset4 text-center"><p>Log in</p></h1> <br/> <br/> 

           <div class="container">

		<form method="post" action="authenticate.php">
                         <div class="row">
			   <div class="form-group col-lg-5 col-centered">
				<label for="id">UserID</label>
				<input id="id" name="id" type="text" class=" form-control "  placeholder="Enter your username here" required /> </div></div>
                                <br/> <br/> 
			<div class="row">
                           <div class="form-group col-lg-5 col-centered">
                                <label for="password">Password</label>
				<input id="password" name="password" type="password" class=" form-control"  placeholder="Enter your password here" required /> </div></div>
                                <br/> <br/>
			
            <center>
				<div class="error"><?php echo $error;?></div> <!-- This is where the login error (login.php) is displayed if there is any -->
                
                <input type="submit" name="submit" class="btn" value="LOGIN" />
			</center>
              </form>
          </div>
       <div>
            <br/> <br/> <a class=" btn btn-info " href="signup.php" >Not a member? Sign up for an account now</a>
       </div>

</div> 
</div>






<footer class="footer">
    About us
  </footer>
</body>



</html>