<?php

function clear_vk_url($url) {
	$url = str_replace('http://','',$url);
	$url = str_replace('https://','',$url);
	$url = str_replace('vk.com/','',$url);
	$url = str_replace('vkontakte.ru/','',$url);
	$url = str_replace('/','',$url);
	return 'http://vk.com/'.$url;
}

function get_vk_gid($url) {
	$url = str_replace('http://','',$url);
	$url = str_replace('https://','',$url);
	$url = str_replace('vk.com/','',$url);
	$url = str_replace('vkontakte.ru/','',$url);
	$url = str_replace('/','',$url);
	$url = str_replace('public','-',$url);
	$url = str_replace('club','-',$url);
	return $url;
}

function curl_redirect($ch)
{
	global $registry;
	$loops = 0;
	$max_loops = 10;

	if ($loops++ >= $max_loops)
	{
		$loops = 0;
		return FALSE;
	}
	$data = curl_exec($ch);
	$temp = $data;
	list($header, $data) = explode("\n\n", $data, 2);
	$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if ($http == 301 || $http == 302) 
	{
	$matches = array();
	preg_match('/ocation:(.*?)\n/', $header, $matches);
	$url = @parse_url(trim(array_pop($matches)));
	// print_r($url);
	if (!$url)
	{
		$loops = 0;
		return $data;
	}
	$last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
	if (!$url['scheme'])	$url['scheme'] = $last_url['scheme'];
	if (!$url['host'])	$url['host'] = $last_url['host'];
	if (!$url['path'])	$url['path'] = $last_url['path'];

	$new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');
	//echo "\n redirect to ".$new_url;
	curl_setopt($ch, CURLOPT_URL, $new_url);
	return curl_redirect($ch);
	} else {
		$loops=0;
		return $temp;
	}
} 

function _auth( $cookies ) {
	global $registry;
	$e = urlencode($registry['vklogin']); //mail
	$p = urlencode($registry['vkpass']);    //password
	$c = curl_init();
	$s = 'from_protocol=http&act=login&q=1&al_frame=1&expire=&captcha_sid=&captcha_key=&from_host=vk.com&email=' . $e . '&pass=' . $p;
	curl_setopt($c, CURLOPT_URL,'http://vk.com/login.php');
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	//curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_COOKIEJAR, $cookies);
	curl_setopt($c, CURLOPT_POST, 1);  
	curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13)');
	curl_setopt($c, CURLOPT_POSTFIELDS, $s);
	$r = curl_exec($c);
	//$r = curl_redirect( $c );
	curl_close($c);
}

function _params($cookies) {
	global $url_vk;
	$c = curl_init();  
	curl_setopt($c, CURLOPT_HEADER, 1);  
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($c, CURLOPT_REFERER, 'http://vk.com/settings.php');
	//curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');  
	curl_setopt($c, CURLOPT_COOKIEJAR, $cookies);
	curl_setopt($c, CURLOPT_COOKIEFILE, $cookies);
	curl_setopt($c, CURLOPT_URL, $url_vk);  
	$r = curl_exec($c);

	//$r = curl_redirect( $c );
	curl_close($c);
         
	preg_match_all('/"post_hash":"(\w+)"/i', $r, $f1);
	preg_match_all('/"user_id":(\d+),/i', $r, $f2);
	preg_match_all('/handlePageParams\(\{"id":(\d+),/i', $r, $f3);
	return $f = array(
		'post_hash' => $f1[1][0],  
		'user_id'   => $f2[1][0],
		'my_id'     => $f3[1][0]);
	}

function _status($cookies, $hash, $url, $message, $title, $descr, $id) {
	global $url_vk, $registry;
	$u = urlencode($url);
	$m = urlencode($message);
	$t = urlencode($title);
	$d = urlencode($descr);
	$q = 'act=post&al=1&hash=' . $hash . '&message=' . $m . '&note_title=&official=1&status_export=&to_id='.$registry['vkid'].'&type=all&media_type=share&url=' . $u . '&title=' . $t . '&description=' . $d;
	$c = curl_init();  
	curl_setopt($c, CURLOPT_HEADER, 0);  
	curl_setopt($c, CURLOPT_HTTPHEADER, array('X-Requested-With: XMLHttpRequest'));
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);  
	curl_setopt($c, CURLOPT_POST, 1);  
	curl_setopt($c, CURLOPT_REFERER, $url_vk);
	//curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($c, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; ru; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13');  
	curl_setopt($c, CURLOPT_POSTFIELDS, $q);
	curl_setopt($c, CURLOPT_COOKIEJAR,  $cookies);
	curl_setopt($c, CURLOPT_COOKIEFILE, $cookies);
	curl_setopt($c, CURLOPT_TIMEOUT, 15);
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 15);
	curl_setopt($c, CURLOPT_URL, 'http://vk.com/al_wall.php');  
	$r = curl_exec($c);
	//$r = curl_redirect( $c );
	curl_close($c);
	return $r;
}

