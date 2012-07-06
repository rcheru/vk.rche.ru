<?php
/**
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
 */

function add_pr ($str,$count) {
	$str=iconv('UTF-8','WINDOWS-1251',$str);
	$i = 0;$no_pr = 0;$j = 1;
	while ($i < strlen($str))
		{
		$text[$j] = $text[$j].$str[$i];
		if ($str[$i] == ' '){$no_pr = 0;$j = $j+1;}
		if ($str[$i] != ' '){$no_pr = $no_pr+1;}
		if ($no_pr == $count){$text[$j] = $text[$j].' ';$no_pr = 0;}
		$i = $i+1;
		}
	while ($j != 0){$st = $st.$text[$j];$j = $j-1;}
	$st=iconv('WINDOWS-1251','UTF-8',$st);
	return $st;
}

function PHP_slashes($string,$type='add') {
    if ($type == 'add')
    {
        if (get_magic_quotes_gpc())
        {
            return $string;
        }
        else
        {
            if (function_exists('addslashes'))
            {
                return addslashes($string);
            }
            else
            {
                return mysql_real_escape_string($string);
            }
        }
    }
    else if ($type == 'strip')
    {
        return stripslashes($string);
    }
    else
    {
        die('error in PHP_slashes (mixed,add | strip)');
    }
}

if(!function_exists('utf8_strlen')) {
	function utf8_strlen($s)
		{
		return preg_match_all('/./u', $s, $tmp);
		}
}

if(!function_exists('utf8_substr')) {
	function utf8_substr($s, $offset, $len = 'all')
		{
		if ($offset<0) $offset = utf8_strlen($s) + $offset;
		if ($len!='all')
			{
			if ($len<0) $len = utf8_strlen2($s) - $offset + $len;
			$xlen = utf8_strlen($s) - $offset;
			$len = ($len>$xlen) ? $xlen : $len;
			preg_match('/^.{' . $offset . '}(.{0,'.$len.'})/us', $s, $tmp);
			}
			else
			{
			preg_match('/^.{' . $offset . '}(.*)/us', $s, $tmp);
			}
		return (isset($tmp[1])) ? $tmp[1] : false;
		}
}
if(!function_exists('utf8_strpos')) {
	function utf8_strpos($str, $needle, $offset = null)
	      {
	          if (is_null($offset))
	          {
	              return mb_strpos($str, $needle);
	          }
	          else
	          {
	              return mb_strpos($str, $needle, $offset);
	          }
	      }
}
if(!function_exists('generate_chpu')) {
	function generate_chpu ($str)
		{
		$converter = array(
	        'а' => 'a',   'б' => 'b',   'в' => 'v',
	        'г' => 'g',   'д' => 'd',   'е' => 'e',
	        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
	        'и' => 'i',   'й' => 'y',   'к' => 'k',
	        'л' => 'l',   'м' => 'm',   'н' => 'n',
	        'о' => 'o',   'п' => 'p',   'р' => 'r',
	        'с' => 's',   'т' => 't',   'у' => 'u',
	        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
	        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
	        'ь' => '',  'ы' => 'y',   'ъ' => '',
	        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
        
	        'А' => 'A',   'Б' => 'B',   'В' => 'V',
	        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
	        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
	        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
	        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
	        'О' => 'O',   'П' => 'P',   'Р' => 'R',
	        'С' => 'S',   'Т' => 'T',   'У' => 'U',
	        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
	        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
	        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
	        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
		);
		$str = strtr($str, $converter);
		$str = strtolower($str);
		$str = preg_replace('~[^-a-z0-9_]+~u', '-', $str);
		$str = trim($str, "-");
		return $str;
		}
}

function generate_password($number) {
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0');
    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
}

function genpass($number, $param = 1) {
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0','.',',',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*','$',
                 '<','>','/','|','+','-',
                 '{','}','`','~');

    $pass = "";
    for($i = 0; $i < $number; $i++)
    {
      if ($param>count($arr)-1)$param=count($arr) - 1;
      if ($param==1) $param=48;
      if ($param==2) $param=58;
      if ($param==3) $param=count($arr) - 1;

      $index = rand(0, $param);
      $pass .= $arr[$index];
    }
    return $pass;
}

function parseString( $str , $val, $par) {
        if ($par==1)$str = str_replace('\\','',preg_replace("/['\"`!\\/@№;:?#$%^&*()_]/","",@strval($str))); // удаляет все кавычки вообще
        if ($val>=1)$str = trim( $str ); // удаляет пробельные символы вначале и в конце строки
        if ($val>=2)$str = str_replace(' ','',$str); // удаляет вообще все пробелы
        if ($val>=3)$str = preg_replace("/[^\x20-\xFF]/","",@strval($str)); // удаляет непечатаемые, опасные символы
        if ($val>=4)$str = strip_tags( $str ); // удаляет все html тэги
        if ($val>=5)$str = htmlspecialchars( $str, ENT_QUOTES ); // все специальные символы типа кавычек и т.п. перекодируются в вид html сущностей типа "<" и др
        if ($val>=6)$str = mysql_real_escape_string( $str ); // выполняется экранирование строки для sql запроса специальной функцией
        return $str;
}

function email_check($email) {
	if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",trim($email)))
		{
		 return false;
		}
		else return true;
}

function isIP($ip) {
	return (bool)(ip2long($ip)>0);
}

function getIP() {
   if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
   return $_SERVER['REMOTE_ADDR'];
}

function rdate($param, $time=0) {
	if(intval($time)==0)$time=time();
	$MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
	if(strpos($param,'M')===false) return date($param, $time);
		else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}
