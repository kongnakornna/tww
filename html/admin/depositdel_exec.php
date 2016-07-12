<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$param_logtime = (!empty($_REQUEST["logtime"])) ? $_REQUEST["logtime"] : "";

$SqlDelete = "delete from tbl_deposit where d_logtime='".$param_logtime."' and d_partner = '".$param_partner."'";
$ResultDelete = $DatabaseClass->DataExecute($SqlDelete);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","deposit_view.php");
die();
?>
