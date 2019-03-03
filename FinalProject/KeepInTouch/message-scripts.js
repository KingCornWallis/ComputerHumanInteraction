function showMsgHover(text,status) {
  var x = document.getElementById(text);
  showMsg(text);
}

function showMsg(text) {
  var x = document.getElementById(text);
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function createFilename(yr, mo, day, hr, min, sec, micro, author) {
	return yr + "-" + mo + "-" + day + "-" + hr + "-" + min + "-" + sec + "-" + micro + " " + author + ".txt";
	//return str;
}

function extractDateArray(filename) {
	var arrDate = [];
	arrDate[0] = filename.substring(0,4); 	// Year
	arrDate[1] = filename.substring(5,7); 	// Month
	arrDate[2] = filename.substring(8,10);	// Day
	arrDate[3] = filename.substring(11,13); // Hour
	arrDate[4] = filename.substring(14,16); // Minute
	arrDate[5] = filename.substring(17,19); // Second
	arrDate[6] = filename.substring(20,23); // Microsecond
	arrDate[7] = filename.substring(24, (filename.length-4)); // Author
	return arrDate;
}

// filename format is yyyy-mm-dd-hh-mm-ss-aaa-<author name>
function printDateFromFilename(filename) {
	var arrDate = extractDateArray(filename);
	var str = "";
	for (var i = 0, len = arrDate.length; i < len; i++){
		str += "<br>"+ arrDate[i];
	}

	return str;
}


function myBtnClick(element) {
	var x = document.getElementById("filelist");
	//var str = element.name;
	var filename1 = "2018-02-24-14-31-45-000 Professor Hwang.txt";
	var filename2 = "2018-02-24-14-32-19-000 Jacob Darabaris.txt";
	var filename3 = createFilename(2018,02,24,14,32,19,"000","Jacob Darabaris");

	x.innerHTML = "TextChanged -- triggered by " + 
		element.name + "<br>" +
		filename1 +
		printDateFromFilename(filename1) + "<br>" + 
		filename2 +
		printDateFromFilename(filename2) + "<br>" +
		filename3;

	// Logic here to parse the directory?  Or should this be on the PHP server side?
}