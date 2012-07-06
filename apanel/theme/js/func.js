function submitform(id)
{
    document.forms[id].submit();
}
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
			obj.display = "block";
		else if(obj.display != "none")
			obj.display = "none";
		else
			obj.display = "block";
	}
function openClose2(id)
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
function cc(id)
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


function oo(id)
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
  var TimezoneOffset = 3 // ??????? ?????? ???????? ?? ????????
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
//onload = ClockTimeZone;


function testcheck()
{
if (!document.getElementById('rules').checked)
{alert("Вы должны согласится с правилами сервиса!");return false;}
return true;
}

function showtab2(id){
names = new Array ("tabname_1","tabname_2"); 
conts= new Array ("tabcontent_1","tabcontent_2");
for(i=0;i<names.length;i++) {
document.getElementById(names[i]).className = 'nonactive';
}
for(i=0;i<conts.length;i++) {
document.getElementById(conts[i]).className = 'hide';
}
document.getElementById('tabname_' + id).className = 'active';
document.getElementById('tabcontent_' + id).className = 'show';
}

function showtabnew(idd,idblock,counttab)
	{
	for(i=1;i<=counttab;i++) 
		{
		document.getElementById('id' + idblock + '_tabname_' + i).className = 'id'+idblock+'_nonactive';
		}
	for(i=1;i<=counttab;i++) 
		{
		document.getElementById('id' + idblock + '_tabcontent_' + i).className = 'hide';
		}
	document.getElementById('id' + idblock + '_tabname_' + idd).className = 'id' + idblock + '_active';
	document.getElementById('id' + idblock + '_tabcontent_' + idd).className = 'show';
	}
function setHome(ob) {
ob.style.behavior='url(#default#homepage)';
ob.setHomePage(document.location);
} 

function textCounter( field, countfield, maxlimit ) {
  if ( field.value.length > maxlimit )
  {
    field.value = field.value.substring( 0, maxlimit );
    alert( 'Каксимальное кол-во символов - 2000' );
    return false;
  }
  else
  {
    $(countfield).update(maxlimit - field.value.length);
  }
}

function testcheck2(id)
{
if (!document.getElementById('rules'+id).checked)
{alert("Вы должны согласится с правилами сервиса!");return false;}
return true;
}

// ставим куку
function setCookie(name, value) {
      var valueEscaped = escape(value);
      var expiresDate = new Date();
      expiresDate.setTime(expiresDate.getTime() + 365 * 24 * 60 * 60 * 1000); // ёЁюъ - 1 уюф, эю хую ьюцэю шчьхэшЄ№
      var expires = expiresDate.toGMTString();
      var newCookie = name + "=" + valueEscaped + "; path=/; expires=" + expires;
      if (valueEscaped.length <= 4000) document.cookie = newCookie + ";";
} 
function regUpen(el)
  {
	disState = el.options[el.selectedIndex].value;
	setCookie('regup',disState);
  }
function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}
function set_cookie(name, value, expires)
	{
	if (!expires)
		{
		expires = new Date();
		}
	document.cookie = name + "=" + escape(value) + "; expires=" + expires.toGMTString() +  "; path=/";
	}
var countOfFields = 1; // Текущее число полей
var curFieldNameId = 1; // Уникальное значение для атрибута name
var maxFieldLimit = 9; // Максимальное число возможных полей
function deleteField(a) {
    // Получаем доступ к ДИВу, содержащему поле
    var contDiv = a.parentNode;
    // Удаляем этот ДИВ из DOM-дерева
    contDiv.parentNode.removeChild(contDiv);
    // Уменьшаем значение текущего числа полей
    countOfFields--;
    // Возвращаем false, чтобы не было перехода по сслыке
    return false;
}
function addField() {
    // Проверяем, не достигло ли число полей максимума
    if (countOfFields >= maxFieldLimit) {
        alert("Число полей достигло своего максимума = " + maxFieldLimit);
        return false;
    }
    // Увеличиваем текущее значение числа полей
    countOfFields++;
    // Увеличиваем ID
    curFieldNameId++;
    // Создаем элемент ДИВ
    var div = document.createElement("div");
    // Добавляем HTML-контент с пом. свойства innerHTML
    div.innerHTML = "<input name=\"image" + curFieldNameId + "\" type=\"file\" class=\"inputform_file\"/> <a onclick=\"return deleteField(this)\" href=\"#\" class=\"razdel-bodys-aa\">[X]</a>";
    // Добавляем новый узел в конец списка полей
    document.getElementById("parentId").appendChild(div);
    // Возвращаем false, чтобы не было перехода по сслыке
    return false;
}

  function Numbers22(e)
  {
  var keynum;
  var keychar;
  var numcheck;
  var return2;
  if(window.event) // IE
    {
    keynum = e.keyCode;
    }
  else if(e.which) // Netscape/Firefox/Opera
    {
    keynum = e.which;
    }
  keychar = String.fromCharCode(keynum);
//  numcheck = /\d/;
if (keynum < 45 || keynum > 57) {
	return2 = false;
	if (keynum == 8) return2 = true;
	}
	else return2 = true;
return return2;
  }
