<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_maincat = (!empty($_REQUEST["maincat"])) ? $_REQUEST["maincat"] : "";

$SqlAdd = "update tbl_subcategorie set s_title='".$param_title."',s_catid='".$param_maincat."' where s_id='".$param_id."'";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","subcategorie_view.php?catid=" . $param_maincat);
die();
?>