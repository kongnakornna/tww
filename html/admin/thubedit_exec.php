<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_memberid = (!empty($_REQUEST["memberid"])) ? $_REQUEST["memberid"] : "";

$SqlAdd = "update tbl_member_payment set p_membercode='".$param_memberid."' where p_id='".$param_id."'";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","thub_view.php?page=1");
die();
?>