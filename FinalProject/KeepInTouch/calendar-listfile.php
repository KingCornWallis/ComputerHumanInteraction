<?php
	$parameter = escapeshellarg($_POST['command']);

	$year = substr($parameter,1,4);  // 0 element is an ' character  
	$month = substr($parameter,6,2);
	$length = strlen($parameter);
	$day = substr($parameter,9, $length)-1;  // -1 here to strip the last ' from the end of the file

	// need to correct the day if it is single digit so that it is two characters long.
	$day_asnumber = (int)$day;
	if($day_asnumber < 10) {
		$day = "0".$day;
	}
	// echo $year."<br>";
	// echo $month."<br>";
	// echo $day."<br>";
	// echo "Inside calendar-listfile.php  ".$parameter."<br>";

	$fileprefix = $year."-".$month."-".$day;
	//echo "Fileprefix: ".$fileprefix."<br>";

	$filestring = listDateMessages($fileprefix);
	echo $filestring;




	// Function to list all the messages of a specific day, month, and year
	function listDateMessages($fileprefix)
	{
		$found = false;
		//$str= "Date: ".$fileprefix."<br>";
		$parent_count=0;
		foreach (glob("*folder") as $folder) 
		{
			//			$str .= "FOLDERNAME: ".$folder."<br>";
			//			$str .= "PREFIX: ".$fileprefix."<br>";
			if(strpos($folder, $fileprefix)!== false)
			{
				$count = 0;	
				$str2="";
				foreach (glob($folder."/*.txt") as $file) 
				{
					if($count==0) 
				 	{
						$filename = substr($file, strlen($folder)+1);
						//$str2 .= 'Topic:    '.$filename.'<br>';
					} else {
						$str2 .= "<br>";
						$filename = substr($file, strlen($folder)+1);
						//$str2 .= '---Reply ('.$count.'):     '.$filename.'<br>';
						$str2 .= '---Reply ('.$count.'):     '.'<br>';
						
						//readMessageFromFile($file);
				 	}
				 	$str2 .= nl2br(file_get_contents($file))."<br>";
				 	$count++;
				}
				$str .= $str2;
				$str .= '<hr>';
				$found = true;
			} else {
				//				$str.= "Match not found"."<br>";
				continue;
				
			}

		} 
		if($found) {
			return $str;
		} else {
			return "No files match selected date of ".$fileprefix;
		}
	}

	// function readMessageFromFile($filename) 
	// {
	// 	// $msgStr = explode("messages/",$filename);
	// 	// $msgName = (substr($msgStr[1], 0, -4)); // chop off the .txt extension from the filename

	// 	// Read the file data
	//     $handle = fopen($filename, "r")
	//       OR die ("Error could not open file: $filename");
	//     $date = fgets($handle);
	//     $author = fgets($handle);
	//     $subject = fgets($handle);
	//     $message = fgets($handle);

	//  	// Create our display button
	// 	$str = "\n<tr><td><button onclick='showMsg(\"$filename"."ID\");' >".$filename."</button></td>\n";

 //         // Display the subject
 //         $strSubjectID = $subject;
 //  //       //$str2 = "<td><div id=\"".$strSubjectID."\">$strSubjectID"."</p></td>\n";
	// 	 $str2 = "<td><div id=\"".$filename."\">$strSubjectID"."</div></td>\n";

 //  //       // load each message, but make it hidden initially
	// 	$str3 = "<td><div><p id=\"$filename"."ID\" style=\"display:none;\">\n" . displayMessage($date, $author, $subject, $message) 
	// 		. "</p></div></td></tr>";

	// 	return ($str . $str2 . $str3);
	// }

	// function displayMessage($st1, $st2, $st3, $st4){
	//     $v1 = $st1."<br />";
	//     $v2 = $st2."<br />";
	//     $v3 = $st3."<br />";
	//     $v4 = "<br />";
	//     $v5 =  $st4."<br />";
	//     return $v1 . $v2 . $v3 . $v4 . $v5;
	// }






?>