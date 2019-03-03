<?php

// CS 350 HW2 MessageBoard Prototype
// message-cgi.php
// CGI handler for message board forms

// compute year for copyright in response pages
// not superglobal, so still need to pass it into functions
$year = date("Y");

function formError($errmsg, $msg, $year)
{
    // HERE document; everything to EOR; allows vars
    // no spaces after EOR and EOR;
    $errorResponse = <<<EOR
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error In Form Submission</title>
    <meta charset="UTF-8">
    <meta name="author" content="Jim Allen">
    <link rel="stylesheet" type="text/css" href="message.css" />
</head>
<body>
<div id="wrapper">
   <section>
      <h1>Error in Form Submission</h1>
      <p>The following error was detected: </p>
      <h2> $errmsg </h2>
      <p> $msg </p>
   </section>
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
$topic = htmlspecialchars($_POST['topic']);
$message = htmlspecialchars($_POST['message']);

// Check for empty name or address in case browser doesn't support HTML5 required
if ($name == "")
{
   formError("Name field is NULL", 
             "Please use the Back button to correct your form and resubmit",
             $year);
}

if ($topic == "")
{
   formError("Topic field is NULL", 
             "Please use the Back button to correct your form and resubmit",
             $year);
}

if ($message == "")
{
   formError("Message field is NULL", 
             "Please use the Back button to correct your form and resubmit",
             $year);
}

// Put data into a file: orders.txt; file must be world writable
// directory must world writable to create file
$date = date("Y-m-d H:i:s");
$datenows = str_replace(' ','',$date);  // no whitespace for use in id and filenames

//$datetime = date_create();
//$date = date_timestamp_get($datetime);

$GLOBALS['filename'] = 'messages/'. $datenows . 'message.txt';
$fname = $GLOBALS['filename'];
$outfile = fopen($fname, "w")
  OR die ("Cannot open $fname");
fwrite($outfile, "Date: $date\n");
fwrite($outfile, "Name: $name\n");
fwrite($outfile, "Topic: $topic\n");
fwrite($outfile, "Message: $message\n");

// Turn off PHP to send the response page.
?>

<!DOCTYPE html>
<!-- This is the normal response page -->
<html lang="en">
  <head>
    <?php include "_header.html" ?>
    <title>Message Posted Successfully</title>

  </head>
  <body>
    <div class="msgList">
        <h3>Message Successfully Created</h3>
    </div>
    <section>
        <?php
          //include 'display-message.php';
          //$fname = $GLOBALS['filename'];
          //readMessageFromFile($fname);
        ?>
    </section>

    <script src="message-scripts.js"></script>

    <div>
      <footer>
        <?php include "_footer.html" ?>
      </footer>
    </div>
  </body>

</html>