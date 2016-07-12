<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_brand = (!empty($_REQUEST["brand"])) ? $_REQUEST["brand"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$SqlAdd = "insert into tbl_phone_model (m_title,m_phone_id) values ('".$String->sqlEscape($param_title)."','".$String->sqlEscape($param_brand)."')";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","phonemodel_view.php?brand=" . $param_brand);
die();
?>