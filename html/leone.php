<?php
require 'leone.conf.php';
if (strpos($libs_folder, '/') === FALSE) {	
	if (function_exists('realpath') AND @realpath(dirname(__FILE__)) !== FALSE)	{
		$libs_folder = realpath(dirname(__FILE__)).'/'.$libs_folder;
	}
}else{
	$libs_folder = str_replace("\\", "/", $libs_folder); 
}
define('EXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION));
define('FCPATH', __FILE__);
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('LIBSPATH', $libs_folder . $Ext);

$files = scandir(LIBSPATH);
foreach ($files as &$file) {
	if ($file!='.' && $file!='..'  && $file!='.svn' ) {
		require $libs_folder . $Ext . $file;
	}
}
session_start();
?>