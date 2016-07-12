<?php
include "leone.php";
if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_bankid = (!empty($_REQUEST["bankid"])) ? $_REQUEST["bankid"] : "";
$param_bankcode = (!empty($_REQUEST["bankcode"])) ? $_REQUEST["bankcode"] : "";
$param_phone = (!empty($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";

$SqlUpdate = "update tbl_member set m_bankcode='".$param_bankcode."',m_bankid='".$param_bankid."',m_mobile='".$param_phone."',m_fullname='".addslashes($param_fname)."',m_province='".addslashes($param_province)."',m_updatedate=now() where m_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","member_profile_form.php");
die();
?>