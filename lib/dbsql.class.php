<?php 
/*
 *
 * CMS osRealty 2.1.x
 * Autor: Roman Chernyshov
 * E-mail: support@osRealty.ru
 * URL: www.osRealty.ru
 *
*/

class DB_Engine {

	var $config_params=array();

    /**
    *  Заполняется всеми выполненными запросами в течение генерации страницы.
    * <code> 
    * Формат:
    * array (   
    *  [0] => array( [operation] => getRow,
    *                [file] => /home/user/some.php,
    *                [line] => 222,
    *                [query] => SELECT * FROM table,
    *                [time] => 0.0235,
    *                [result] => array
    *              )
    *  [1] => ...
    * )
    * </code>
    * @access public 
    * @var array
    */
    var $sqls= array ();

    var $show_err= TRUE;
    var $prefix;
    /**
    *  Время выполения последнего запроса.
    *  @var float
    *  @access public
    */
    var $time_query= 0;

    /**
    *  ID элемента, полученный в результате выполнения последней команды INSERT 
    *  в таблицу с autoincrement'ным полем.
    *  @var integer
    *  @access public
    */
    var $id= 0;

    /**
     * Кол-во строк вернувшееся запросом
     *
     * @var integer
     */
    var $num_rows=0;
    /**
    *  Суммарное время выполнения всех запросов, со времени начала генерации страницы.
    *  @var float
    *  @access public
    */
    var $AllTimeQueries= 0;

    /**
    *  Конструктор класса. 
    *  @param string $type Тип BD (в настоящее время только mysql)
    *  @param string $server Host сервера (напр., localhost)
    *  @param string $user Имя пользователя (напр., root)
    *  @param string $pass Пароль пользователя (может быть пустым)
    *  @param string $dbname Имя базы данных (напр., invictum )
    *  @exception Если неизвестный тип BD, то выдает ошибку
    *  @return void
    */
    function DB_Engine($type, $server, $user, $pass, $dbname) {

        //$this->assoc = 'ASC';
        $this->type= $type; //mysql

        switch ($this->type) {
            case 'mysql' :
				$this->config_params = array('host'=>$server,'user'=>$user,'pass'=>$pass,'dbname'=>$dbname);

                $this->connectMySQL($server, $user, $pass, $dbname);
                break;
            default :
                die('Unknow DB: Change type of DB!');
                break;
        }

        /** Файл, с которого вызван текущий запрос */
        $this->file= null;

        /** Строка, с которой вызван текущий запрос */
        $this->line= null;

        /** Текущий запрос */
        $this->sql= null;

        /** Текущая операция */
        $this->oprt= null;

        /** Выводить ли ошибку, если текущий запрос ошибочен */
        $this->showerr= true;

    }

    /**
    *  Присоединение к MySQL-серверу.
    *  @access private
    *  @param string $server Host сервера (напр., localhost)
    *  @param string $user Имя пользователя (напр., root)
    *  @param string $pass Пароль пользователя (может быть пустым)
    *  @param string $dbname Имя базы данных (напр., invictum )
    *  @exception При невозможности присоединения выдает ошибку
    *  @return void
    */
    function connectMySQL($server, $user, $pass, $dbname) {

        $this->link_id= mysql_connect($server, $user, $pass);
        if ($this->link_id === false)
            die('Can\'t connect to DB. Server. '.$server.', user: '.$user);

        if (!mysql_select_db($dbname, $this->link_id))
            die('Can\'t select DB '.$dbname.' ');
		
		mysql_query('SET NAMES utf8', $this->link_id);
    }

