<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_reason = (!empty($_REQUEST["reason"])) ? $_REQUEST["reason"] : "";
$param_catid = (!empty($_REQUEST["catid"])) ? $_REQUEST["catid"] : "";

$SqlUpdate = "update tbl_product set p_status='8',p_admin_comment='".addslashes($param_reason)."' where p_id='".trim($param_id)."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย.","productnew_view.php?catid=" . $param_catid);
die();
?>