<?php
	include_once ('../../mainfile.php');
	$url=XOOPS_URL;
echo <<< EOF
<script type='text/javascript'>
function init()
{
	url='$url/modules/simfworker/';
	//Main Menu items:
	menus[0] = new menu(22, "horizontal", 0, 0, -2, -2, "#ffd9c5", "#0000A0", "Times", 9, 
		"bold", "bold", "black", "white", 1, "gray", 2, "rollover:images/tri-down1.gif:images/tri-down2.gif", false, true, true, true, 12, true, 4, 4, "black");
	menus[0].addItem(url, "", 100, "center", "Home", 0);
	menus[0].addItem("#", "", 120, "center", "Master Data", 1);
	menus[0].addItem("#", "", 100, "center", "Transaction", 2);
	menus[0].addItem("#", "", 110, "center", "Supports", 3);

//Sub Menu for 2nd Main Menu Item ("Master"):
	menus[1] = new menu(300, "vertical", 0, 0, -5, -5, "#ffd9c5", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");
	menus[1].addItem(url+'/races.php', "", 22, "left", "Add & Edit Races", 0);
	menus[1].addItem(url+'/nationality.php', "", 22, "left", "Add & Edit Nationality", 0);
	menus[1].addItem(url+'/currency.php', "", 22, "left", "Add & Edit Currency", 0);
	menus[1].addItem(url+'/company.php', "", 22, "left", "Add & Edit Customer", 0);
	menus[1].addItem(url+'/worker.php', "", 22, "left", "Add & Edit Worker", 0);

//Sub Menu for 3rd Main Menu Item ("Transaction"):
	menus[2] = new menu(300, "vertical", 0, 0, -5, -5, "#ffd9c5", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");
	menus[2].addItem(url+'/checkup.php', "", 22, "left", "Medical Checkup", 0);
	menus[2].addItem(url+'/workpermit.php', "", 22, "left", "Work Permit", 0);



//Sub Menu for 4th Main Menu Item ("Reports"):
	menus[3] = new menu(300, "vertical", 0, 0, -5, -5, "#ffd9c5", "#0000A0", "Times", 9, "bold", 
		"bold", "black", "white", 1, "gray", 2, 62, false, true, false, true, 6, true, 4, 4, "black");
	menus[3].addItem('aboutus.php', "", 22, "left", "About Us", 0);
	menus[3].addItem('license.txt', "", 22, "left", "License under GNU/GPL V3", 0);

	onOpen();
} //OUTER CLOSING BRACKET. EVERYTHING ADDED MUST BE ABOVE THIS LINE.

function IsNumeric(sText)
{
   var ValidChars = "0123456789.-";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         IsNumber = false;
         }
      }
   return IsNumber;
   
   }


function isDate(dateStr) {

	var datePat = /^(\d{4})(\/|-)(\d{1,2})(\/|-)(\d{1,2})$/;
	var matchArray = dateStr.match(datePat); // is the format ok?

	if (matchArray == null) {
		alert("Please enter date as YYYY-MM-DD.");
		return false;
		}

	month = matchArray[4]; // p@rse date into variables
	day = matchArray[7];
	year = matchArray[1];

	if (month < 1 || month > 12) { // check month range
		alert("Month must be between 1 and 12.");
		return false;
	}

	if (day < 1 || day > 31) {
		alert("Day must be between 1 and 31.");
		return false;
	}

	if ((month==4 || month==6 || month==9 || month==11) && day==31) {
		alert("Month "+month+" doesn`t have 31 days!")
		return false;
	}

	if (month == 2) { // check for february 29th
		var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
		if (day > 29 || (day==29 && !isleap)) {
			alert("February " + year + " doesn`t have " + day + " days!");
			return false;
		}
	}
	return true; // date is valid
}


</script>
EOF;
?>

