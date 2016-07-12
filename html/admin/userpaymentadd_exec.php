<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_uname = (!empty($_REQUEST["uname"])) ? $_REQUEST["uname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

$PermissionList = "";
$SqlCheck = "select * from tbl_username where u_username='".trim($param_uname)."' limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("username นี้มีในระบบแล้ว กรุณาใช้ชื่ออื่น","user_view.php?keyword=" . $param_uname);
	die();
}else{
	if ($param_mtype=='1') {
		for ($i=0;$i<count($_REQUEST['permission']);$i++) {
		   if ($i==0) {
			   $PermissionList = $_REQUEST['permission'][$i];
		   }else{
			   $PermissionList .= "|" . $_REQUEST['permission'][$i];
		   }
		}
	}

	$SqlAdd = "insert into tbl_username (u_group,u_fullname,u_username,u_password,u_email,u_frontside,u_permission,u_status) values ('U','".addslashes($param_fname)."','".addslashes($param_uname)."',MD5('".$param_pname."'),'".addslashes($param_email)."','Y','".addslashes($PermissionList)."','1')";
    $ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

	$DatabaseClass->DBClose();
    $Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","userpayment_view.php");
	die();
}
?>