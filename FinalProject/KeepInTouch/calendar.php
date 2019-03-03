<!-- Usage: echo calendar(10, 2014); // month, year[, timezone] (enter the timezone using standard PHP timezone strings) -->

<!-- Modified calendar based on free PHP source code availble at
      http://solletec.com/tag/calendar/ -->
<?php 

function calendar($m, $y, $timezone = 'America/Chicago') { 
// set your default timezone here
  $date = new DateTime('now', new DateTimeZone($timezone));
  $today = array('d' => $date->format('d'), 'm' => $date->format('m'), 'y' => $date->format('Y'));
  $date->setDate($y, $m, 1);
  
  if($today[1] === 1) {
    $prev_month = 12;
    $prev_year = $today[2]-1;
  } else {
    $prev_month = $today[1]-1;
    $prev_year = $today[2];
  }

  if($today[1] === 12) {
    $next_month = 1;
    $next_year = $today[2]+1;
  } else {
    $next_month = $today[1]+1;
    $next_year = $today[2];
  }

  $calendar = '
    <script src="calendar-scripts.js"></script>
    <div id="calendar">
    <table class="calendar">
      <tr class="month-heading">
        <th><button onclick="updateCalendar()">&#9664;</a></th>
        <th colspan="5" class="big">' . $date->modify('+1 month')->format('F Y') . '</th>
        <th><button onclick="updateCalendar()">&#9654;</a></th>
      </tr>
      <tr class="week-heading">
        <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
      </tr>
    ';

    //  $calendar = '
    // <script src="message-scripts.js"></script>
    // <div id="calendar">
    // <table class="calendar">
    //   <tr class="month-heading">
    //     <th><a class="prev" href="?m='.$date->modify('-1 month')->format('n').'&amp;y='.$date->format('Y').'">&#9664;</a></th>
    //     <th colspan="5" class="big">' . $date->modify('+1 month')->format('F Y') . '</th>
    //     <th><a class="next" href="?m='.$date->modify('+1 month')->format('n').'&amp;y='.$date->format('Y').'">&#9654;</a></th>
    //   </tr>
    //   <tr class="week-heading">
    //     <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
    //   </tr>
    // ';
  $month = array('this_month_start_dow' => $date->modify('-1 month')->format('w'), 'this_month_days' => $date->format('t'), 'prev_month_days' => $date->modify('-1 month')->format('t'));
  $days_arr = array();
  $day_ctr = -1;

  // previous month -->
  if ($month['this_month_start_dow'] > 0) 
  {
    for ($i = $month['this_month_start_dow'] - 1; $i >= 0; $i--) {
      $day_ctr += 1;
      $class = ($day_ctr % 7 == 0 || $day_ctr % 7 == 6) ? 'weekend-day other-month' : 'other-month'; // Sat/Sun
      $days_arr[] = '<td class="' . $class . '">' . ($month['prev_month_days'] - $i) . '</td>';
    }
  }

  // current month -->
  for ($i = 1; $i <= $month['this_month_days']; $i++) {
    $day_ctr += 1;
    $class = ($day_ctr % 7 == 0 || $day_ctr % 7 == 6) ? 'weekend-day' : ''; // Sat/Sun
    $class .= ($i == $today['d'] && $m == $today['m'] && $y == $today['y']) ? ' today' : ''; // today 
//    $days_arr[] = '<td class="' . $class . '">' . $i . '</td>';


    //Our unique filename convention
    $filename_str = $m.'-'.$i.'-'.$y;
    //$filename_str = '"2018-02-24-14-31-45-000 Professor Hwang.txt"';
    // $link_str = '<button script="message-scripts.js" onclick="myBtnClick(this)" name="'.$filename_str.'" class="btn_calendar">';
    $link_str = '<button script="message-scripts.js" onclick="loadCalendarFileList('.this.')" 
        data-day="'.$i.'" data-year="'.$y.'" data-month="'.$m.'" id="'.$filename_str.'" class="btn_calendar">';
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

  return $calendar;
}

?>
<!-- Add a bit of CSS -->

