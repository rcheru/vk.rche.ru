<?defined('_JEXEC') or die('Restricted access');?>
<div class="message"><?=$message?></div>

	<h2>Отчет</h2>

<?if($registry['err']==1):?><p style="color:red">Ошибка: Постинг отключен, вы можете включить его в настройках</p><?endif?>


Опубликовано: <?=$registry['report']['post'];?><br/>
Всего не опубликованных: <?=$registry['report']['left']?><br/>
Всего опубликованных: <?=$registry['report']['public']?><br/>
Всего записей: <?=$registry['report']['total']?><br/>

<p align="center"><a href="index.php?component=cron" style="color:red">СТАРТ: опубликовать одну запись</a></p>