    /**
    *  Распределяет выполнение запроса на необходимый тип БД
    *  Заполняет $this->{@link sqls},  $this->{@link time_query},  
    *  $this->{@link AllTimeQueries},  $this->{@link id},  
    *   и, при необходимости, логирует запросы.
    *  Если затребовано, то при некорректном запросе генерирует критическую ошибку.
    *  @access private
    *  @param TYPE $variable Распределяет выполнение запроса на необходимый тип БД
    *  @return mixed 
    */
    function operation($log=true) {
        if ($this->sql === null)
            return;

        $this->sql= (string) @ trim($this->sql);
        $this->time_query= $this->_mctime();

        switch ($this->type) {
            case 'mysql' :
                $result= $this->MySql($log);
                break;
            default :
                $result= false;
                break;
        }

        if ($result !== false) {
            $this->time_query= round($this->_mctime() - $this->time_query, 4);
            $this->AllTimeQueries += $this->time_query;
            $cur= & $this->sqls[];
            $cur['operation']= $this->oprt;
            $cur['file']= $this->file;
            $cur['line']= $this->line;
            $cur['query']= $this->sql;
            $cur['time']= $this->time_query;
            $cur['result']= sizeof($result);
            $this->id= mysql_insert_id();
            unset ($cur);
            $this->_clear();
            return $result;
        }

        if ($this->showerr and $this->show_err) {
            if (preg_match('#^[^\']*? \'(.*?)\' in#',mysql_error(),$filter=null))
                $this->sql = str_replace($filter[1], '<b>'.$filter[1].'</b>', $this->sql);
            $str= '<B>Ошибка DB:</B> <BR><BR>'.mysql_error().' <BR><BR> '.$this->sql.'';
            
            if (function_exists('critical_error'))
                critical_error($str, $this->file, $this->line);
            else {
                die($str);}
        }

        return false;
    }

    /**
    *  Выполнение запроса на MySQL сервере.
    *  @access private
    *  @return mixed Результат запроса
    */
    function MySql($log=true) {

        if ($this->sql === null)
            return;

        $query= mysql_query($this->sql, $this->link_id);
		
        
		
        if ($query === false)
            return false;

        switch ($this->oprt) {
            case 'getOne' :
            	$this->num_rows = mysql_numrows($query);
                $result= mysql_fetch_assoc($query);
                if ($result === false)
                    $result= array ();
                $result= (sizeof($result) != 0) ? current($result) : '';
                break;
            case 'getRow' :
            	$this->num_rows = mysql_numrows($query);
                $result= mysql_fetch_assoc($query);
                if ($result === false)
                    $result= array ();
                break;
            case 'getAll' :
            	$this->num_rows = mysql_numrows($query);
                $result= array ();
                while ($row= mysql_fetch_assoc($query))
                    $result[]= $row;
                break;
            case 'getCol' :
            	$this->num_rows = mysql_numrows($query);
                $result= array ();
                while ($row= mysql_fetch_assoc($query))
                    $result[]= current($row);
                break;
            case 'execute' :
            /*	if ($log)
            		saveLogAction($this->sql);*/
                return true;
        }

        return $result;

    }

    /**
    *  Подготовить переменную к вносу в БД (квотирование и слеширование).
    *  @access public
    *  @param string $string Var
    *  @return string slashedVar
    */
    function prepare($string_var) {
        $string_var= trim($string_var);
        return mysql_real_escape_string($string_var);
    }

    /**
    *  Alias функции {@link $DB->prepare()}
    *  @access public
    *  @return string slashedVar
    */
    function pre($string_var) {
        return $this->prepare($string_var);
    }

    /**
    *  Возвращает предыдущий выполненный запрос.
    *  Или указаную инфрмацию по предыдущему запросу.
    *  @access public
    *  @param operation|file|line|query|time|result $string Допустимые поля
    *  @return string
    */
    function LastQuery($field= 'query') {
        $last= end($this->sqls);
        return $last[$field];
    }

    /**
    *  Проверяет существует ли таблица.
    *  @access public
    *  @param string $table Имя таблицы
    *  @param boolean $ShowError Генерировать ошибку при неверном запросе
    *  @return boolean
    */
    function TableExists($table, $ShowError= true) {
        return (boolean) sizeof((array) $this->operation('getAll', "SHOW TABLE STATUS LIKE '".$this->pre($table)."'", $ShowError));
    }

    /**
    *  Выбрать только одно значение.
    *  <code>   getOne("SELECT `a`,`b` FROM `table`") : 
    *           string(5) var_a </code>
    *  @access public
    *  @param string $sql SQL-запрос
    *  @param boolean $ShowError Генерировать ошибку при неверном запросе
    *  @return mixed
    */
    function getOne($sql, $ShowError= true) {
	if(!empty($this->prefix))$sql=str_replace('#__',$this->prefix,$sql);
//        list ($this->file, $this->line)= LastFileLine(1);
        $this->sql= $sql;
        $this->oprt= 'getOne';
        $this->showerr= (bool) $ShowError;
        return $this->operation();
    }


