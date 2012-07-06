<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=24):?>
        
    <h2>Новые статусы</h2> 
	<?if (count($all)>0):?>
		<table id="rounded-corner">
		<thead>
		    	<tr>
		        <th scope="col" class="rounded-company">ID Текст статуса</th>
		            <th scope="col" class="rounded">Категория</th>
		            <th scope="col" class="rounded">Дата</th>
		            <th scope="col" class="rounded">Ред.</th>
		            <th scope="col" class="rounded-q4">Удалить</th>
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
					<?if($num['moderate']==1):?>
						<a href="?component=status&moderate=<?=$num['id']?>"><img src="images/plus-button.png" width="16" height="16" border="0" alt="edit" title="одобрить материал"/></a>
					<?endif;?>
				<a href="?component=status&section=edit&edit=<?=$num['id']?>"><img src="<?=$theme_admin?>images/user_edit.png" alt="" title="" border="0" /></a></td>
				</td>
				<td align="center"><a href="?component=status&delete=<?=$num['id']?>" class="ask"><img src="<?=$theme_admin?>images/trash.png" alt="" title="" border="0" /></a></td>
				</tr>
	        <?endforeach;?>
		    </tbody>
		</table>
	<?endif?>

	<?if ($total>1) echo '<p><div class="pagination" style="margin-bottom:10px; margin-top:10px;">'
	.$pervpage.$page2left.$page1left.'<span>'.$page.'</span>'.$page1right.$page2right
	.$nextpage.'</div></p>';?>


<?else:?>      
     

<?endif?>