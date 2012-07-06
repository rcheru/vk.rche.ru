<?defined('_JEXEC') or die('Restricted access');?>
<?if(get_access('admin','user','view')):?>

<div class="message"><?=$message?></div>

	<?if (count($all)>0):?>
	<h2>Пользователи</h2>
		<table id="rounded-corner">
		<thead>
		    	<tr>
		        <th scope="col" class="rounded-company">ID</th>
		            <th scope="col" class="rounded">Никнейм</th>
		            <th scope="col" class="rounded">Группа</th>
		            <th scope="col" class="rounded<?if(!get_access('admin','user','del',false)):?>-q4<?endif?>">Ред.</th>
		            <?if(get_access('admin','user','del',false)):?><th scope="col" class="rounded-q4">Удалить</th><?endif?>
		        </tr>
		</thead>
		<tfoot>
		    	<tr>
	        	<td colspan="<?if(!get_access('admin','user','del',false)):?>3<?else:?>4<?endif?>" class="rounded-foot-left">
			</td>
	        	<td class="rounded-foot-right">&nbsp;</td>
			</tr>
		</tfoot>
		<tbody>
		<?foreach($all as $num):?>
			<tr>
				<td>
				<?=$num['id']?>
				</td>
				<td><a href="?component=users&section=edit&edit=<?=$num['id']?>" class="news-url"><?=$num['username']?></a></td>
				<td><img src="images/<?if($num['gid']==25):?>useradmin<?elseif($num['gid']==0):?>usera<?else:?>user<?endif;?>.png" width="16" height="16" border="0" alt="<?=$num['name']?>" title="<?=$num['name']?>" style="margin-right:10px;"/>
					<?if($num['gid']==0):?><a href="?component=users&activ=<?=$num['id']?>" title="Активировать"><?endif?><?=$num['name']?><?if($num['gid']==0):?></a><?endif?></td>
				<td align="center"><a href="?component=users&section=edit&edit=<?=$num['id']?>"><img src="<?=$theme_admin?>images/user_edit.png" alt="" title="" border="0" /></a></td>
				<?if(get_access('admin','user','del',false)):?><td align="center"><a href="?component=users&delete=<?=$num['id']?><?if(!empty($_GET['page'])):?>&page=<?=$_GET['page']?><?endif?>" class="ask"><img src="<?=$theme_admin?>images/trash.png" alt="" title="" border="0" /></a></td><?endif?>
				</td></tr>
	        <?endforeach;?>
		</tbody>
	</table>
	<?if ($total>1) echo '<p><div class="pagination" style="margin-bottom:10px; margin-top:10px;">'
		.$pervpage.$page2left.$page1left.'<span>'.$page.'</span>'.$page1right.$page2right
		.$nextpage.'</div></p>';?>
	<a href="?component=users&section=add" class="bt_green"><span class="bt_green_lft"></span><strong>Добавить</strong><span class="bt_green_r"></span></a>
	<?else:?>Пользователи отсутствуют.
	<?endif;?>


<?endif;?>
