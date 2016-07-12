<?php
Class TemplateClass extends MySqlDB {
    function assign($tpl_var, $value = null)
    {
        if (is_array($tpl_var)){
            foreach ($tpl_var as $key => $val) {
                if ($key != '') {
                    $this->_tpl_vars[$key] = $val;
                }
            }
        } else {
            if ($tpl_var != '')
                $this->_tpl_vars[$tpl_var] = $value;
        }
    }

	function display($tpl_file)
	{
        $tpl_line=join("",file("./templates/" . $tpl_file . ".php"));
        if (is_array($this->_tpl_vars)){
			 foreach ($this->_tpl_vars as $key => $val) {
                 $tpl_line = str_replace ("$key",$val,$tpl_line);
			 }
		}
		$this->DBClose();
		echo $tpl_line;
	}

	function displayBackend($tpl_file)
	{
        $tpl_line=join("",file("../templates/" . $tpl_file . ".php"));
        if (is_array($this->_tpl_vars)){
			 foreach ($this->_tpl_vars as $key => $val) {
                 $tpl_line = str_replace ("$key",$val,$tpl_line);
			 }
		}
		$this->DBClose();
		echo $tpl_line;
	}

    function include_file($filename)
    {
        if ( file_exists($filename) && ($fd = @fopen($filename, 'rb')) ) {
            $contents = '';
            while (!feof($fd)) {
                $contents .= fread($fd, 8192);
            }
            fclose($fd);
            return $contents;
        } else {
            return false;
        }
    }
}
$Template = new TemplateClass();
?>