<?php
/**
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
 */

require_once '../config.php';
if ($timer_generate) {require_once '../lib/timer.class.php';$timer = new timer();$timer->start_timer();}
require_once '../sys/functions.php';
if (count($_GET)>0 OR count($_POST)>0) require_once '../sys/get.control.php';
require_once '../lib/access.class.php';
require_once '../lib/mail.class.php';
require_once '../lib/dbsql.class.php';

$DB= new DB_Engine('mysql', $settings['dbHost'], $settings['dbUser'], $settings['dbPass'], $settings['dbName']);
$DB->prefix=$settings['dbPrefix'];
$registry['install_inter_page']=1;
$com_path='install';
if($section=='')$sec_path='default';else $sec_path=$section;
$contents_view=$theme_admin.'component/'.$com_path.'/'.$sec_path.'.php';
if(!file_exists($contents_view)) {$contents_view=$theme_admin.'component/frontpage/default.php';$exists=FALSE;} else $exists=TRUE;

if(!$exists)$model='install';else$model=$com_path;

$model_path=$theme_admin.'component/'.$model.'/.model.php';;

if(file_exists($model_path))include($model_path);

$page_title=$com_path;
require_once $theme_admin.'install.php';

if ($timer_generate) echo 'generate: '.round($firstTime = $timer->end_timer(),5).'s';
