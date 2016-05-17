<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";

$SqlUpdate = "insert into tbl_permission (p_code,p_title) values ('".$param_code."','".$param_title."')";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","permission_view.php?page=1");
die();
?>