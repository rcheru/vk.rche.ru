<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22):?>
<h2>Редактировать категорию</h2>
<form method="post" action="?component=category"/>
<input type="hidden" name="event" value="category"/>
<input type="hidden" name="edit" value="1"/>
<input type="hidden" name="idd" value="<?=$item[0]['id']?>"/>
<table>
<tr><td>Родитель:</td><td>
	<select name="podcat" class="inputbox">
		<option value="0">---</option>
		<?foreach($all as $ca):?>
		<?if($ca['podcat']==0):?>
			<option value="<?=$ca['id']?>" <?if($ca['id']==$item[0]['podcat']):?>selected<?endif;?>><?=$ca['name']?></option>
			<?endif;?>
		<?endforeach;?>
	</select>
</td></tr>
<tr><td>Название:</td><td><input class="inputbox" type="text" name="name" value="<?=$item[0]['name']?>"/></td></tr>
<tr><td>Ссылка ЧПУ:</td><td><input class="inputbox" type="text" name="chpu" value="<?=$item[0]['cat_chpu']?>"/><i>(автогенерация)</i></td></tr>
<tr><td><input type="submit" value="изменить" /></td><td><td></td></tr>
</table></form>
<p><a href="index.php?component=category"><< Назад</a></p>
<?else:?>У вас нет прав для доступа в этот раздел. Авторизируйтесь пожалуйста.<?endif;?>