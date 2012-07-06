<?php
/*
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
*/

class flexibleAccess{
  var $dbName = 'database';
  var $dbHost = 'localhost';
  var $dbPort = 3306;
  var $dbUser = 'user';
  var $dbPass = 'password';
  var $dbTable  = 'users';
  var $dbPrefix  = 'osr';
  var $sessionVariable = 'userSessionValue';
  var $tbFields = array(
	'userID'=> 'userID', 
	'login' => 'username',
	'pass'  => 'password',
	'email' => 'email',
	'active'=> 'active'
  );
  var $remTime = 600;
  var $remCookieName = 'ckSavePass';
  var $remCookieDomain = '';
  var $passMethod = 'sha1';
  var $displayErrors = false;
  var $userID;
  var $dbConn;
  var $userData=array();

  /**
   * Class Constructure
   * 
   * @param string $dbConn
   * @param array $settings
   * @return void
   */
  function flexibleAccess($dbConn = '', $settings = '')
  {
	    if ( is_array($settings) ){
		    foreach ( $settings as $k => $v ){
				    if ( !isset( $this->{$k} ) ) die('Property '.$k.' does not exists. Check your settings.');
				    $this->{$k} = $v;
			}
	    }
	    $this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;
	    $this->dbConn = ($dbConn=='')? mysql_connect($this->dbHost.':'.$this->dbPort, $this->dbUser, $this->dbPass):$dbConn;
	    if ( !$this->dbConn ) die(mysql_error($this->dbConn));
	    mysql_select_db($this->dbName, $this->dbConn)or die(mysql_error($this->dbConn));
		mysql_query('SET NAMES utf8');
		mysql_query('SET CHARACTER SET utf8');
		mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"');

	    if( !isset( $_SESSION ) ) session_start();
	    if ( !empty($_SESSION[$this->sessionVariable]) )
	    {
		    $this->loadUser( $_SESSION[$this->sessionVariable] );
	    }
	    //Maybe there is a cookie?
	    if ( isset($_COOKIE[$this->remCookieName]) && !$this->is_loaded()){
	      //echo 'I know you<br />';
	      $u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
	      $this->login($u['uname'], $u['password']);
	    }
  }
  function login($uname, $password, $remember = false, $loadUser = true)
  {
    	$uname    = $this->escape($uname);
    	$password = $originalPassword = $this->escape($password);
		$res1 = $this->query("SELECT * FROM `{$this->dbPrefix}users` WHERE `username` = '$uname' LIMIT 1",__LINE__);
		if ( @mysql_num_rows($res1) == 0)
			return false;

		$this->userData = mysql_fetch_array($res1);
		$password=sha1($this->userData['salt'].sha1($password));

		$res2 = $this->query("SELECT * FROM `{$this->dbPrefix}users` WHERE `username` = '$uname' and `password` = '$password' and group_id>0 LIMIT 1",__LINE__);
		if ( @mysql_num_rows($res2) == 0)
			return false;

		if ( $loadUser )
		{
			$this->userData = mysql_fetch_array($res2);

			$this->userData['userID']=$this->userData['id'];
			$this->userData['gid']=$this->userData['group_id'];
			$this->userData['city']=$this->userData['city'];
			$this->userData['username']=$this->userData['username'];
			$this->userData['region']=$this->userData['region'];
			if($this->userData['gid']==1)$this->userData['gid']=25;
			if($this->userData['gid']==3)$this->userData['gid']=18;
			if($this->userData['gid']==4)$this->userData['gid']=24;
			if($this->userData['gid']==5)$this->userData['gid']=23;
	header('P3P: CP="CUR ADM"');
	$cookie_name = 'forum_cookie_5110d1';
	$cookie_domain = '';
	$cookie_path = '/';
	$cookie_secure = 0;
	$expire = time() + 600;//1209600;
	$user_id=$this->userData['userID'];
	$form_password_hash=$this->userData['password'];
	$salt=$this->userData['salt'];
	$value=base64_encode($user_id.'|'.$form_password_hash.'|'.$expire.'|'.sha1($salt.$form_password_hash.sha1($salt.sha1($expire))));

	if (version_compare(PHP_VERSION, '5.2.0', '>='))
		setcookie($cookie_name, $value, $expire, $cookie_path, $cookie_domain, $cookie_secure, true);
	else
		setcookie($cookie_name, $value, $expire, $cookie_path.'; HttpOnly', $cookie_domain, $cookie_secure);

			$this->userID = $this->userData[$this->tbFields['userID']];

			$_SESSION[$this->sessionVariable] = $this->userID;
			if ( $remember ){
			  $cookie = base64_encode(serialize(array('uname'=>$uname,'password'=>$originalPassword)));
			  $a = setcookie($this->remCookieName, 
			  $cookie,time()+$this->remTime, '/', $this->remCookieDomain);
			}
		}
		return true;
  }
  
  /**
  	* Logout function
  	* param string $redirectTo
  	* @return bool
  */
  function logout($redirectTo = '')
  {
    setcookie($this->remCookieName, '', time()-3600);

    $cookie_name = 'forum_cookie_5110d1';
	$cookie_domain = '';
	$cookie_path = '/';
	$cookie_secure = 0;
	$expire = time() - 3600;//1209600;

	if (version_compare(PHP_VERSION, '5.2.0', '>='))
		setcookie($cookie_name, '', $expire, $cookie_path, $cookie_domain, $cookie_secure, true);
	else
		setcookie($cookie_name, '', $expire, $cookie_path.'; HttpOnly', $cookie_domain, $cookie_secure);


    $_SESSION[$this->sessionVariable] = '';
    $this->userData = '';
    if ( $redirectTo != '' && !headers_sent()){
	   header('Location: '.$redirectTo );
	   exit;//To ensure security
	}
  }
  /**
  	* Function to determine if a property is true or false
  	* param string $prop
  	* @return bool
  */
  function is($prop){
  	return $this->get_property($prop)==1?true:false;
  }
  
