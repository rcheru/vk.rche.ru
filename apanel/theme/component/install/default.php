<?defined('_JEXEC') or die('Restricted access');?>
<?if($message[0]<>'valid' and $checkinstall<>1):?>
    <h2>Установка</h2> 
<form action="" method="post">
<input type="hidden" name="install" value="1">
<input type="submit" value="Установить">
</form>

<?else:?>
	<div class="news-center">
	<div class="menu-top5">Готово.</div>
	<?if(!empty($message[0])):?>
	     <div class="<?=$message[0]?>_box">
		<?=$message[1]?>
	     </div>
	<?endif;?>
	</div>

<h2>Параметры доступа в админпанель<h2>
<p><b>Логин:</b> Admin<br/>
<b>Пароль:</b> 909090</p>
<p><a href="index.php">Перейти в админпанель</a></p>
<p><b>Внимания!</b> Не забудьте сменить пароль.<br/>
<span style="color:red">Удалите файлы "/apanel/install.php" и "/apanel/install.sql" с сервера!</span>
<p>

<h2>Установите права доступа 777 на папки: </h2>
/cache/<br/>

<?endif;?>
