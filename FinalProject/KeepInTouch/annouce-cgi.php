<?php 
	$announcement = htmlspecialchars($_POST['announcement']);

	$date = date("Y-m-d-H-i-s");
	$file = "./announcements/$date.txt";
	$out=fopen($file,'w')
		OR formError ("Can't open file.", "Something is wrong");

	$jd = gregoriantojd(date("m"),date("d"),date("Y"));
	$date2 = jdmonthname($jd,1) . date(" d, Y ") . "(" . date("H:i") . ")";

	fwrite($out, "$date2\n");
	fwrite($out, "$announcement");
	fclose($out);	

	$message = "Annoucement successfully posted!";
	echo "<script type='text/javascript'>alert('$message');</script>";
	echo '<script>window.location.href="index.php";</script>';
?>