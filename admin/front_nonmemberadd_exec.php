<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/imei.php';
require './controller/member.php';
require './controller/payment.php';
header('Content-Type: text/html; charset=tis620');
$imei = new imei();
$member = new member();
$payment = new payment();
$param_imeino = (!empty($_REQUEST["imeino"])) ? $_REQUEST["imeino"] : "";
$param_mobileno = (!empty($_REQUEST["mobileno"])) ? $_REQUEST["mobileno"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_address1 = (!empty($_REQUEST["address1"])) ? $_REQUEST["address1"] : "";
$param_address2 = (!empty($_REQUEST["address2"])) ? $_REQUEST["address2"] : "";
$param_postcode = (!empty($_REQUEST["postcode"])) ? $_REQUEST["postcode"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_paymentcardno = (!empty($_REQUEST["paymentcardno"])) ? $_REQUEST["paymentcardno"] : "";
$param_brand = (!empty($_REQUEST["brandname"])) ? $_REQUEST["brandname"] : "";
$param_model = (!empty($_REQUEST["model"])) ? $_REQUEST["model"] : "";
$param_saleid = (!empty($_REQUEST["saleid"])) ? $_REQUEST["saleid"] : "";
$param_dcode = (!empty($_REQUEST["dcode"])) ? $_REQUEST["dcode"] : "";

$param_saleid = strtoupper($param_saleid);
$param_dcode = strtoupper($param_dcode);

$SqlCheck = "select * from tbl_member where m_email='".trim($param_uname)."' limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("อีเมล์นี้มีในระบบแล้ว กรุณาใช้อีเมล์อื่น","front_nonmemberadd_form.php");
}else{
	if ($payment->getcardno($param_paymentcardno) > 0) {
		$DatabaseClass->DBClose();
		$Web->AlertWinGo("รหัสบัตรชำระเงินถูกนำไปใช้แล้ว","front_nonmemberadd_form.php");
	}else{
		$mcode = $member->runid ('OTH');
		$SqlAdd = "insert into tbl_member (m_type,m_code,m_registerdate,m_fullname,m_address1,m_address2,m_province,m_postcode,m_mobile,m_imei,m_email,m_status,m_saleid,m_addby,m_adddate,m_producttype,m_productbrand,m_productmodel) values ('OTH','".$mcode."',now(),'".$String->sqlEscape($param_fname)."','".$String->sqlEscape($param_address1)."','".$String->sqlEscape($param_address2)."','".$String->sqlEscape($param_province)."','".$String->sqlEscape($param_postcode)."','".$String->sqlEscape($param_mobileno)."','".$String->sqlEscape($param_imeino)."','".$String->sqlEscape($param_email)."','1','".$String->sqlEscape($param_saleid)."','".$_SESSION['TWZUsername']."',now(),'".$String->sqlEscape($param_type)."','".$String->sqlEscape($param_brand)."','".$String->sqlEscape($param_model)."')";
		$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

		$SqlAddPayment = "update tbl_member_payment set p_membercode='".$mcode."' where p_cardpayment='".$param_paymentcardno."'";
		$ResultAddPayment = $DatabaseClass->DataExecute($SqlAddPayment);
		$imei->update($String->sqlEscape($param_imeino));
		$DatabaseClass->DBClose();
		$Web->AlertWinGo("ลงทะเบียนเครื่องเรียบร้อย","front_menu.php");
	}		
}
die();
?>