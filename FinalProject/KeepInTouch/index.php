<?php
// Start the session
session_start();
// //Store session Data
?>
<?php
//$_SESSION['login_user']=$username; // Initializing session with value of PHP variable
//echo $_SESSION['login_user'];
	$username = $_SESSION['login_user'];
	$authorized = $_SESSION['authorized'];


	if(isset($_SESSION['login_user'])) {
		if($authorized === "TRUE")
			$str = '_teacher';
		else
			$str = '_student';
		echo '<div class="success_login'.$str.'"> Welcome back, '.$username.'</div>';
	} else {
		header('Location: login.php');
		echo '<div class="fail_login"> Login Required </div>';
	}
?>

<!DOCTYPE html>
<html lang="en">
<title>Keep In Touch</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="navigation.js"></script>
<style> 
section{
	margin-left:20px;
}
</style>
<script>
    window.onload = function () {
        var nav = document.getElementById("navbar");
        //var ul = nav.getElementsByTagName("ul")[0];
        var tabs = nav.getElementsByTagName("a");
        
        // set current tab
        var navitem = tabs[0];
        var ident = navitem.id.split("_")[1];  // number
        // HTML5 data-* attributes are non-presentation
        // parent of tabs hold identity of the current tab
        nav.setAttribute("data-current", ident);
        navitem.setAttribute("style",
        "background-color: teal; color: white;");
        
        // hide all but first page
        var pages = document.getElementsByTagName("section");
        for (var i = 1; i < pages.length; i++) {
            pages[i].style.display = "none";
        }
        
        // connect click handler to each tab
        for (var i = 0; i < tabs.length; i++) {
            tabs[i].onclick = displayPage;
        }
    }
