<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlCheck = "delete from tbl_username where u_id='".trim($param_id)."'";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","s-user_view.php");
die();
?>