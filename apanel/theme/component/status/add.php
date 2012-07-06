<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22):?>


<div id="addnews" style="display:block;">
<h2>Опубликовать новость</h2>
<form method="post" action="" enctype="multipart/form-data"/>
<input type="hidden" name="event" value="status"/>
<input type="hidden" name="add" value="1"/>
<table width="800">
<tr><td>Категория:</td><td><select name="cat">
		<?foreach($category as $cat):?>
			<?foreach($cat as $ca):?>
			<?if($ca['podcat']==0):?>
				<option value="<?=$ca['id']?>">- <?=$ca['name']?></option>
				<?else:?>
				<option value="<?=$ca['id']?>">--- <?=$ca['name']?></option>
				<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
</select>
</tr></table>
<textarea name="textarea1" id="textarea1" style="width: 600px;height:300px;" class="tinymce"></textarea><br/>
<input type="submit" value="Добавить">
</form></div>

<?endif;?>