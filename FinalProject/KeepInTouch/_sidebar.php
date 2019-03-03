<!-- Sidebar -->
<div id="navbar" class="w3-sidebar w3-light-grey w3-bar-block" style="width:15%">
	<h3 class="w3-bar-item">Menu</h3>
	
	<a id="tabnav_1" href="login.php" class="w3-bar-item w3-button">
		<span class="glyphicon glyphicon-log-in"></span>  Login
	</a>

	<a id="tabnav_2" href="index.php" class="w3-bar-item w3-button"> 
		<i class="fa fa-home" style="font-size:24px"></i>  Home
	</a>

	<a id="tabnav_3" href="#" class="w3-bar-item w3-button"> 
		<i class="material-icons" style="font-size:24px">list</i>  Browse List
	</a>

	<a id="tabnav_4" href="#" class="w3-bar-item w3-button"> 
		<i class="fa fa-calendar" style="font-size:20px"></i>  Calendar
	</a>

	<?php 
		$authorized = $_SESSION['authorized'];

		if($authorized === "TRUE") {
			echo '<a id="tabnav_5" href="#" class="w3-bar-item w3-button">
			<i class="material-icons" style="font-size:24px">message</i>  Create Post</a>';
		}
	?>
	<a id="tabnav_6" href="#" class="w3-bar-item w3-button">
		<i class="material-icons" style="font-size:24px">info_outline</i>  About
	</a>
	
	<a id="tabnav_7" href="logout.php" class="w3-bar-item w3-button"> 
		<span class="glyphicon glyphicon-log-out"></span>  Logout
	</a>
</div>