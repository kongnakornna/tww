<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";

$SqlAdd = "insert into tbl_phone_brand (p_title) values ('".$String->sqlEscape($param_title)."')";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","phonebrand_view.php");
die();
?>