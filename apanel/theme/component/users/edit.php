<?defined('_JEXEC') or die('Restricted access');?>

<?if(!empty($message[0])):?>
     <div class="<?=$message[0]?>_box">
	<?=$message[1]?>
     </div>
<?endif;?>
<?if(get_access('admin','user','edit')):
	if (count($registry['edituser'])>0):
		foreach($registry['edituser'] as $num):?>

		<h2>Редактирование профиля <?=$num['username']?></h2>

		<form method="post" action="" enctype="multipart/form-data"/>
		<input type="hidden" name="id" value="<?=$num['id']?>"/>
		<input type="hidden" name="event" value="users"/>
		<input type="hidden" name="update" value="1"/>

		<table class="formadd">
		    <tr><td class="td1">Пароль</td><td><input class="inputbox" type="password" name="pwd" value=""/></td></tr>
		    <tr><td class="td1">Пароль еще раз</td><td><input class="inputbox" type="password" name="pwd2" value=""/></td></tr>
		    <tr><td class="td1">Адрес эл. почты</td><td><input class="inputbox" type="text" name="email" value="<?=$num['email']?>"/></td></tr>

		    <tr><td class="td1">Заметка</td><td><textarea name="title"><?=$num['title']?></textarea></td></tr>
		</table>

<input type="submit" value="Сохранить" />
</form>
		<?endforeach;?>
	<?else:?>Записи с таким ID не существует<?endif;?>
<?endif?>  
