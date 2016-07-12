<?php
require './leone.php';
require './admin/controller/partner.php';
$partner = new partner();
$login_data = $partner->logout($_SESSION['DVEmail']);
unset($_SESSION['DVEmail']);
unset($_SESSION['DVFullname']);
unset($_SESSION['DVCode']);
unset($_SESSION['DVID']);
unset($_SESSION['isdevlogin']);
unset($DVEmail); 
unset($DVFullname); 
unset($DVCode); 
unset($DVID); 
unset($isdevlogin);
?>
<script type="text/javascript">
<!--
	window.document.location.href = "mainpage.php";
//-->
</script>