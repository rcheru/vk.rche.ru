<?php
/**
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
 */

defined('_JEXEC') or die('Restricted access');

if($registry['install_inter_page']==1):

function remove_comments(&$output)
{
   $lines = explode("\n", $output);
   $output = "";
   $linecount = count($lines);
   $in_comment = false;
   for($i = 0; $i < $linecount; $i++)
   {
      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
      {
         $in_comment = true;
      }
      if( !$in_comment )
      {
         $output .= $lines[$i] . "\n";
      }
      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
      {
         $in_comment = false;
      }
   }
   unset($lines);
   return $output;
}

function remove_remarks($sql)
{
   $lines = explode("\n", $sql);
   $sql = "";
   $linecount = count($lines);
   $output = "";
   for ($i = 0; $i < $linecount; $i++)
   {
      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
      {
         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
         {
            $output .= $lines[$i] . "\n";
         }
         else
         {
            $output .= "\n";
         }
         $lines[$i] = "";
      }
   }
   return $output;
}

function split_sql_file($sql, $delimiter)
{
   $tokens = explode($delimiter, $sql);
   $sql = "";
   $output = array();
   $matches = array();
   $token_count = count($tokens);
   for ($i = 0; $i < $token_count; $i++)
   {
      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
      {
         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
         $unescaped_quotes = $total_quotes - $escaped_quotes;
         if (($unescaped_quotes % 2) == 0)
         {
            $output[] = $tokens[$i];
            $tokens[$i] = "";
         }
         else
         {
            $temp = $tokens[$i] . $delimiter;
            $tokens[$i] = "";
            $complete_stmt = false;
            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
            {
               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
               $unescaped_quotes = $total_quotes - $escaped_quotes;
               if (($unescaped_quotes % 2) == 1)
               {
                  $output[] = $temp . $tokens[$j];
                  $tokens[$j] = "";
                  $temp = "";
                  $complete_stmt = true;
                  $i = $j;
               }
               else
               {
                  $temp .= $tokens[$j] . $delimiter;
                  $tokens[$j] = "";
               }
            } // for..
         } // else
      }
   }

   return $output;
}

if($_POST['install']==1) {
	$fname='install.sql';
	@ini_set('memory_limit', '5120M');
	@set_time_limit ( 0 );
	$dbms_schema = 'install.sql';
	$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem ');
	$sql_query = remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, ';');
	$i=1;
	foreach($sql_query as $sql) {
	$sql=str_replace('#__',$settings['dbPrefix'],$sql);
	$DB->execute($sql);
	}
	$message[0]='valid';
	$message[1]='Установка успешно произведена, выполнено $i команд. <br>
			Удалите файлы "/apanel/install.php" и "/apanel/install.sql" с сервера!';
}
$DB->show_err=true;
$checkinstall=$DB->getOne("SELECT value FROM #__setting WHERE id='28'");

else: die('Access denied...'); endif;
