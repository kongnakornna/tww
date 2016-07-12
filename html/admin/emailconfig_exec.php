<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";

$SqlUpdate = "update tbl_message set m_message='".addslashes($param_title)."' where m_id='5'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","emailconfig_form.php");
die();
?>http://122.155.16.7:8080/TWZServices/contact?fullname=%E0%B8%9B%E0%B8%A3%E0%B8%B5%E0%B8%94%E0%B8%B2&topic=%E0%B9%84%E0%B8%A1%E0%B9%88%E0%B8%A1%E0%B8%B5%E0%B8%AD%E0%B8%B0%E0%B9%84%E0%B8%A3&detail=%E0%B8%9F%E0%B8%AB%E0%B8%81%E0%B8%94%E0%B8%9F%E0%B8%AB%E0%B8%81%E0%B8%94%E0%B8%9F%E0%B8%AB%E0%B8%81%E0%B8%94%E0%B8%AB%E0%B8%9F%E0%B8%81%E0%B8%94&email=jgodsonline@gmail.com