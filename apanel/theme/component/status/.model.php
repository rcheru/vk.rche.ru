<?defined('_JEXEC') or die('Restricted access');?>
<?
if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22)
	{
	if (!empty($_GET['delete']))
		{
		$sql="DELETE FROM `#__status` WHERE `#__status`.`id` = ".intval($_GET['delete'])." LIMIT 1";
		$DB->execute($sql);
		$t=3;
		header('location: ?component=status&status=error&t='.$t);
		}

	if ($_POST['update']==1 OR $_POST['add']==1) 
		{
		if ($err==0) 
			{
			$cat=intval($_POST['cat']);
			$text=PHP_slashes($_POST['textarea1']);
                        $date=time();
			if ($_POST['update']==1) 
				{
		        	$sql="UPDATE `#__status` SET 
				`text` = '$text',
				`cat`='$cat'
				WHERE `id`='".intval($_POST['id'])."' LIMIT 1; ";
				$DB->execute($sql);
				$t=2;
			   	}

			if ($_POST['add']==1) 
				{
				$sql="INSERT INTO `#__status` (`id` ,`user`, `cat`, `text`, `rate`,`date`) VALUES 
				('', '".$user->get_property('userID')."','$cat','$text','0','$date')";
				$DB->execute($sql);
				$t=1;
				}


			header('Location: index.php?component=status&status=valid&t='.$t);
			}
		}
	$filter_p='';
	if((!empty($_POST['filter-cat']) OR !empty($_COOKIE['filter-cat'])) and $_POST['filter-cat']!=='none'):
		if(!empty($_POST['filter-cat'])):
			$val=intval($_POST['filter-cat']); 
			setcookie('filter-cat',$val,time()+36000,'/');
			else:
			 $val=intval($_COOKIE['filter-cat']);
			endif;
		$filter_p=" and #__status.cat =".$val;
	endif;
	if($_POST['filter-cat']=='none')
		{
		setcookie('filter-cat','',time()-36000,'/');
		}

	/* -------------------------------------------------------- */

	/*
	* pagenation($page = 1, $num = 10, $di = 10 (диапазон разброса), $link_url = '', $DBtable, $DBwhere)
	* type (1 - pagenation, 2 - status, 3 - form)
	* return = array ('start' => NUM, 'num' => NUM, 'total' => NUM, 'posts' => NUM, 'html' = TEXT, 'status' = TEXT, 'form' = TEXT)
	*/
	$pgn = pagenation($_REQUEST['page'], 20, 8, '?index.php?component=status&section=default', 
			'#__status', "#__status.id>0 $filter_p",
			'');
	/* -------------------------------------------------------- */

	$registry['pagination_txt']=$pgn['html'].$pgn['status'].$pgn['form'];
	$registry['pagination_t']=$pgn['html'];
	$registry['posts']=$pgn['posts'];
	$registry['pagination']=$pgn['total'];

		$all = $DB->getAll('SELECT * FROM #__category WHERE podcat=0');
		$i=0;
		foreach($all as $nu):
			$category[$nu['id']][0]=$nu;
			$i++;
		endforeach;
	
		$all = $DB->getAll('SELECT * FROM #__category WHERE podcat>0');
		$i=0;
		foreach($all as $nu):
			$category[$nu['podcat']][]=$nu;
			$i++;
		endforeach;

		$all = $DB->getAll("SELECT #__status.*, #__category.name, #__category.podcat 
				FROM #__status 
				LEFT JOIN #__category ON #__category.id=#__status.cat 
				WHERE #__status.id>0 $filter_p 
				ORDER BY #__status.id DESC LIMIT {$pgn['start']}, {$pgn['num']}");

		$groups = $DB->getAll('SELECT `#__group`.* FROM `#__group` ORDER BY id DESC');
}
