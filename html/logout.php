<?php
require './leone.php';
require './admin/controller/authenticate.php';
$authen = new authenticate();
$login_data = $authen->logout($_SESSION['TWEmail']);
unset($_SESSION['TWEmail']);
unset($_SESSION['TWFullname']);
unset($_SESSION['TWCode']);
unset($_SESSION['TWID']);
unset($_SESSION['ismemberlogin']);
unset($TWEmail); 
unset($TWFullname); 
unset($TWCode); 
unset($TWID); 
unset($ismemberlogin);
session_destroy();
?>
<script type="text/javascript">
<!--
	window.document.location.href = "mainpage.php";
//-->
</script>