function openClose(id)
	{
		var obj = "";	

		// Check browser compatibility
		if(document.getElementById)
			obj = document.getElementById(id).style;
		else if(document.all)
			obj = document.all[id];
		else if(document.layers)
			obj = document.layers[id];
		else
			return 1;
			
		// Do the magic :)
		if(obj.display == "")
			obj.display = "none";
		else if(obj.display != "none")
			obj.display = "none";
		else
			obj.display = "block";
	}
function CloseClose(id)
	{
		var obj = "";	

		// Check browser compatibility
		if(document.getElementById)
			obj = document.getElementById(id).style;
		else if(document.all)
			obj = document.all[id];
		else if(document.layers)
			obj = document.layers[id];
		else
			return 1;
			
		// Do the magic :)
		if(obj.display == "")
			obj.display = "none";
		else if(obj.display != "none")
			obj.display = "none";
		else
			obj.display = "none";
	}


function OpenOpen(id)
	{
		var obj = "";	

		// Check browser compatibility
		if(document.getElementById)
			obj = document.getElementById(id).style;
		else if(document.all)
			obj = document.all[id];
		else if(document.layers)
			obj = document.layers[id];
		else
			return 1;
			
		// Do the magic :)
		if(obj.display == "")
			obj.display = "block";
		else if(obj.display != "none")
			obj.display = "block";
		else
			obj.display = "block";
	}

function doClear(theText) {
     if (theText.value == theText.defaultValue) {
         theText.value = ""
     }
 }
function ClockTimeZone() {
  var TimezoneOffset = 3 // указать нужное смещение по Гринвичу
  var localTime = new Date();
  var ms = localTime.getTime() + (localTime.getTimezoneOffset() * 60000) + TimezoneOffset * 3600000;
  var time = new Date(ms); 
  var hour = time.getHours(); 
  var minute = time.getMinutes();
  var second = time.getSeconds();
  var temp = "" + ((hour < 10) ? "0" : "") + hour;
  temp += ((minute < 10) ? ":0" : ":") + minute;
  temp += ((second < 10) ? ":0" : ":") + second;
  document.getElementById('clock').innerHTML = temp;
  setTimeout("ClockTimeZone()",1000);
}
onload = ClockTimeZone;
