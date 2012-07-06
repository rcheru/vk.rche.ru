<?defined('_JEXEC') or die('Restricted access');?>
<?if(get_access('admin','group','view')):?>
<div class="message"><?=$message?></div>
<?if (count($all)>0):?>
	<h2>Пользователи</h2>
		<table id="rounded-corner">
		<thead>
		    	<tr>
		        <th scope="col" class="rounded-company">ID</th>
		            <th scope="col" class="rounded">Назавние</th>
		            <th scope="col" class="rounded-q4">Ред.</th>
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
		<?foreach($all as $num):?>
			<tr>
				<td>
				<?=$num['id']?>
				</td>
				<td><a href="?component=users&section=gredit&edit=<?=$num['id']?>" class="news-url"><?=$num['name']?></a></td>
				<td align="center"><a href="?component=users&section=gredit&edit=<?=$num['id']?>"><img src="<?=$theme_admin?>images/user_edit.png" alt="" title="" border="0" /></a></td>
				</td></tr>
	        <?endforeach;?>
		</tbody>
	</table>
	<?if ($total>1) echo '<p><div class="pagination" style="margin-bottom:10px; margin-top:10px;">'
		.$pervpage.$page2left.$page1left.'<span>'.$page.'</span>'.$page1right.$page2right
		.$nextpage.'</div></p>';?>

	<?else:?>Группы отсутствуют.<?endif;?>
<?endif;?>
