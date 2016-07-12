<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/imei.php';
require './controller/payment.php';
header('Content-Type: text/html; charset=tis620');
$imei = new imei();
$payment = new payment();
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";

$SqlCheck = "select * from tbl_member where m_email='".trim($param_uname)."' limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("อีเมล์นี้มีในระบบแล้ว กรุณาใช้อีเมล์อื่น","front_onlinememberadd_form.php");
}else{
	if ($payment->getcardno($param_paymentcardno) > 0) {
		$DatabaseClass->DBClose();
		$Web->AlertWinGo("รหัสบัตรชำระเงินถูกนำไปใช้แล้ว","front_onlinememberadd_form.php");
	}else{
		if ($param_pname==''){
		    $SqlPass = "";
		}else{
			$SqlAdd = "update tbl_member set m_password=MD5('".$param_pname."') where m_id='".$param_id."'";
			$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
		}
		$DatabaseClass->DBClose();
		$Web->AlertWinGo("แก้ไขข้อมูลเรียบร้อย","front_menu.php");
	}		
}
die();
?>