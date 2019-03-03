function postCalendar(command) {
	var stringdata = command;
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
    		document.getElementById("calendar_test").innerHTML = this.responseText;
    	}
    };
  //xhttp.open("GET", "ajax_info.txt", true);
  xhttp.open("POST", "drawcalendar.php", true);

  //Create the Form Data and append our stringdata
  var params = new FormData;
  params.append('command', stringdata);
  xhttp.send(params);
}

function getCalendarPrevMonth() {
	var stringdata = "PREVIOUS";
	postCalendar(stringdata);

}

function getCalendarNextMonth() {
	var stringdata = "NEXT";
	postCalendar(stringdata);
}

function getCalendarCurrentMonth() {
	var stringdata = "CURRENT";
	postCalendar(stringdata);
}