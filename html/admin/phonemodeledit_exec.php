<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_brand = (!empty($_REQUEST["brand"])) ? $_REQUEST["brand"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlUpdate = "update tbl_phone_model set m_phone_id='".$param_brand."',m_title='".$param_title."' where m_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("แก้ไขข้อมูลเรียบร้อย","phonemodel_view.php?brand=".$param_brand."&page=1");
die();
?>