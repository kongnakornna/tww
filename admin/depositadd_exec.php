<?php
require '../leone.php';
require './controller/wallet.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_date = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_amount = (!empty($_REQUEST["amount"])) ? $_REQUEST["amount"] : "";
$param_remark1 = (!empty($_REQUEST["Remark1"])) ? $_REQUEST["Remark1"] : "";
$param_remark2 = (!empty($_REQUEST["Remark2"])) ? $_REQUEST["Remark2"] : "";
$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$param_username = $_SESSION['TWZUsername'];
$wallet = new wallet();
$date = date_create_from_format('d/m/Y',$param_date);
$newdate=date_format($date,'Y-m-d');

/*
if ($param_amount == '' || $param_username == '' || $param_date == '' || $param_partner == '') {
    $Web->AlertWinGo("บันทึกข้อมูลไม่ครับ","deposit_view.php");
}else{
*/	
	$myret = $wallet->insertdeposit($newdate,$param_partner,$param_amount,$param_username,$param_remark1,$param_remark2);	
	$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","deposit_view.php");
//}
die();
?>
