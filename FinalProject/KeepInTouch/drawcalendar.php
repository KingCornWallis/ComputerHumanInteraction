<?php 
  session_start();
?>
<?php
  // if we are not logged in....
  if(!(isset($_SESSION['login_user']))) {
    header('Location: login.php');
  }

  $timezone = 'America/Chicago';

  // otherwise figure out our current month
  $parameter = escapeshellarg($_POST['command']);

  $date = $_SESSION['current_date'];


  $command = $_POST['command'];
  $calendar = "";
  switch($command) {
    case "PREVIOUS":
      $date->modify('-1 month');
      //$calendar .= "PREVIOUS:  ";
      break;
    case "NEXT":
      $date->modify('+1 month');
      //$calendar .= "NEXT: ";
      break;
    default:
      // nothing to do
      //$calendar .= "CURRENT:  ";
      break;
  }

  $day = $date->format('d');
  $month = $date->format('m');
  $year = $date->format('Y');

  $calendar .= '
    <div id="calendar">
    <table class="calendar">
      <tr class="month-heading">
        <th><button onclick="getCalendarPrevMonth()">&#9664;</th>
       <th colspan="5" class="big">' . $date->format('F Y') . '</th>
        <th><button onclick="getCalendarNextMonth()">&#9654;</th>
      </tr>
      <tr class="week-heading">
        <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
      </tr>
    ';

   $days_arr = array();
   $day_ctr = -1;

   $date->setDate($year, $month, 1);    // for our calculations, need to set the calendar date to the 1st of the current months
   $_SESSION['current_date'] = $date;   // store the date in the session variable

   $this_month_start_dow = $date->format('w');
   $this_month_days = $date->format('t');
   $prev_month_days = $date->modify('-1 month')->format('t');
   $date->modify('+1 month');     // reset the effect of the modify() on the previous line

  // previous month -->
  if ($this_month_start_dow > 0) 
  {
    for ($i = $this_month_start_dow - 1; $i >= 0; $i--) {
      $day_ctr += 1;
      $class = ($day_ctr % 7 == 0 || $day_ctr % 7 == 6) ? 'weekend-day other-month' : 'other-month'; // Sat/Sun
      $days_arr[] = '<td class="' . $class . '">' . ($prev_month_days - $i) . '</td>';
    }
  }

  // current month -->
  // get today's date
  $today = new DateTime('now', new DateTimeZone($timezone));
  // $calendar .= $today->format('m') . "/" . $today->format('d') . "/" . $today->format('Y');
  
  for ($i = 1; $i <= $this_month_days; $i++) {
    $day_ctr += 1;
    $class = ($day_ctr % 7 == 0 || $day_ctr % 7 == 6) ? 'weekend-day' : ''; // Sat/Sun
    $class .= ($i == $today->format('d') && $month == $today->format('m') && $year == $today->format('y')) ? ' today' : ''; // today 
 
  //   //Our unique filename convention
    $filename_str = $month.'-'.($i+1).'-'.$year;
    $link_str = '<button script="message-scripts.js" onclick="loadCalendarFileList('.this.')" 
        data-day="'.($i+1).'" data-year="'.$year.'" data-month="'.$month.'" id="'.$filename_str.'" class="btn_calendar">';
    $days_arr[] = '<td class="' . $class . '">' . $link_str. $i . '</button></td>';
   }

  // next month
  if (count($days_arr) % 7 != 0) {
    for ($i = 1; $i <= count($days_arr) % 7; $i++) {
      $day_ctr += 1;
      $class = ($day_ctr % 7 == 0 || $day_ctr % 7 == 6) ? 'weekend-day other-month' : 'other-month'; // Sat/Sun
      $days_arr[] = '<td class="' . $class . '">' . $i . '</td>';
    }
  }

  foreach ($days_arr as $k => $day) {
  //     $calendar .= $link_str . '</a>';
      $calendar .= (($k) % 7 == 0 ? '</tr><tr>' : '') . $day;
  }

  $calendar .= '</tr></table></div>';
      echo $calendar;

?>





