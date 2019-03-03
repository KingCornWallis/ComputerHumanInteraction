<?php
// Start the session
session_start();
// //Store session Data
?>

<!DOCTYPE html>
	<html lang="en">
	<title>Keep In Touch</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <div class="w3-container w3-teal w3-center">
   <h1>Keep In Touch<sup>TM</sup></h1>
  </div>


<form action="validate.php" method="post" style="max-width:500px;margin:auto">

  <h2>Please enter your login information:</h2>


  <div class="jit-input-container">
    <i class="fa fa-user jit-icon"></i>
    <input class="jit-input-field" type="text" placeholder="Username" name="username" required autofocus />
  </div>

  <div class="jit-input-container">
    <i class="fa fa-key jit-icon"></i>
    <input class="jit-input-field" type="password" placeholder="Password" name="password" required/>
  </div>

  <button type="submit" value="Login" class="jit-btn">Login</button>
</form>

  <div class="w3-container" style="color: red; margin:auto; width:500px"> 
	
	<?php
		if(isset($_SESSION['message'])){
		echo $_SESSION['message'];
		unset($_SESSION['message']);
	}				
	?>					
  </div>
</html>

