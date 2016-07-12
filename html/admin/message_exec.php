<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_msg = (!empty($_REQUEST["msg"])) ? $_REQUEST["msg"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";

$SqlUpdate = "update tbl_message set m_title='".addslashes($param_title)."',m_message='".addslashes($param_msg)."' where m_code='".$param_code."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","message_form.php?code=" . $param_code);
die();
?>