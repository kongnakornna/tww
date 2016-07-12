<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlUpdate = "update tbl_phone_brand set p_title='".$param_title."' where p_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("แก้ไขข้อมูลเรียบร้อย","phonebrand_view.php?page=1");
die();
?>