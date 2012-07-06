<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Установка</title>
<link rel="stylesheet" type="text/css" href="<?=$theme_admin;?>css/style.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?=$theme_admin;?>css/niceforms-default.css" />
<script type="text/javascript" 
	src="<?=$theme_admin;?>js/func.js"></script>
</head>
<body>
<div id="main_container">
<?require_once($theme_admin.'module/install/login.php');?>
    <div class="main_content">
<?require_once($theme_admin.'module/install/top_sidebar.php');?>    
    <div class="center_content">  
    <div class="left_content">
<?require_once($theme_admin.'module/install/left_sidebar.php');?>    
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

</div>		
</body>
</html>