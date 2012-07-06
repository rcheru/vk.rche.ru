<?php
/********************************************************************
 * openImageLibrary addon Copyright (c) 2006 openWebWare.com
 * Contact us at devs@openwebware.com
 * This copyright notice MUST stay intact for use.
 ********************************************************************/

require('config.inc.php');
error_reporting(0);
// get the identifier of the editor
$wysiwyg = $_GET['wysiwyg']; 
// set image dir
$leadon = $rootdir.$imagebasedir;
$thumbs_directory = $rootdir.$imagebasedir.'/thumbs/';
//echo $thumbs_directory;
//exit;
if($leadon=='.') $leadon = '';
if((substr($leadon, -1, 1)!='/') && $leadon!='') $leadon = $leadon . '/';
$startdir = $leadon;

// validate the directory
$_GET['dir'] = $_POST['dir'] ? $_POST['dir'] : $_GET['dir'];
if($_GET['dir']) {
	if(substr($_GET['dir'], -1, 1)!='/') {
		$_GET['dir'] = $_GET['dir'] . '/';
	}
	$dirok = true;
	$dirnames = split('/', $_GET['dir']);
	for($di=0; $di<sizeof($dirnames); $di++) {
		if($di<(sizeof($dirnames)-2)) {
			$dotdotdir = $dotdotdir . $dirnames[$di] . '/';
		}
	}
	if(substr($_GET['dir'], 0, 1)=='/') {
		$dirok = false;
	}

	if($_GET['dir'] == $leadon) {
		$dirok = false;
	}
	
	if($dirok) {
		$leadon = $_GET['dir'];
	}
}
function createThumbnail ( $imageDirectory , $imageName , $thumbDirectory , $thumbWidth ) 
	{ 
//echo "$imageDirectory$imageName";
//exit;
	$srcImg = imagecreatefromjpeg ( "$imageDirectory$imageName" ) ; 
	$origWidth = imagesx ( $srcImg ) ; $origHeight = imagesy ( $srcImg ) ; 
	$ratio = $thumbWidth / $origWidth ; $thumbHeight = $origHeight * $ratio ; 
	$thumbImg = ImageCreateTrueColor ( $thumbWidth , $thumbHeight ) ; 
	imagecopyresized ( $thumbImg , $srcImg , 0 , 0 , 0 , 0 , $thumbWidth , $thumbHeight , $origWidth , $origHeight ) ; 
	$temp_file_name = explode ( "." , $imageName ) ; 
	array_pop ( $temp_file_name ) ; $temp_file_name = implode ( "" , $temp_file_name ) ; $thumbImgName = $temp_file_name . "_thumb.jpg" ; 
	imagejpeg ( $thumbImg , "$thumbDirectory/$thumbImgName" ) ; imagedestroy ( $thumbImg ) ; 
//echo "$thumbDirectory/$thumbImgName";
//exit;
}
// upload file
if($allowuploads && $_FILES['file']) {
	$upload = true;
	if(!$overwrite) {
		if(file_exists($leadon.$_FILES['file']['name'])) {
			$upload = false;
		}
	}
	$ext = strtolower(substr($_FILES['file']['name'], strrpos($_FILES['file']['name'], '.')+1));
	if(!in_array($ext, $supportedextentions)) {
		$upload = false;
	}
	if($upload) {
		move_uploaded_file($_FILES['file']['tmp_name'], $leadon . $_FILES['file']['name']);
		createThumbnail ( $leadon , $_FILES [ 'file' ] [ 'name' ] , $thumbs_directory , '120' ) ;
	}
}

if($allowuploads) {
	$phpallowuploads = (bool) ini_get('file_uploads');		
	$phpmaxsize = ini_get('upload_max_filesize');
	$phpmaxsize = trim($phpmaxsize);
	$last = strtolower($phpmaxsize{strlen($phpmaxsize)-1});
	switch($last) {
		case 'g':
			$phpmaxsize *= 1024;
		case 'm':
			$phpmaxsize *= 1024;
	}
}

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
<title>rcheCMS v 2.0 | Вставить изображение</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<script type="text/javascript" src="../../scripts/wysiwyg-popup.js"></script>
<script language="JavaScript" type="text/javascript">

