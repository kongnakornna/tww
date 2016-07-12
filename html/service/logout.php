<?php
require '../leone.php';
require './controller/authenticate.php';
$authen = new authenticate();
$login_data = $authen->logout($_SESSION['TWZUsername']);
unset($_SESSION['TWZUsername']);
unset($_SESSION['TWZFullname']);
unset($_SESSION['TWZEmail']);
unset($_SESSION['TWZID']);
unset($_SESSION['TWZPermission']);
unset($_SESSION['TWZGroup']);
unset($_SESSION['klogin']);
unset($TWZUsername); 
unset($TWZFullname); 
unset($TWZEmail); 
unset($TWZID); 
unset($TWZPermission); 
unset($TWZGroup); 
unset($klogin); 
session_destroy();
?>
<script type="text/javascript">
<!--
	window.document.location.href = "index.php";
//-->
</script>