    /**
    *  Выбрать строку.
    *  <code>   getRow("SELECT `a`,`b` FROM `table`") : 
    *           array( 'a' => 'var_a', 'b' => 'var_b' ) </code>
    *  @access public
    *  @param string $sql SQL-запрос
    *  @param boolean $ShowError Генерировать ошибку при неверном запросе
    *  @return mixed
    */
    function getRow($sql, $ShowError= true) {
	if(!empty($this->prefix))$sql=str_replace('#__',$this->prefix,$sql);
//        list ($this->file, $this->line)= LastFileLine(1);
        $this->sql= $sql;
        $this->oprt= 'getRow';
        $this->showerr= (bool) $ShowError;
        return $this->operation();
    }

    /**
    *  Выбрать столбец.
    *  <code>   getCol("SELECT `a`,`b` FROM `table`") : 
    *           array( 0 => 'var_a1', 1 => 'var_a2' ) </code>
    *  @access public
    *  @param string $sql SQL-запрос
    *  @param boolean $ShowError Генерировать ошибку при неверном запросе
    *  @return mixed
    */
    function getCol($sql, $ShowError= true) {
	if(!empty($this->prefix))$sql=str_replace('#__',$this->prefix,$sql);
//        list ($this->file, $this->line)= LastFileLine(1);
        $this->sql= $sql;
        $this->oprt= 'getCol';
        $this->showerr= (bool) $ShowError;
        return $this->operation();
    }

    /**
    *  Выбрать ассоциированный массив.
    *  <code>   getAll("SELECT `a`,`b` FROM `table`") : 
    *           array( 0 => array('a'=>'var_a1', 'b'=>'var_b1'), 
    *                  1 => array('a'=>'var_a2', 'b'=>'var_b2'), ) </code>
    *  @access public
    *  @param string $sql SQL-запрос
    *  @param boolean $ShowError Генерировать ошибку при неверном запросе
    *  @return mixed
    */
    function getAll($sql, $ShowError= true) {
	if(!empty($this->prefix))$sql=str_replace('#__',$this->prefix,$sql);
//        list ($this->file, $this->line)= LastFileLine(1);
        $this->sql= $sql;
        $this->oprt= 'getAll';
        $this->showerr= (bool) $ShowError;
        return $this->operation();
    }

    /**
    *  Выполнить запрос.
    *  <code>execute("DELETE FROM `table` `a`") : true</code>
    *  @access public
    *  @param string $sql SQL-запрос
    *  @param boolean $ShowError Генерировать ошибку при неверном запросе
    *  @return boolean Результат операции
    */
    function execute($sql, $ShowError= true, $log = true) {
	if(!empty($this->prefix))$sql=str_replace('#__',$this->prefix,$sql);
//        list ($this->file, $this->line)= LastFileLine(1);
        $this->sql= $sql;
        $this->oprt= 'execute';
        $this->showerr= (bool) $ShowError;
        return $this->operation($log);
    }

    /**
    *  Возвращает следующий номер автоинкрементного id в указанной таблице
    *  @access public
    *  @param string $tablename Имя таблицы (напр., ".PRFX."files)
    *  @return integer
    */
    function nextID($tablename) {
//        list ($this->file, $this->line)= LastFileLine(1);
        $this->sql= "SHOW TABLE STATUS LIKE '".$tablename."'";
        $this->oprt= 'getRow';
        $this->showerr= true;
        $infotable= $this->operation();
        return (integer) @ $infotable['Auto_increment'];
    }

    /**
    *  Возвращает значение временных переменных в исходное состояние
    *  @access private
    *  @return void
    */
    function _clear() {
        $this->file= null;
        $this->line= null;
        $this->sql= null;
        $this->oprt= null;
        $this->showerr= true;
    }

    /**
    *  Возвращает текущее число секунд и микросекунд.
    *  @access private
    *  @return float
    */
    function _mctime() {
        list ($sec, $msec)= explode(' ', microtime());
        return $sec + $msec;
    }


