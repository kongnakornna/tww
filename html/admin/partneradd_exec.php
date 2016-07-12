<?php
require '../leone.php';
require './controller/partner.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_addr1 = (!empty($_REQUEST["addr1"])) ? $_REQUEST["addr1"] : "";
$param_addr2 = (!empty($_REQUEST["addr2"])) ? $_REQUEST["addr2"] : "";
$param_postcode = (!empty($_REQUEST["postcode"])) ? $_REQUEST["postcode"] : "";
$param_share_app = (!empty($_REQUEST["share_app"])) ? $_REQUEST["share_app"] : "";
$param_share_inapp = $_REQUEST["share_inapp"];
$param_mobile = (!empty($_REQUEST["mobile"])) ? $_REQUEST["mobile"] : "";
$partner = new partner();
$havepartner = $partner->havepartnerbyemail($param_email);

$param_share_inapp = "0";

if ($havepartner) {
    $Web->AlertWinGo("อีเมล์ซ้ำกับที่มีในระบบกรุณาใช้ อีเมล์ อื่นค่ะ","partner_view.php");
}else{
	$pncode = $partner->runid();
	$SqlAdd = "insert into tbl_partner (p_title,p_fullname,p_email,p_password,p_address1,p_address2,p_province,p_postcode,p_mobile,p_code,p_createdate,p_share_app,p_share_inapp,p_status) values ('".addslashes($param_title)."','".addslashes($param_fname)."','".addslashes($param_email)."',MD5('".$param_pname."'),'".addslashes($param_addr1)."','".addslashes($param_addr2)."','".addslashes($param_province)."','".addslashes($param_postcode)."','".addslashes($param_mobile)."','".addslashes(strtoupper($pncode))."',now(),'".$param_share_app."','".$param_share_inapp."','1')";
	$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

	$DatabaseClass->DBClose();
	$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","partner_view.php");
}
die();
?>