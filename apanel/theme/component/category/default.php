<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22):?>
<div class="message"><?=$message;?></div>
	<?if (count($category)>0):?>
		<h2>Категории новостей</h2>
		<table id="rounded-corner">
		<thead>
		    	<tr>
		        <th scope="col" class="rounded-company">Категория</th>
		            <th scope="col" class="rounded">Ред.</th>
		            <th scope="col" class="rounded-q4">Удалить</th>
		        </tr>
		</thead>
		<tfoot>
		    	<tr>
	        	<td colspan="2" class="rounded-foot-left">
			</td>
	        	<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>
		<tbody>

		<?foreach($category as $cat):?>
			<?foreach($cat as $ca):?>
			<?if($ca['podcat']==0):?>
				<tr><td width="450">
				<img src="images/index.png" width="16" height="16" border="0" alt=""/>
				<?=$ca['name']?>
				</td>
				<td align="center"><a href="?component=category&section=edit&edit=<?=$ca['id']?>"><img src="<?=$theme_admin?>images/user_edit.png" alt="" title="" border="0" /></a></td>
				<td align="center"><a href="?component=category&delete=<?=$ca['id']?>" class="ask"><img src="<?=$theme_admin?>images/trash.png" alt="" title="" border="0" /></a></td>
				</tr>
				<?else:?>

				<tr><td>
				<img src="images/item.png" width="16" height="16" border="0" alt="" style="margin-left:15px;"/>
				<?=$ca['name']?>
				</td>
				<td align="center"><a href="?component=category&section=edit&edit=<?=$ca['id']?>"><img src="<?=$theme_admin?>images/user_edit.png" alt="" title="" border="0" /></a></td>
				<td align="center"><a href="?component=category&delete=<?=$ca['id']?>" class="ask"><img src="<?=$theme_admin?>images/trash.png" alt="" title="" border="0" /></a></td>
				</tr>
				<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
		</tbody>
		</table>
	<?else:?>
	Категории новостей отсутствуют. Вы можете добавить новые категории.
	<?endif;?>

<h2>Добавть категорию</h2>
<form method="post" action="" />
<input type="hidden" name="event" value="cotegory"/>
<input type="hidden" name="add" value="1"/>
<table>
<tr><td>Родитель:</td><td>
	<select name="podcat" class="inputbox">
		<option value="0">---</option>
		<?foreach($category as $cat):?>
			<?foreach($cat as $ca):?>
			<?if($ca['podcat']==0):?>
				<option value="<?=$ca['id']?>"><?=$ca['name']?></option>
				<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
	</select>
</td></tr>
<tr><td>Название:</td><td><input class="inputbox" type="text" name="name" value=""/></td></tr>
<tr><td>Ссылка ЧПУ:</td><td><input class="inputbox" type="text" name="chpu" value=""/><i>(автогенерация)</i></td></tr>
<tr><td><input type="submit" value="добавить" /></td><td><td></td></tr>
</table></form>
<?else:?>У вас нет прав для доступа в этот раздел. Авторизируйтесь пожалуйста.<?endif;?>

