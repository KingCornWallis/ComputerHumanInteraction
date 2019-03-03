<?php 
	$username = htmlspecialchars($_POST['username']);
	$reply = htmlspecialchars($_POST['reply']);
	$folder = htmlspecialchars($_POST['folder']);

	$date = date("Y-m-d-H-i-s");
	$file = "$folder/$date.txt";
	$out=fopen($file,'w')
		OR formError ("Can't open file.", "Something is wrong");

	$jd = gregoriantojd(date("m"),date("d"),date("Y"));
	$date2 = jdmonthname($jd,1) . date(" d, Y ") . "(" . date("H:i") . ")";

	fwrite($out, "$username \n");
	fwrite($out, "$date2 \n\n");
	fwrite($out, "$reply \n");
	fclose($out);	

	$message = "Reply successfully made!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo '<script>window.location.href="index.php";</script>';
?>