<?php
/**
 *
 * Autor: Roman Chernyshov
 * E-mail: support@rche.ru
 * URL: www.rche.ru
 *
 */

define( '_JEXEC', 1 );
error_reporting(E_ERROR | E_WARNING | E_PARSE);
//error_reporting(E_ALL);
	$settings = array(
	  'dbName' => '',
	  'dbUser' => '',
	  'dbPass' => '',
	  'dbHost' => 'localhost',
	  'dbPrefix'=>'osr_'
	 ); // Настройки подключения к БД

	$theme_admin		= 'theme/'; // выбираем тему оформления для admin
	$root_path		= 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$err			= 0;
	$activated		= 0; // 0 - подтверждение по емаил и активация, 1 - без активации

	$timer_generate		= FALSE; // отображение времени генерации страницы
	$system_query_cache	= TRUE; // кэширование SQL запросов

	$registry['license']	= '';