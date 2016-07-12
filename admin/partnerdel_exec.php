<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlDelete = "delete from tbl_partner where p_id='".trim($param_id)."'";
$ResultDelete = $DatabaseClass->DataExecute($SqlDelete);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","partner_view.php");
die();
?>