<?php 
		$name = htmlspecialchars($_POST['name']);
		$topic = htmlspecialchars($_POST['topic']);
		$message = htmlspecialchars($_POST['message']);
		$replyMode = $_POST['flip-1'];

		$date = date("Y-m-d-H-i-s");
		$folder = $date . "folder";
		mkdir("./$folder", 0777, true);
		$file = "$folder/$date.txt";
		$out=fopen($file,'w')
			OR formError ("Can't open file.", "Something is wrong");

		$jd = gregoriantojd(date("m"),date("d"),date("Y"));
		$date2 = jdmonthname($jd,1) . date(" d, Y ") . "(" . date("H:i") . ")";

		fwrite($out, "$name \n");
		fwrite($out, "$topic\n");
		fwrite($out, "$date2\n");
		fwrite($out, "$replyMode\n");
		fwrite($out, "$message \n");
		fclose($out);	

		$message = "Post successfully made!";
		echo "<script type='text/javascript'>alert('$message');</script>";
		echo '<script>window.location.href="index.php";</script>';
?>