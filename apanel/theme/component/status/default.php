<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22):?>

<?if(!empty($_GET['status'])):?>
     <div class="<?=$_GET['status']?>_box">
	<?if($_GET['t']==1):?>Запись успешно добавлена.<?endif;?>
	<?if($_GET['t']==2):?>Запись успешно обновлена.<?endif;?>
	<?if($_GET['t']==3):?>Запись удалена.<?endif;?>
	<?if($_GET['t']==4):?>Запись одобрена и опубликована.<?endif;?>
     </div>
<?endif;?>

<div class="message"><?=$message;?></div>
		<h2>Фильтр</h2>
		<form action="" method="post" class="niceform">
		<table><tr><td>Категория:</td>
			<td valign="top"><select name="filter-cat">
			<option value="none">Все категории</option>
		<?foreach($category as $cat):?>
			<?foreach($cat as $ca):?>
			<?if($ca['podcat']==0):?>
				<option value="<?=$ca['id']?>" <?if(($ca['id']==$_COOKIE['filter-cat']and empty($_POST['filter-cat'])) or $ca['id']==$_POST['filter-cat']):?>selected<?endif;?>>- <?=$ca['name']?></option>
				<?else:?>
				<option value="<?=$ca['id']?>" <?if(($ca['id']==$_COOKIE['filter-cat']and empty($_POST['filter-cat'])) or $ca['id']==$_POST['filter-cat']):?>selected<?endif;?>>--- <?=$ca['name']?></option>
				<?endif;?>
			<?endforeach;?>
		<?endforeach;?>
		</select>
		</td><td valign="top"><input type="submit" value="ок">
		</td></tr></table></form>
		<h2>Записи</h2>


	<?if (count($all)>0):?>
		<table id="rounded-corner">
		<thead>
		    	<tr>
		        <th scope="col" class="rounded-company">ID Текст записи</th>
		            <th scope="col" class="rounded">Категория</th>
		            <th scope="col" class="rounded">Дата</th>
		            <th scope="col" class="rounded">Состояние</th>
		            <th scope="col" class="rounded-q4"></th>
		        </tr>
		</thead>
		<tfoot>
		    	<tr>
	        	<td colspan="4" class="rounded-foot-left">
			</td>
	        	<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>
		<tbody>
		<?foreach($all as $num):?>
			<tr><td width="320" class="tab-cell-1">
				<?=$num['id']?>: 
				<?=$num['text']?></td>
				<td class="tab-cell-1"><?if($num['podcat']>0):?>
						<?foreach($category as $cat):?>
						<?if($cat[0]['id']==$num['podcat']):?><?=$cat[0]['name']?><?endif?>
						<?endforeach?>
						>> 
						<?endif;?>
						<?=$num['name']?></td>
				<td class="tab-cell-1"><?=date('d-m-y h:m',$num['date'])?></td>
				<td align="center">
                                <?if($num['pub']==1):?>Опубликовано<?else:?>На очереди<?endif?>
				</td>
				<td align="center">
				<a href="?component=status&section=edit&edit=<?=$num['id']?>"><img src="<?=$theme_admin?>images/user_edit.png" alt="" title="" border="0" /></a>
				<a href="?component=status&delete=<?=$num['id']?>" class="ask"><img src="<?=$theme_admin?>images/trash.png" alt="" title="" border="0" /></a></td>
				</tr>
	        <?endforeach;?>
		    </tbody>
		</table>

<?if ($registry['pagination']>1) echo $registry['pagination_txt'];?>

	<?else:?>
		<div class="massage">Запись отсутствуют. Вы можете добавить новую запись.</div>
        <?endif;?>
<a href="?component=status&section=add" class="bt_green"><span class="bt_green_lft"></span><strong>Добавить</strong><span class="bt_green_r"></span></a>

<p align="center"><a href="index.php?component=cron" style="color:red">СТАРТ: опубликовать одну запись</a></p>
<?else:?>У вас нет прав для доступа в этот раздел. Авторизируйтесь пожалуйста.<?endif;?>
