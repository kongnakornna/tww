<?php
require './leone.php';
header('Content-Type: text/html; charset=tis-620');
//  if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("index.php");
$param_message = (!empty($_REQUEST["message"])) ? $_REQUEST["message"] : "";
$param_from = (!empty($_REQUEST["from"])) ? $_REQUEST["from"] : "";
$param_appid = (!empty($_REQUEST["appid"])) ? $_REQUEST["appid"] : "";
$param_rate = (!empty($_REQUEST["rate"])) ? $_REQUEST["rate"] : "";
$ipaddress = $_SERVER['REMOTE_ADDR']; 

if ($param_rate=='') $param_rate = "0";

$SqlUpdate = "insert into tbl_comment (c_appid,c_postby,c_message,c_date,c_rate,c_ipaddr) values ('".$param_appid."','".$param_from."','".$param_message."',now(),'".$param_rate."','".$ipaddress."')";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertClose("ขอบคุณสำหรับความคิดเห็นค่ะ.");
?>
<script language="javascript">
	parent.location.reload();
	parent.$.fancybox.close(); 
</script>