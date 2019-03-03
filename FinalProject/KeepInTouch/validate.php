<?php
// Start the session
session_start();
// //Store session Data
?>
<?php
	// echo "Validating...";

	$username = $_POST['username'];
	$password = $_POST['password'];

	// set our current date into a session parameter
	$timezone = 'America/Chicago';
  	$date = new DateTime('now', new DateTimeZone($timezone));
  	$_SESSION['current_date'] = $date;
	$_SESSION['message'] = '';

	// echo $username;
	// echo $password;

	//These are our two test cases.  In a real world, this would link to a database, but for now this 
	// is just a proof of concept system.
	if(($username == "Teacher1") && ($password == "1234")) {
		$_SESSION['login_user']=$username;
		$_SESSION['authorized']="TRUE";  // user is authorize to make posts
		header('Location: index.php');
		echo "Found a teacher";
	} else if(($username == "Student1") && ($password == "5678")) {
		$_SESSION['login_user']=$username;
		$_SESSION['authorized']="FALSE";
		header('Location: index.php');
		echo "Found a student";
	} else {
		$_SESSION['message'] = 'The username or password you entered is incorrect.';
		header('Location: login.php');		
	}
?>
