<!DOCTYPE html> <!-- HTML5 -->

<!-- IE doesn't like comments before <!DOCTYPE html> 

     Webserver serves PHP pages as is unless PHP code is encountered
  -->

<html lang="en">
  <head>
    <title>Message Board</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="sticky.png">
    <link rel="stylesheet" type="text/css" href="board.css" />
    <style type="text/css">
      .content {margin: 15px;}
      .intro {font-style: italic;}
    </style>
    <script src="board.js"></script>
    <script>
      window.onload = function () {
         var nav = document.getElementsByTagName("nav")[0];
         var ul = nav.getElementsByTagName("ul")[0];
         var tabs = ul.getElementsByTagName("li");

         // set current tab
         var navitem = tabs[0];
         var ident = navitem.id.split("_")[1];  // number
         // HTML5 data-* attributes are non-presentation
         // parent of tabs hold identity of the current tab
         ul.setAttribute("data-current", ident);  
         navitem.setAttribute("style", 
             "background-color: Darkblue: color: white;");
      
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
  </head>

  <body>
    <div id="wrapper"><!-- so bkgnd can be moved independent of contents -->
      <header>
	<p style="margin: 0; font-size: 30pt; font-weight: bold;
	          color: white">Message Board</p>
      </header>
      <nav>
	<ul>
	  <li id="tabnav_1">List</li>
	  <li id="tabnav_2">New Message</li>
	  <li id="tabnav_3">About</li>
	</ul>
      </nav>

      <section id="tabpage_1">
	<h1>Message List</h1>

	<div class="content">
	<p class="intro">This list displays all messages.</p>
	<?php
	foreach (glob("*.txt") as $filename) 
	{   
		
    	$file = $filename;
    	$contents = file($file); 
    	$string = implode("\n", $contents); 
    	echo "<pre>".$string."</pre>";
    	// "<br></br>";
	}
	?>
	</div> <!-- end content -->
      </section> <!-- end home -->

      <section  id="tabpage_2">
	<h1>
	 Archived Messages</h1>
	<div class="content">
	<p class="intro">Enter your message below. Fields marked
	with <span class="alert">*</span> are required.</p>
	<form action="cgi-handler.php" method="post">
	  <div class="floatleft">
	  <table>
	    <tr>
	      <td><label>Name<span class="alert">*</span>:</label></td>
	      <td><input type="text" name="name" autofocus size="97"
	      /></td>
	    </tr>
	    <tr>
	      <td><label>Subject<span class="alert">*</span>:</label></td>
	      <td><input type="text" name="subject" size="97"
	      /></td>
	    </tr>
	    <tr>
	      <td><label>Message:</label></td>
	      <td><textarea rows="10" cols="95" name="message"
	       required ></textarea></td>
	    </tr>
	    
	  </table>
	  </div> <!-- end leftside -->
	  
	  <div style="padding-top: 10px; clear: both; text-align:
	    center;">
	  <p>
	    <input type="submit" value="Submit message" />
	    <input type="reset"  value="Reset" />
	  </p>
	  </div> <!-- end buttons -->
	</form>
	</div> <!-- end content -->
      </section> <!-- end order -->

  <section id="tabpage_3">
	<h1>About this Message Board </h1>
	<div class="content">
	<p class="intro">Jacob Darabaris</p>
	<p class="intro">CS350</p>
	<p class="intro">2/15/18</p>
	</div> <!-- end content -->
      </section> <!-- end about -->

      <footer>
	<!-- replace JavaScript with PHP -->
	<p> &copy; <?php print date("Y"); ?>
            </p>
      </footer>
    </div> <!-- end wrapper -->

  </body>
</html>