/* ---------------------------------------------------------------------- *\
  Function    : insertImage()
  Description : Inserts image into the WYSIWYG.
\* ---------------------------------------------------------------------- */
function insertImage() {
	var n = WYSIWYG_Popup.getParam('wysiwyg');
	
	// get values from form fields
	var src = document.getElementById('src').value;
	var alt = document.getElementById('alt').value;
	var width = document.getElementById('width').value
	var height = document.getElementById('height').value
	var border = document.getElementById('border').value
	var align = document.getElementById('align').value
	var vspace = document.getElementById('vspace').value
	var hspace = document.getElementById('hspace').value
	
	// insert image
	WYSIWYG.insertImage(src, width, height, align, border, alt, hspace, vspace, n);
  	window.close();
}

/* ---------------------------------------------------------------------- *\
  Function    : loadImage()
  Description : load the settings of a selected image into the form fields
\* ---------------------------------------------------------------------- */
function loadImage() {
	var n = WYSIWYG_Popup.getParam('wysiwyg');
	
	// get selection and range
	var sel = WYSIWYG.getSelection(n);
	var range = WYSIWYG.getRange(sel);
	
	// the current tag of range
	var img = WYSIWYG.findParent("img", range);
	
	// if no image is defined then return
	if(img == null) return;
		
	// assign the values to the form elements
	for(var i = 0;i < img.attributes.length;i++) {
		var attr = img.attributes[i].name.toLowerCase();
		var value = img.attributes[i].value;
		//alert(attr + " = " + value);
		if(attr && value && value != "null") {
			switch(attr) {
				case "src": 
					// strip off urls on IE
					if(WYSIWYG_Core.isMSIE) value = WYSIWYG.stripURLPath(n, value, false);
					document.getElementById('src').value = value;
				break;
				case "alt":
					document.getElementById('alt').value = value;
				break;
				case "align":
					selectItemByValue(document.getElementById('align'), value);
				break;
				case "border":
					document.getElementById('border').value = value;
				break;
				case "hspace":
					document.getElementById('hspace').value = value;
				break;
				case "vspace":
					document.getElementById('vspace').value = value;
				break;
				case "width":
					document.getElementById('width').value = value;
				break;
				case "height":
					document.getElementById('height').value = value;
				break;				
			}
		}
	}
	
	// get width and height from style attribute in none IE browsers
	if(!WYSIWYG_Core.isMSIE && document.getElementById('width').value == "" && document.getElementById('width').value == "") {
		document.getElementById('width').value = img.style.width.replace(/px/, "");
		document.getElementById('height').value = img.style.height.replace(/px/, "");
	}
}

/* ---------------------------------------------------------------------- *\
  Function    : selectItem()
  Description : Select an item of an select box element by value.
\* ---------------------------------------------------------------------- */
function selectItemByValue(element, value) {
	if(element.options.length) {
		for(var i=0;i<element.options.length;i++) {
			if(element.options[i].value == value) {
				element.options[i].selected = true;
			}
		}
	}
}

</script>
</head>
<body bgcolor="#EEEEEE" marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" onLoad="loadImage();">
<table border="0" cellpadding="0" cellspacing="0" style="padding: 10px;">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>?wysiwyg=<?php echo $wysiwyg; ?>" enctype="multipart/form-data">
<input type="hidden" id="dir" name="dir" value="">
<tr>
<td style="vertical-align:top;">
<span style="font-family: arial, verdana, helvetica; font-size: 11px; font-weight: bold;">Вставить изображение:</span>
<table width="380" border="0" cellpadding="0" cellspacing="0" style="background-color: #F7F7F7; border: 2px solid #FFFFFF; padding: 5px;">
	<?php
	if($allowuploads) {
		if($phpallowuploads) {
		
	?>
		<tr>
			<td style="padding-top: 0px;padding-bottom: 0px; font-family: arial, verdana, helvetica; font-size: 11px;width:80px;">Загрузить:</td>
			<td style="padding-top: 0px;padding-bottom: 0px;width:300px;"><input type="file" name="file" size="30" style="font-size: 10px; width: 100%;" /></td>
		</tr>
		<tr>
			<td style="padding-top: 0px;padding-bottom: 2px;font-family: tahoma; font-size: 9px;">&nbsp;</td>
			<td style="padding-top: 0px;padding-bottom: 2px;font-family: tahoma; font-size: 9px;">(Макс. размер файла: <?php echo $phpmaxsize; ?>KB)</td>
		</tr>
	<?php
		}
		else {
	?>
		<tr>
			<td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;" colspan="2">
				File uploads are disabled in your php.ini file. Please enable them.
			</td>
		</tr>
	<?php
		}
	}
	?>
	<tr>
		<td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;" width="80">URL изображения:</td>
		<td style="padding-bottom: 2px; padding-top: 0px;" width="300"><input type="text" name="src" id="src" value=""  style="font-size: 10px; width: 100%;"></td>
	</tr>
	<tr>
		<td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;">Описание:</td>
		<td style="padding-bottom: 2px; padding-top: 0px;"><input type="text" name="alt" id="alt" value=""  style="font-size: 10px; width: 100%;"></td>
	</tr>