	function dump_db($path, $table='', $filename='')
		{
		$database = $this->config_params['dbname'];

		$tables=array();
		if ($table=="")
			{
			$tables = $this->getAll('SHOW TABLES '.($table!="" ? 'FROM `'.$database.'`' : ''));
			$filename = $filename=="" ? $database : $filename;
			}
		else
			$tables[0]['Tables_in_'.$database]=$table;

		$file_name = $path.$filename.".sql";

		if ($table!="")
			{
			$present=false;
			$tmp = $this->getAll('SHOW TABLES');
			foreach ($tmp as $num => $tab_tmp)
				{
				if ($tab_tmp['Tables_in_'.$database]==$table)
					{
					$present=true;
					break;
					}
				}
			if (!$present) return;
			}

		 $data='';

		foreach($tables as $num => $tabelle)
			{		 
			$tabelle = $tabelle['Tables_in_'.$database];

			echo $tabelle;

			$def = "";
			$def .= "DROP TABLE IF EXISTS `$tabelle`;\n";
			$def .= "CREATE TABLE `$tabelle` ("; 

			$result3 = $this->getAll("SHOW FIELDS FROM `".$tabelle."`");
			foreach($result3 as $num => $row)
				{
				$def .= "`$row[Field]` $row[Type]";
				
				if ($row["Default"] != "")	$def .= " DEFAULT '$row[Default]'";
				if ($row["Null"] != "YES")	$def .= " NOT NULL";
				if ($row['Extra'] != "")	$def .= " $row[Extra]";

				$def .= ",";
				}

			 $def = ereg_replace(",$","", $def);

			 $result3 = $this->getAll("SHOW KEYS FROM `".$tabelle."`");
			 foreach($result3 as $num => $row) 
				 {
				 $kname=$row['Key_name'];

				 if(($kname != "PRIMARY") && ($row['Non_unique'] == 0)) $kname="UNIQUE|$kname";

				 if(!isset($index[$kname])) $index[$kname] = array();

				 $index[$kname][] = $row['Column_name'];
				 }
			
			 while(list($xy, $columns) = @each($index)) 
				 {
				 $def .= ",";
				 if($xy == "PRIMARY") $def .= " PRIMARY KEY (" . implode($columns, ", ") . ")";
				 else if (substr($xy,0,6) == "UNIQUE") $def .= " UNIQUE ".substr($xy,7)." (" . implode($columns, ", ") . ")";
				 else $def .= " KEY $xy (" . implode($columns, ", ") . ")";
				 }

			$def .= ");\n";
			 
			$fd = fopen($file_name,"a+"); 
			fwrite($fd, $def); 
			fclose($fd);

			$data='';
			$ergebnis=array();

			

			if ($tabelle>"")
				{  
				$ergebnis[]=1;

				$result=mysql_query("SELECT * FROM `".$tabelle."`", $this->link_id);
				$anzahl= mysql_num_rows($result); 
				$spaltenzahl = mysql_num_fields($result); 

				for ($i=0;$i<$anzahl;$i++) 
					{ 
					$zeile=mysql_fetch_array($result); 
				
					$data.="INSERT INTO `$tabelle` ("; 
					for ($spalte = 0; $spalte < $spaltenzahl;$spalte++) 
						{ 
						$feldname = mysql_field_name($result, $spalte); 

						if($spalte == ($spaltenzahl - 1)) 
							{ 
							$data.= '`'.$feldname.'`'; 
							} 
						else 
							{ 
							$data.= '`'.$feldname."`, "; 
							} 
						}; 

					$data.=") VALUES ("; 
					
					for ($k=0;$k < $spaltenzahl;$k++)
						{ 
						$data_val = mysql_escape_string($zeile[$k]);

						$data_val = str_replace("\r\n", '\r\n',$data_val);
						$data_val = str_replace("\r", '\r',$data_val);
						$data_val = str_replace("\n", '\n',$data_val);

						if($k == ($spaltenzahl - 1)) 
							{ 
							$data.="'".$data_val."'"; 
							}
						else 
							{ 
							$data.="'".$data_val."',"; 
							} 
						} 

					$data.= ");\n"; 
					} 
				
				$data.= "\n";
				} 
			else 
				{ 
				$ergebnis[]= $err; 
				} 

			$fd = fopen($file_name,"a+"); 
			for ($i3=0;$i3<count($ergebnis);$i3++)
				{ 
				fwrite($fd, $data); 
				fclose($fd);	
				} 
			}
		}

	function importModuleTable($table, $module_name)
		{
		global $CONFIG;
		
		$dir = $_SERVER['DOCUMENT_ROOT'].'/MODULES/'.$module_name.'/sqls';

		$file = $dir.'/'.$table.'.sql';

		if (is_file($file))
			{
			$sqls = file($file);

			foreach($sqls as $line)
				{
				$line=trim($line);
				if ($line=="") continue;
				$this->execute($line);
				}

			unset($sqls);
			return true;
			}
		else
			return false;			
		}
	}
