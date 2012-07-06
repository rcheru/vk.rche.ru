<?defined('_JEXEC') or die('Restricted access');?>
<?if ($user->get_property('userID')==1 OR $user->get_property('gid')>=22):
	if (!empty($_GET['delete']))
		{
		$sql="DELETE FROM `category` WHERE `category`.`id` = ".intval($_GET['delete'])." LIMIT 1";
		$DB->execute($sql);
		header('Location: ?component=category');
		}
	$name=htmlspecialchars(strip_tags($_POST['name']));
	$podcat=intval($_POST['podcat']);
	$chpu=htmlspecialchars(strip_tags($_POST['chpu']));
	if ($chpu=='')$chpu=generate_chpu($name);

	if ($_POST['edit']==1) {

	if ($err==0) {

		$sql="UPDATE `category` SET `name` = '".$name."',`podcat` = '".$podcat."', `cat_chpu` = '".$chpu."' WHERE `id`='".intval($_POST['idd'])."' LIMIT 1; ";
		$DB->execute($sql);
		$message='Запись успешно обновлена';
	   }
	}


	if ($_POST['add']==1) {
		$sql="INSERT INTO `category` (`id`,`podcat`,`name`,`cat_chpu`) VALUES ('', '$podcat', '$name', '$chpu');";
		$DB->execute($sql);
		$message='Запись успешно добавлена';
	}

	if(empty($_GET['section'])):
		$all = $DB->getAll('SELECT * FROM category WHERE podcat=0');
		$i=0;
		foreach($all as $num):
			$category[$num['id']][0]=$num;
			$i++;
		endforeach;
	
		$all = $DB->getAll('SELECT * FROM category WHERE podcat>0');
		$i=0;
		foreach($all as $num):
			$category[$num['podcat']][]=$num;
			$i++;
		endforeach;
	else:
		$all = $DB->getAll('SELECT * FROM category WHERE podcat=0');
		$item = $DB->getAll('SELECT * FROM category WHERE id='.intval($_GET['edit']));
	endif;
//new dbug($item);
endif;
?>