    /**
  	* Get a property of a user. You should give here the name of the field that you seek from the user table
  	* @param string $property
  	* @return string
  */
  function get_property($property)
  {
    if (empty($this->userID)) $this->error('No user is loaded', __LINE__);
    if (!isset($this->userData[$property])) $this->error('Unknown property <b>'.$property.'</b>', __LINE__);
    return $this->userData[$property];
  }
  /**
  	* Is the user an active user?
  	* @return bool
  */
  function is_active()
  {
    return $this->userData[$this->tbFields['active']];
  }
  
  /**
   * Is the user loaded?
   * @ return bool
   */
  function is_loaded()
  {
    return empty($this->userID) ? false : true;
  }
  /**
  	* Activates the user account
  	* @return bool
  */
  function activate()
  {
    if (empty($this->userID)) $this->error('No user is loaded', __LINE__);
    if ( $this->is_active()) $this->error('Allready active account', __LINE__);
    $res = $this->query("UPDATE `{$this->dbPrefix}{$this->dbTable}` SET {$this->tbFields['active']} = 1 
	WHERE `{$this->tbFields['userID']}` = '".$this->escape($this->userID)."' LIMIT 1");
    if (@mysql_affected_rows() == 1)
	{
		$this->userData[$this->tbFields['active']] = true;
		return true;
	}
	return false;
  }
  /*
   * Creates a user account. The array should have the form 'database field' => 'value'
   * @param array $data
   * return int
   */  
  function insertUser($data){
    if (!is_array($data)) $this->error('Data is not an array', __LINE__);
    switch(strtolower($this->passMethod)){
	  case 'sha1':
	  	$password = "SHA1('".$data[$this->tbFields['pass']]."')"; break;
	  case 'md5' :
	  	$password = "MD5('".$data[$this->tbFields['pass']]."')";break;
	  case 'nothing':
	  	$password = $data[$this->tbFields['pass']];
	}
    foreach ($data as $k => $v ) $data[$k] = "'".$this->escape($v)."'";
    $data[$this->tbFields['pass']] = $password;
    $this->query("INSERT INTO `{$this->dbPrefix}{$this->dbTable}` (`".implode('`, `', array_keys($data))."`) VALUES (".implode(", ", $data).")");
    return (int)mysql_insert_id($this->dbConn);
  }
  /*
   * Creates a random password. You can use it to create a password or a hash for user activation
   * param int $length
   * param string $chrs
   * return string
   */
  function randomPass($length=10, $chrs = '1234567890qwertyuiopasdfghjklzxcvbnm'){
    for($i = 0; $i < $length; $i++) {
        $pwd .= $chrs{mt_rand(0, strlen($chrs)-1)};
    }
    return $pwd;
  }
  ////////////////////////////////////////////
  // PRIVATE FUNCTIONS
  ////////////////////////////////////////////
  
  /**
  	* SQL query function
  	* @access private
  	* @param string $sql
  	* @return string
  */
  function query($sql, $line = 'Uknown')
  {
    //if (defined('DEVELOPMENT_MODE') ) echo '<b>Query to execute: </b>'.$sql.'<br /><b>Line: </b>'.$line.'<br />';
	$res = mysql_db_query($this->dbName, $sql, $this->dbConn);
	if ( !res )
		$this->error(mysql_error($this->dbConn), $line);
	return $res;
  }

  function loadUser($userID)
  {
	$res = $this->query("SELECT * FROM `{$this->dbPrefix}users` 
			WHERE `id` = '".$this->escape($userID)."' LIMIT 1");
    if ( mysql_num_rows($res) == 0 )
    	return false;
    $this->userData = mysql_fetch_array($res);
    $this->userID = $userID;

	$this->userData['userID']=$this->userData['id'];
	$this->userData['gid']=$this->userData['group_id'];
	$this->userData['city']=$this->userData['city'];
	$this->userData['username']=$this->userData['username'];
	$this->userData['region']=$this->userData['region'];
	if($this->userData['gid']==1)$this->userData['gid']=25;
	if($this->userData['gid']==3)$this->userData['gid']=18;
	if($this->userData['gid']==4)$this->userData['gid']=24;
	if($this->userData['gid']==5)$this->userData['gid']=23;

    $this->userData['active']=1;

    $_SESSION[$this->sessionVariable] = $this->userID;
    return true;
  }

  /**
  	* Produces the result of addslashes() with more safety
  	* @access private
  	* @param string $str
  	* @return string
  */  
  function escape($str) {
    $str = get_magic_quotes_gpc()?stripslashes($str):$str;
    $str = mysql_real_escape_string($str, $this->dbConn);
    return $str;
  }
  
  /**
  	* Error holder for the class
  	* @access private
  	* @param string $error
  	* @param int $line
  	* @param bool $die
  	* @return bool
  */  
  function error($error, $line = '', $die = false) {
    if ( $this->displayErrors )
    	echo '<b>Error: </b>'.$error.'<br /><b>Line: </b>'.($line==''?'Unknown':$line).'<br />';
    if ($die) exit;
    return false;
  }
}
