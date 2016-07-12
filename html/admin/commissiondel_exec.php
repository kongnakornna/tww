<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$SqlCheck = "update tbl_commission_config set c_status='9',c_update_by='".$_SESSION['mPayUsername']."',c_update_date=now() where c_id='".$param_id."'";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ยกเลิกข้อมูลเรียบร้อย.","commissionconfig_view.php");
die();
?>