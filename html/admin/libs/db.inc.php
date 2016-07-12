<?php
Class MySqlDB {
	function ConnectDB($database_host,$database_name,$database_username,$database_password)	{
        global $database_host,$database_name,$database_username,$database_password;
	 $Link = mysql_connect("$database_host:3306",$database_username,$database_password);
	 $Dbs = mysql_select_db("$database_name",$Link);
	  if (!$Link) {
		$this->ErrMsg(mysql_error(),"MySql authenticate error please contact <a href=\"mailto:preeda_na@yahoo.com\">preeda_na@yahoo.com</a>");
	  }
	  return $Dbs;
	}

	function DataExecute($SQL)
	{
	  mysql_query("SET CHARACTER SET tis620");
          #error_log("DataExecute Query => ".$SQL."\n",3,"/tmp/mylog.txt")
	  $result = mysql_query($SQL);
	  if (!$result) {
		$this->ErrMsg(mysql_error(),$SQL);
	  }
	  return $result; 
	}

	function DBfetch_array($result,$row)
	{
	  mysql_data_seek($result,$row);
	  $array = mysql_fetch_array($result);
	  return $array;
	  mysql_free_result ($result);
	}

	function DBfetch_row($result,$row)
	{
	  mysql_data_seek($result,$row);
	  $array = mysql_fetch_row($result);
	  return $array;
	  mysql_free_result ($result);
	}

	function DBfieldname($result,$fldnum)
	{
	  $str = mysql_fieldname($result,$fldnum);
	  return $str;
	}

	function DBfieldtype($result,$fldnum)
	{
	  $type =mysql_fieldtype($result,$fldnum);
	  return $type;
	}

	function DBfetch_object($result,$row)
	{
	  mysql_data_seek($result,$row);
	  $obj = msyql_fetch_object($result);
	  return $obj;
	}

	function DBNumRows($result)
	{
	  $rows = mysql_numrows($result);
	  return $rows; 
	}

	function DBNumFields($result)
	{
	  $fld = mysql_numfields($result);
	  return $fld;
	}

	function DB_insert_id($result)
	{
	  $lastid = mysql_insert_id($result);
	  return $lastid;
	}

	function DBClose()
	{
	   mysql_close();
	}

	function dbCommit()
	{
	   mysql_query("COMMIT");
	}

	function ErrMsg($Txt,$Title)
	{
	echo "<H1>Error: $Title </H1>\n" ;
	echo $Txt;
	die -1;
	}
}
$DatabaseClass = new MySqlDB();
$database_connect = $DatabaseClass->ConnectDB($database_host,$database_name,$database_username,$database_password);
?>