function vkPost($url, $message='message', $title='title', $descr='descr')  {    
	global $url_vk, $url_site;
	$o = '../cache/cookie.txt';
	$h = _params($o, $url_vk, true);

	if($h['my_id'] == 0) {
		_auth($o, $d, true);
		$h = _params($o, $url_vk, true);
	}

	if($h['my_id'] != 0) {
		$r = _status($o, $h['post_hash'], $url, $message, $title, $descr, $h['user_id']);
		$c = preg_match_all('/page_wall_count_all/smi',$r,$f);
		if( $c == 0 ) {return false;} else {return true;}
	}
}

function wp_vk_post_add($post_ID) {
	$post  = get_post($post_ID);
	$title = $post->post_title;
	$link  = get_permalink($post_ID);
	$descr = $post->post_content;
	$vkont = get_post_meta($post_ID, 'vkontakte', true);
         
	if(mb_strlen(trim($descr), 'UTF-8') >= 250) {
		$descr = strip_tags($descr);
		$descr = mb_substr($descr,0,250, 'UTF-8').'...';
	}
	$message = ' ' . $title;  
	if(mb_strlen(trim($message), 'UTF-8') >= 250) {
		$message = mb_substr($message,0,250, 'UTF-8').'...';
	}  
	if(mb_strlen(trim($title), 'UTF-8') >= 78) {
		$title = mb_substr($title,0,78, 'UTF-8').'...';
	}
	if($vkont != '0') {
		$status = vkPost($link, $message, $title, $descr);
		if($status) {update_post_meta($post_ID, 'vkontakte','1');} 
		else {	     update_post_meta($post_ID, 'vkontakte','0');}
	}
	return $post_ID;
}

$url_vk = clear_vk_url($registry['vkgroup']);
$registry['vkid'] = get_vk_gid($registry['vkgroup']);
$date=time();

$mass=array(20,60,90,120,150,180);
$lastdate=$DB->getOne("SELECT value FROM #__setting WHERE name='vkdate'");
$registry['err']=0;
if($registry['vkperiod']==0) $registry['err']=1;
if($registry['vkperiod']==1) $go=(time()-60*60)-$lastdate;
if($registry['vkperiod']==2) $go=(time()-60*60*24)-$lastdate;
if($registry['vkperiod']==3) $go=(time()-60*60*24*7)-$lastdate;
if($registry['vkperiod']==4) $go=(time()-60*60*24*30)-$lastdate;
if($registry['vkperiod']==5) $go=(time()-60*intval($registry['vkinterval']))-$lastdate;
if($registry['vkperiod']==6) $go=(time()-60*$mass[rand(0,5)])-$lastdate;

if(($registry['err']==0 and $go>0) or ($registry['vkperiod']==6 and $lastdate<(time()-60*60*3))) {
	$sql = "UPDATE #__setting SET value='$date' WHERE id='37' LIMIT 1";
	$DB->execute($sql);

   $sql = "SELECT s.*, c.name, c.podcat
	FROM #__status s
	LEFT JOIN #__category c ON s.cat=c.id
	WHERE s.pub = '0'
	ORDER BY s.id ASC
	LIMIT 1";
   $registry['status'] = $DB->getAll($sql);

   if(count($registry['status'])>0):
     $i=0;
     foreach ($registry['status'] as $item):
	$sql = "UPDATE #__status SET pub='1' WHERE id='{$registry['status'][0]['id']}' LIMIT 1";
	$DB->execute($sql);
	$title = $item['text'];
	$link  = $url_vk;//get_permalink($post_ID);
	$descr = $item['text'];
	//$vkont = get_post_meta($post_ID, 'vkontakte', true);
         
	if(mb_strlen(trim($descr), 'UTF-8') >= 1500) {
		$descr = strip_tags($descr);
		$descr = mb_substr($descr,0,1500, 'UTF-8').'...';
	}
	$message = ' ' . $title;  
	if(mb_strlen(trim($message), 'UTF-8') >= 1500) {
		$message = mb_substr($message,0,1500, 'UTF-8').'...';
	}  
	if(mb_strlen(trim($title), 'UTF-8') >= 78) {
		$title = mb_substr($title,0,78, 'UTF-8').'...';
	}
	$status = vkPost($link, $message, $title, $descr);
	$i++;
    endforeach;
   endif;
}
$registry['report']['post']=intval($i);
$registry['report']['left']=$DB->getOne('SELECT count(id) FROM #__status WHERE pub=0');
$registry['report']['total']=$DB->getOne('SELECT count(id) FROM #__status');
$registry['report']['public']=$DB->getOne('SELECT count(id) FROM #__status WHERE pub=1');
