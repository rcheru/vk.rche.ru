<?php
require_once '../config.php';
if ($timer_generate) {require_once '../lib/timer.class.php';$timer = new timer();$timer->start_timer();}
require_once '../sys/functions.php';
require_once '../sys/functions.cms.php';
if (count($_GET)>0 OR count($_POST)>0) require_once '../sys/get.control.php';
require_once '../lib/access.class.php';
require_once '../lib/mail.class.php';
require_once '../lib/dbsql.class.php';

$user = new flexibleAccess('',$settings);
$DB= new DB_Engine('mysql', $settings['dbHost'], $settings['dbUser'], $settings['dbPass'], $settings['dbName']);
$DB->prefix=$settings['dbPrefix'];
$DB->show_err=FALSE;

$sql="SELECT `#__setting`.* FROM `#__setting`";
$tmp_registry=$DB->getAll($sql);
foreach($tmp_registry as $tmp):$registry[$tmp['name']]=$tmp['value'];endforeach;

if ( $_GET['logout'] == 1 ) $user->logout('http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);


if ( !$user->is_loaded())
	{if ( isset($_POST['uname']) && isset($_POST['pwd'])){
	  if ( !$user->login($_POST['uname'],$_POST['pwd'],$_POST['remember'] ) and $component!='cron'){
	    $err=2;
	  }else header('Location: http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);}
	} else 
	if (!$user->is_active()) $err=1; 

if($component=='')$com_path='frontpage';else $com_path=$component;
if($section=='')$sec_path='default';else $sec_path=$section;
$contents_view=$theme_admin.'component/'.$com_path.'/'.$sec_path.'.php';
if(!file_exists($contents_view)) {$contents_view=$theme_admin.'component/frontpage/default.php';$exists=FALSE;} else $exists=TRUE;
if(!$exists)$model='frontpage';else$model=$com_path;

$model_path=$theme_admin.'component/'.$model.'/.model.php';;
if(file_exists($model_path))include($model_path);

$page_title=$com_path;
require_once $theme_admin.'index.php';

if ($timer_generate) echo 'generate: '.round($firstTime = $timer->end_timer(),5).'s';
