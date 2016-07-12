<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlCheck = "delete from tbl_subcategorie where s_id='".trim($param_id)."'";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","subcategorie_view.php");
die();
?>