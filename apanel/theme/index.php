<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Администрирование - osRealty</title>
<link rel="stylesheet" type="text/css" href="<?=$theme_admin;?>css/style.css" />
<link rel="stylesheet" type="text/css" href="<?=$theme_admin;?>css/navi.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?=$theme_admin;?>css/niceforms-default.css" />
<link href="/<?=$theme;?>css/jquery.lightbox-0.5.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/func.js"></script>
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/jquery.min.js"></script>
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/jquery.cookie.js"></script>
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/ddaccordion.js"></script>
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/jquery.spoiler.js"></script>
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/jconfirmaction.jquery.js"></script>
<script language="javascript" type="text/javascript" 
	src="<?=$theme_admin;?>js/niceforms.js"></script>
<script language="javascript" type="text/javascript" 
	src="<?=$theme_admin;?>js/combobox.js"></script>
<script language="javascript" type="text/javascript" 
	src="<?=$theme_admin;?>js/cal.js"></script>
<script language="JavaScript" 
	type="text/javascript" src="/<?=$theme;?>js/jquery.lightbox-0.5.min.js"></script>
<script type="text/javascript">
ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='<?=$theme_admin;?>images/plus.gif' class='statusicon' />", "<img src='<?=$theme_admin;?>images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});
</script>
</head>
<body>
<div id="main_container">
<?if(!$user->is_loaded() and $com_path<>'install'):?>
		<?if($components)?><?require_once($theme_admin.'module/login/default.php');?>
<?else:?>
  
<?require_once($theme_admin.'module/login/default.php');?>
    <div class="main_content">
<?require_once($theme_admin.'module/top_sidebar/default.php');?>    
    <div class="center_content">  
    <div class="left_content">
<?require_once($theme_admin.'module/left_sidebar/default.php');?>    
    </div>  
    
    <div class="right_content">            
<?if ($err>0) require_once($theme_admin.'component/error/default.php');?>
<?require_once($contents_view)?>
     </div><!-- end of right content-->
 </div>   <!--end of center content -->               
 <div class="clear"></div>
 </div> <!--end of main content-->
 <div class="footer">
  	<div class="left_footer">Powered by <a href="http://rche.ru">RCHE</a></div>    
</div>
<?endif;?>

</div>		
</body>
</html>