</script>


	<!-- Include our header information -->
	 <?php include "_header.html" ?>
	<script src="calendar-scripts.js"></script>
	<body>
		<!-- Include our sidebar -->
		<?php include "_sidebar.php" ?>

		<!-- Page Content -->
		<!--<div style="margin-left:15%">-->
			<div class="w3-container w3-teal">
			  <!--<h1>Keep In Touch (tm)</h1>-->
			</div>

	<!-- Page Content -->
	<div style="margin-left:15%">
		<div class="w3-container w3-teal">
			<h1>Keep In Touch<sup>TM</sup></h1>
		</div>

		<section id="tabpage_1">
			<div class="w3-container">

				
				<h2>Announcements</h2>
					
				<?php
				foreach (glob("announcements/*.txt") as $file) {

					$contentString = file_get_contents($file);
					$content = explode("\n", $contentString);
					echo '<div class="well">
					<div>'
					.$content[1].
					'</div>
					<br>
					<div class="row">
					<div class="col-md-12 post-header-line">
						<span class="glyphicon glyphicon-calendar">'
						 .$content[0].	
					'</div>
					</div>
					</div>';
				}
				?>
				<?php 
					$authorized = $_SESSION['authorized'];
					$str = '<div class="create announcement" ';
						
					if($authorized === "FALSE") {
						$str .= 'hidden';
					}

					$str .= '>';
					echo $str;
				?>

				<form action="annouce-cgi.php" method="post">
					<br><label>Announcement:</label>
					<textarea rows="5" cols="50" class="form-control" style="width:80%" tname="announcement" required ></textarea><br>
					<input type="submit" name="submit_button" value="Post Annoucement" class="w3-button w3-teal w3-round-large"/>
					<input type="reset" value="Reset" class="w3-button w3-teal w3-round-large"/>
				</form>

			</div>
			<br>
				<div>
					<h2>Today's Posts</h2>
					<!--<table>
						<tr>
							<td>USER ICON</td>
							<td></td>
							<td>MOST RECENT MESSAGE  (date, subject, message)</td>
						</tr>
					</table>-->
					<?php
						$parent_count = 0;
						$date = date("Y-m-d");
							foreach (glob("*folder") as $folder) {
							$count = 0;	
							$count2 = 0;						
							foreach (glob($folder."/$date*.txt") as $file) {
							if($count==0) {
								echo '<div class="parent_file">'.nl2br(file_get_contents($file)).'</div>';
								echo '</p>';
								$parent_count++;
								} else {
										if($count2%2 == 0)
											echo '<div class="reply_file">'.nl2br(file_get_contents($file)).'</div>';
										else
											echo '<div class="reply_file2">'.nl2br(file_get_contents($file)).'</div>';
										$count2++;
									}
									$count++;
								}
								//echo '<hr>';
							}
						?>
				</div>
			</div> 
		</section>

		<section id="tabpage_3">
			
			<hr>
			
				<script>
					// Lists the files when a calendar button is hit
					function loadCalendarFileList(element){
						var obj = document.getElementById(element.id);
						var d=obj.getAttribute('data-day');
						var m=obj.getAttribute('data-month');
						var y=obj.getAttribute('data-year');

						var result="<?php listFolderMessages();?>";
						//var result=myTest("31","42","56");
						var result=myTest(y,m,d);

						document.getElementById("filelist").innerHTML = result;
						//alert(result);
						return false;
					}

					// Lists all the files when a button is hit.
					function loadFileList() {
						var result="<?php listAllMessages();?>";
						document.getElementById("calendar_list").innerHTML = result;
						//alert(result);
						return false;
					}

					function myTest(d,m,y) {
						var stringdata = d+"-"+m+"-"+y;
						var xhttp = new XMLHttpRequest();
						xhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								document.getElementById("filelist").innerHTML = this.responseText;
							}
						};
						//xhttp.open("GET", "ajax_info.txt", true);
						xhttp.open("POST", "calendar-listfile.php", true);

						//Create the Form Data and append our stringdata
						var params = new FormData;
						params.append('command', stringdata);
						xhttp.send(params);
					}

					// cancelReply(), bindToCancel(), and ReplyMsg all used by the REPLY button in the Browse list.
					function cancelReply(count,folder){
						var replyBoxID = "replyBox"+count;
						var str1 = '<p id="'+replyBoxID+'">';
						var cancelStr = str1 + 
							'<button type="button" class="w3-button w3-teal w3-round-large" ' +
							'onclick="replyMsg(\''+count+'\',\''+folder+'\')">Reply  <i class="fa fa-reply"></i></button></p>';
						
						document.getElementById(replyBoxID).innerHTML=cancelStr;
					}

					function bindToCancel() {
						document.getElementById("cancel_button").onclick = function(e) {
								e.preventDefault();

								var count = e.target.getAttribute('data-count');
								var folder = e.target.getAttribute('data-folder');

								cancelReply(count, folder);
								return false;
						}
					}

					function replyMsg(count,folder) {
						//id of object that called is replyBox<count>
						var replyStrNum = "replyBox"+count;
						var str = '<form action="reply-cgi.php" method="post">'+
							'<input type="hidden" name="folder" value="'+folder+'" />' +
							'<label>Username:</label>' +
							'<input type="text" class="form-control" style="width:40%" name="username" required autofocus /><br>' +
							'<label>REPLY:</label>' +
							'<textarea class="form-control" rows="4" cols="25" style="width:40%" name="reply" required autofocus></textarea><br>' +
							'<input type="submit" name="submit_button" value="Post Reply" class="w3-button w3-teal w3-round w3-tiny"/>'+
							'<input type="reset" value="Reset" class="w3-button w3-teal w3-round w3-tiny"/>'+
							'<button id="cancel_button" class="w3-button w3-teal w3-round w3-tiny" data-count="' + count + '" data-folder="' + folder + '">Cancel</button>' +
							'</form>'
							;
						document.getElementById(replyStrNum).innerHTML = str;
						bindToCancel();

					}
				</script>

				<!-- Attempt to call PHP function from javascript with a button -->
				<div>
					<?php
						function listAllMessages()
						{
							$str="";
							$parent_count=0;
							foreach (glob("*folder") as $folder) 
							{
								//$str .= "FOLDERNAME: ".$folder;
								$count = 0;	
								$str2="";
								foreach (glob($folder."/*.txt") as $file) 
								{
									if($count==0) 
									{
										//$str2 .= '<div class="parent_topic">';
										$filename = substr($file, strlen($folder)+1);
										$str2 .= 'Topic:        ' .$filename.'<br>';
										//$str2 .= '</div>';
									} else {
										$filename = substr($file, strlen($folder)+1);
										$str2 .= '--- Reply (' . $count. '):      ' . $filename.'<br>';
									}
									$count++;
								}
								$str .= $str2;
								$str .= '<hr>';
								$parent_count++;
							} 
							echo $str;
						}

						function listFolderMessages()
						{
							echo "Bob";
						}
					?>
				</div>

				<div id="browseList">
					<h2>All Messages</h2>

					<?php
						$parent_count = 0;
						foreach (glob("*folder") as $folder) {
							$count = 0;	
							$count2 = 0;						
							foreach (glob($folder."/*.txt") as $file) {
								if($count==0) {
									$contentString = file_get_contents($file);
									$content = explode("\n", $contentString);

									echo '<div class="well" style="width:90%">';
									echo '<div>
										    <h3>'.$content[1].' </h3>
											<div class="row">
												<div class="col-md-12 post-header-line">
													<span class="glyphicon glyphicon-user"></span>
													by <a>'.$content[0].'</a> | <span class="glyphicon glyphicon-calendar">
													</span>'.$content[2]. '
												</div>
											</div>
										  </div>
										   <hr>';
									echo '<div>';
									for( $i=4; $i < count($content); $i++){
										echo '<p>'. $content[$i] .'</p>';
									} 
									echo '</div>';
									//reply button
									if($content[3] == "on"){
										echo '<p id="replyBox'.$parent_count.'">';
										echo '<br><br>
											<button type="button" class="w3-button w3-teal w3-round-large" onclick="replyMsg(
											'.$parent_count.',\''.$folder.'\')">Reply <i class="fa fa-reply"></i></button>';
										echo '</p>';
									}else{
										echo '<br> <i class="fa fa-lock" style="font-size:15px"> Locked</i>
										<p></p>';
									}
									
									
									$parent_count++;
								} else {
									if($count2%2 == 0){
										$contentString2 = file_get_contents($file);
										$content2 = explode("\n", $contentString2);
										echo '<div class="reply_file">';
										for( $i=3; $i < count($content); $i++){
											echo '<p>'. $content2[$i] .'</p>';
										} 
										echo '<div class="row post-content"></div>
											<div class="row">
												<div class="col-md-12 post-header-line">
													<span class="glyphicon glyphicon-user"></span>
													by <a>'.$content2[0].'</a> | <span class="glyphicon glyphicon-calendar">
													</span>'.$content2[1]. '
												</div>
											</div>
											</div>
											<br>';
									}
									else{
										
										$contentString2 = file_get_contents($file);
										$content2 = explode("\n", $contentString2);
										echo '<div class="reply_file">';
										for( $i=3; $i < count($content); $i++){
											echo '<p>'. $content2[$i] .'</p>';
										}
										echo '<div class="row">
												<div class="col-md-12 post-header-line">
													<span class="glyphicon glyphicon-user"></span>
													by <a>'.$content2[0].'</a> | <span class="glyphicon glyphicon-calendar">
													</span>'.$content2[1]. '
												</div>
											</div>
											</div>
											<br>';
									}
									$count2++;
								}
								$count++;
							
							}
							echo '</div>';
						}
					?>
				</div>
		</section>


		<section id="tabpage_5">
			<div>
				<?php 
					$authorized = $_SESSION['authorized'];
					$str = '<div class="create post" ';
					
					if($authorized === "FALSE") {
						$str .= 'hidden';
					}

					$str .= '>';
					echo $str;
				?>

				<form action="message2-cgi.php" method="post">
					<div>
						<h2>Post a message</h2>
						<div>
							<label for="flip-1">Reply:</label>
							<select name="flip-1" id="flip-1" data-role="slider" class="selectpicker">
								<option value="on">On</option>
								<option value="off">Off</option>
							</select>
						</div>
						<div style="width:70%">	
							<div>						
							<label>Name: </label>
							<input id="name" type="text" class="form-control" name="name" required autofocus/>	
							</div>

							<div>
							<label>Topic: </label>
							<input id="topic" type="text" class="form-control" name="topic" required />		
							</div>
					
							<div>
							<label>Message: </label>
							<textarea id="message" class="form-control" rows="10" cols="100" name="message" required ></textarea>					
							</div>

							<br>
							<input type ="submit" onclick="showMessage()" value ="Create message" class="w3-button w3-teal w3-round-large"/>
							<input type ="reset" value ="Reset form" class="w3-button w3-teal w3-round-large"/>

						</div>

					</div>
				</form>
			</div>
		</section>

			

		<section id="tabpage_4">
			<h2>Calendar</h2>
						<!-- Our PHP Calendar.  Click on the day will search for a matching folder.... -->
			<!--<?php 
				$authorized = $_SESSION['authorized'];
				$str = '<div class="create event" ';
								
				if($authorized === "FALSE") {
				$str .= 'hidden';

				$str .= '>';
				echo $str;
				}
			?>
			<form action="event-cgi.php" method="post">
				<br><label>Event:</label>
				<input type="date" name="date">
				<textarea rows="1" cols="50" name="event" required ></textarea><br>
				<input type="submit" name="submit_button" value="Add Event" class="w3-button w3-teal w3-round-large"/>
				<input type="reset" value="Reset" class="w3-button w3-teal w3-round-large"/>
			</form>

			</div>-->
			<div>
			<table class="calendar_background">
				<tr>
					<td align="left" id="calendar_test">
						<p id="calendar_test">Calendar Text Here</p>

						<!-- <input type="button" onclick="getCalendarPrevMonth()" name="P" value="P"> -->
						<input type="button" onclick="getCalendarCurrentMonth()" name="Display Calendar" value="Display Calendar">
						<!-- <input type="button" onclick="getCalendarNextMonth()" name="N" value="N">					 -->
					</td>
					<td>
						Messages
						<p id="filelist">No messages for this day</p>
					</td>
				</tr>
			</table>
			</div>
		</section>


		<section id="tabpage_6">
			<h3> Keep In Touch is designed to make communication between students and teachers easier </h3>
		</section>


		<section id="tabpage_7">
			<h1> LOGOUT HERE </h1>
		</section>	

			</div>
		</div>     
	</div>    
</body>
	<!-- iframe needed to keep the reply form from redirecting the page -->
	<iframe name="hiddenFrame" width="0" height="0" style="display: none;"></iframe>
</html>
