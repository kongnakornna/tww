<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_uname = (!empty($_REQUEST["uname"])) ? $_REQUEST["uname"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_phone = (!empty($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$param_shoptitle = (!empty($_REQUEST["shoptitle"])) ? $_REQUEST["shoptitle"] : "";
$param_shopaddress = (!empty($_REQUEST["shopaddress"])) ? $_REQUEST["shopaddress"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_postcode = (!empty($_REQUEST["postcode"])) ? $_REQUEST["postcode"] : "";
$param_bankname = (!empty($_REQUEST["bankname"])) ? $_REQUEST["bankname"] : "";
$param_bankcode = (!empty($_REQUEST["bankcode"])) ? $_REQUEST["bankcode"] : "";

$PermissionList = "";
$SqlCheck = "select * from tbl_username where u_username='".trim($param_uname)."' limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("username นี้มีในระบบแล้ว กรุณาใช้ชื่ออื่น","s-user_view.php?keyword=" . $param_uname);
	die();
}else{
	$SqlAdd = "insert into tbl_username (u_group,u_fullname,u_code,u_username,u_password,u_email,u_phone,u_shoptitle,u_shopaddress,u_shopprovince,u_shoppostcode,u_bankname,u_bankcode,u_status) values ('S','".$String->sqlEscape($param_fname)."','".$String->sqlEscape($param_uname)."','".$String->sqlEscape($param_uname)."',MD5('".$param_pname."'),'".$String->sqlEscape($param_email)."','".$String->sqlEscape($param_phone)."','".$String->sqlEscape($param_shoptitle)."','".$String->sqlEscape($param_shopaddress)."','".$String->sqlEscape($param_province)."','".$String->sqlEscape($param_postcode)."','".$String->sqlEscape($param_bankname)."','".$String->sqlEscape($param_bankcode)."','1')";
    $ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

	$DatabaseClass->DBClose();
    $Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","s-user_view.php");
	die();
}
?>