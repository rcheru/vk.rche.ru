<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22):
	$id=intval($_GET['edit']);
	$all = $DB->getAll('SELECT status.*, catstat.name FROM status 
			LEFT JOIN catstat ON catstat.id=status.cat WHERE status.id='.$id);
	if (count($all)>0):
		foreach($all as $num):
	?>
		<h2>Редактирование записи, ID <?=$num['id']?>: </h2>
		<form method="post" action="?component=status" enctype="multipart/form-data">
		<input type="hidden" name="event" value="status"/>
		<input type="hidden" name="update" value="1"/>
		<input type="hidden" name="id" value="<?=$num['id']?>"/>
		<table>
		<tr><td>Категория:</td><td><select name="cat" class="inputbox">
		<?foreach($category as $cat):?>
			<?foreach($cat as $ca):?>
			<?if($ca['podcat']==0):?>
				<option value="<?=$ca['id']?>" <?if($ca['id']==$num['cat']):?>selected<?endif;?>>- <?=$ca['name']?></option>
				<?else:?>
				<option value="<?=$ca['id']?>" <?if($ca['id']==$num['cat']):?>selected<?endif;?>>--- <?=$ca['name']?></option>
				<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
		</select>
		</tr></table>
<textarea name="textarea1" class="tinymce" id="textarea1" style="width: 600px;height:300px;"><?=$num['text']?></textarea>

<input type="submit" value="Сохранить">
</form>
		<?endforeach;?>
	<?else:?>Для редактирования записи перейдите в раздел "опубликовать новость", затем кликните "Редактировать".<?endif;?>
<?else:?>У вас нет прав для доступа в этот раздел. Авторизируйтесь пожалуйста.<?endif?>
<p><a href="index.php?component=article"><< Назад</a></p>