<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');

$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_imeino = (!empty($_REQUEST["imeicode"])) ? $_REQUEST["imeicode"] : "";
$param_type= (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_docno = (!empty($_REQUEST["docno"])) ? $_REQUEST["docno"] : "";
$param_docdate = (!empty($_REQUEST["docdate"])) ? $_REQUEST["docdate"] : "";
$param_barcode = (!empty($_REQUEST["barcode"])) ? $_REQUEST["barcode"] : "";
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";

$SqlUpdate = "update tbl_model set m_type='".$String->sqlEscape(strtoupper($param_type))."',m_emei='".$String->sqlEscape($param_imeino)."',m_docno='".$String->sqlEscape($param_docno)."',m_docdate='".$String->sqlEscape($param_docdate)."',m_barcode='".$String->sqlEscape($param_barcode)."' where m_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","imeidata_view.php?page=" . $param_page . '&keyword=' . $param_keyword);
die();
?>