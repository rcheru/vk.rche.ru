<?defined('_JEXEC') or die('Restricted access');?>

<?if(!empty($message[0])):?>
     <div class="<?=$message[0]?>_box">
	<?=$message[1]?>
     </div>
<?endif;?>
<?if(get_access('admin','user','edit')):?>

<?if($message[0]=='valid'):?>
	<a href="?component=users">Все пользователи</a><br/>
	<a href="?component=users&section=add">Добавить пользователя</a><br/>
<?else:?>
		<h2>Добавить пользователя: </h2>

		<form method="post" action="" enctype="multipart/form-data"/>

		<input type="hidden" name="event" value="users"/>
		<input type="hidden" name="add" value="1"/>

		<table class="formadd">
		<tr><td class="td1">Логин</td><td><input class="inputbox" type="text" name="login" value="<?=$_POST['login']?>"/></td></tr>
		<tr><td class="td1">ФИО</td><td><input class="inputbox" type="text" name="realname" value="<?=$_POST['realname']?>"/></td></tr>
		<tr><td class="td1">Группа</td><td><select name="group" class="inputbox">
			<?foreach($registry['group'] as $item):?>
				<option value="<?=$item['pungid']?>" <?if ($item['pungid']==$num['group_id']):?>selected<?endif?>><?=$item['name']?></option>
			<?endforeach?>
		</select></td></tr>
		<tr><td class="td1">Пароль</td><td><input class="inputbox" type="password" name="pwd" value=""/></td></tr>
		<tr><td class="td1">Повторить пароль</td><td><input class="inputbox" type="password" name="pwd2" value=""/></td></tr>
		<tr><td class="td1">Адоес эл. почты</td><td><input class="inputbox" type="text" name="email" value="<?=$_POST['email']?>"/></td></tr>
		<tr><td class="td1">ICQ UIN</td><td><input class="inputbox" type="text" name="icq" value="<?=$_POST['icq']?>"/></td></tr>
		<tr><td class="td1">Сайт</td><td><input class="inputbox" type="text" name="url" value="<?=$_POST['url']?>"/></td></tr>
		<tr><td class="td1">Номер телефона</td><td><input class="inputbox" type="text" name="phone" value="<?=$_POST['phone']?>"/></td></tr>

		<tr><td class="td1">Заметка</td><td><textarea name="title"><?=$_POST['title']?></textarea></td></tr>
		</table>

<a href="index.php?component=users"><< Все пользователи</a> <input type="submit" value="Добавить" />
</form>
<?endif;?>
<?endif?>
