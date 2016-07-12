<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_msg = (!empty($_REQUEST["msg"])) ? $_REQUEST["msg"] : "";

$SqlUpdate = "update tbl_config set c_data='".addslashes($param_msg)."' where c_code='".$param_code."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","config_form.php?code=" . $param_code);
die();
?>