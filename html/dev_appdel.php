<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlAdd = "update tbl_product set p_status='9' where p_id='".$param_id."'";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ระบบได้หยุดการขายแอปเรียบร้อยค่ะ.","dev_applist.php");
die();
?>