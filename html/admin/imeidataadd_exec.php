<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');

$param_imeino = (!empty($_REQUEST["imeicode"])) ? $_REQUEST["imeicode"] : "";
$param_type= (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_docno = (!empty($_REQUEST["docno"])) ? $_REQUEST["docno"] : "";
$param_docdate = (!empty($_REQUEST["docdate"])) ? $_REQUEST["docdate"] : "";
$param_barcode = (!empty($_REQUEST["barcode"])) ? $_REQUEST["barcode"] : "";

$SqlCheck = "select * from tbl_model where m_emei='".trim($param_imeino)."' order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("หมายเลข imei นี้มีในระบบแล้ว กรุณาใช้หายเลข imei อื่น","imeidataadd_form.php");
}else{
	$SqlAdd = "insert into tbl_model (m_type,m_emei,m_docno,m_docdate,m_barcode,m_used) values ('".$String->sqlEscape(strtoupper($param_type))."','".$String->sqlEscape(strtoupper($param_imeino))."','".$String->sqlEscape($param_docno)."','".$String->sqlEscape($param_docdate)."','".$String->sqlEscape(strtoupper($param_barcode))."','0')";
	$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

	$DatabaseClass->DBClose();
	$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","member_view.php");	
}
die();
?>