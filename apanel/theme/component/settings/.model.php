<?php
/**
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
 */

defined('_JEXEC') or die('Restricted access');


if ($user->get_property('userID')==1 OR $user->get_property('gid')==25):
	if ($_POST['update']==1) {

	if ($err==0) {
	foreach ($_POST as $key => $val)
		{
		$key=PHP_slashes($key);
		$sql="UPDATE `#__setting` SET `value` = '".PHP_slashes(htmlspecialchars($val))."' WHERE `name`='$key' LIMIT 1; ";
		$DB->execute($sql);
		}
	   $message[0]='valid';
	   $message[1]='Настройки сайта успешно обновлены';
	   @unlink('../cache/registry');
	   }
	}

$sql="SELECT `#__setting`.* FROM `#__setting`";
$tmp_registry=$DB->getAll($sql);
foreach($tmp_registry as $tmp):$registry[$tmp['name']]=$tmp['value'];endforeach;
endif;
