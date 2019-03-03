<?php

// cgi-handler.php

// compute year for copyright in response pages
// not superglobal, so still need to pass it into functions
$year = date("Y");
$int = 1;
function formError($errmsg, $msg, $year)
{
    // HERE document; everything to EOR; allows vars
    $errorResponse = <<<EOR
<!DOCTYPE html
<html lang="en">
<head>
    <title>Error In Form Submission</title>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="sticky.png">
    <link rel="stylesheet" type="text/css" href="board.css" />
    <style type="text/css">
      .content {margin: 10px;}
      .intro {font-style: italic;}
    </style>
</head>
<body>
<div id="wrapper">
   <header>
      <p style="margin: 0; font-size: 30pt; font-weight: bold; color: white">Message Board</p>
   </header>
   <section>
      <h1>Error in Form Submission</h1>
      <div class="content">
      <p>The following error was detected: </p>
      <h2> $errmsg </h2>
      <p> $msg </p>
      </div>
   </section>
      <footer>
	<p> &copy; $year
            Message Board</p>
      </footer>
</div>
</body>
</html>
EOR;

   print $errorResponse;
   exit();
}

// Read form data into local variables
// Form data is in $_POST['varname']
// htmlspecialchars encodes html punctuation to prevent injections
$name = htmlspecialchars($_POST['name']);

// Convert newlines into <br /> for echoing textareas
$subject = htmlspecialchars($_POST['subject']);

$message = htmlspecialchars($_POST['message']);

// Check for empty name or subject in case browser doesn't support HTML5 required
if ($name == "")
{
   formError("Name field is NULL", 
             "Please use the Back button to correct your form and resubmit",
             $year);
}
if ($subject == "")
{
   formError("Subject field is NULL", 
             "Please use the Back button to correct your form and resubmit",
             $year);
}

// Put data into a file: orders.txt; directory must exist for writing
//$outfile = fopen ("orders.txt", "a")  // open for append
//   OR formError ("Unable to open output file: orders.txt",
//                 "Please contact the admin.", $year);
$date = date("Y-m-d-H-i-s-v");
$ENV{path} = "/jd262/P1/";
$outfile = fopen ("$date $name.txt", "a");
fwrite($outfile, "$date \n");
fwrite($outfile, "Name: $name \n");
fwrite($outfile, "Subject: $subject \n");
fwrite(@$outfile,"Message: $message \n");
fwrite($outfile, "------------------------------------------\n");
fclose($outfile);
// Turn off PHP to send the response page
$int = $int + 1;
?>

<!DOCTYPE html>
<!-- This is the normal response page -->
<html lang="en">
<head>
    <title>Message Board - Your Message</title>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="sticky.png">
    <link rel="stylesheet" type="text/css" href="board.css" />
    <style type="text/css">
      .content {margin: 10px;}
      .intro {font-style: italic;}
    </style>
</head>
<body>
<div id="wrapper">
    <header>
 	<p style="margin: 0; font-size: 30pt; font-weight: bold; color: white">Message Board</p>
    </header>
    <section>
        <h1>Your Message</h1>
        <div class="content">
        <p>This is your message:</p>

<?php
print <<<EOF
    <p><strong>Name:</strong> $name</p>
    <p><strong>Subject:</strong>$subject</p>
    <p><strong>Message:</strong> <br />
    $message
    </p>
    

    <p><em>Go back and reload page to see messages</em></p>
    </div>
    </section>
    <footer>
	<p> &copy; $year Message Board</p>
    </footer>
EOF;
?>
</div>
</body>
</html>