</table>
	
<table width="380" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:top;">
<span style="font-family: arial, verdana, helvetica; font-size: 11px; font-weight: bold;">Параметры:</span>
<table width="180" border="0" cellpadding="0" cellspacing="0" style="background-color: #F7F7F7; border: 2px solid #FFFFFF; padding: 5px;">
<tr>
  <td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;">Ширина:</td>
  <td style="width:60px;padding-bottom: 2px; padding-top: 0px;"><input type="text" name="width" id="width" value=""  style="font-size: 10px; width: 100%;"></td>
 </tr>
 <tr>
  <td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;">Высота:</td>
	<td style="padding-bottom: 2px; padding-top: 0px;"><input type="text" name="height" id="height" value=""  style="font-size: 10px; width: 100%;"></td>
 </tr>
 <tr>
  <td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;">Граница:</td>
	<td style="padding-bottom: 2px; padding-top: 0px;"><input type="text" name="border" id="border" value="0"  style="font-size: 10px; width: 100%;"></td>
 </tr>
</table>	

</td>
<td width="10">&nbsp;</td>
<td style="vertical-align:top;">

<span style="font-family: arial, verdana, helvetica; font-size: 11px; font-weight: bold;">&nbsp;</span>
<table width="200" border="0" cellpadding="0" cellspacing="0" style="background-color: #F7F7F7; border: 2px solid #FFFFFF; padding: 5px;">
<tr>
  <td style="width: 115px;padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;" width="100">Выравнивание:</td>
	<td style="width: 85px;padding-bottom: 2px; padding-top: 0px;">
	<select name="align" id="align" style="font-family: arial, verdana, helvetica; font-size: 11px; width: 100%;">
	 <option value="">Not Set</option>
	 <option value="left">Left</option>
	 <option value="right">Right</option>
	 <option value="texttop">Texttop</option>
	 <option value="absmiddle">Absmiddle</option>
	 <option value="baseline">Baseline</option>
	 <option value="absbottom">Absbottom</option>
	 <option value="bottom">Bottom</option>
	 <option value="middle">Middle</option>
	 <option value="top">Top</option>
	</select>
	</td>
 </tr>
 <tr>
  <td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;">Отступ по горизонтали:</td>
	<td style="padding-bottom: 2px; padding-top: 0px;"><input type="text" name="hspace" id="hspace" value=""  style="font-size: 10px; width: 100%;"></td>
 </tr>
 <tr>
  <td style="padding-bottom: 2px; padding-top: 0px; font-family: arial, verdana, helvetica; font-size: 11px;">Отступ по вертикали:</td>
	<td style="padding-bottom: 2px; padding-top: 0px;"><input type="text" name="vspace" id="vspace" value=""  style="font-size: 10px; width: 100%;"></td>
 </tr>
</table>	

</td>
</tr>
</table>
</td>
<td style="vertical-align: top;width: 150px; padding-left: 5px;">
	<span style="font-family: arial, verdana, helvetica; font-size: 11px; font-weight: bold;">Выбрать изображение:</span>
	<iframe id="chooser" frameborder="0" style="height:165px;width: 180px;border: 2px solid #FFFFFF; padding: 5px;" src="select_image.php?dir=<?php echo $leadon; ?>"></iframe>
</td>
</tr>
<tr>
	<td colspan="2" align="right" style="padding-top: 5px;">
		<input type="submit" value="  Вставить  " onclick="insertImage();return false;" style="font-size: 12px;">
		<?php if ( $allowuploads ) { ?> 
			<input type="submit" value="  Загрузить  " style="font-size: 12px;">
		<?php } ?> 		
		<input type="button" value="  Отмета  " onclick="window.close();" style="font-size: 12px;">	
	</td>
</tr>
</form>
</table>
</body>
</html>
