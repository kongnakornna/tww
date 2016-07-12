<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_maincat = (!empty($_REQUEST["maincat"])) ? $_REQUEST["maincat"] : "";

$SqlAdd = "insert into tbl_subcategorie (s_title,s_catid) values ('".$String->sqlEscape($param_title)."','".$String->sqlEscape($param_maincat)."')";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","subcategorie_view.php?catid=" . $param_maincat);
die();
?>