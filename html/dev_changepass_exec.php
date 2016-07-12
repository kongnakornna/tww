<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
header('Content-Type: text/html; charset=tis-620');
$OldPassword = trim($_REQUEST['cname']);
$NewPassword = trim($_REQUEST['npass1']);

$SqlCheck = "select * from tbl_partner where p_email='".trim($_SESSION['DVEmail'])."' and p_password=MD5('".$OldPassword."') order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck > 0) {
	$SqlUpdate = "update tbl_partner set p_password=MD5('".$NewPassword."') where p_email='".trim($_SESSION['DVEmail'])."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("รหัสผ่านได้ถูกเปลี่ยนเรียบร้อย.","dev_mainpage.php");
} else {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("รหัสผ่านเดิมไม่ตรงกับที่มีในระบบ กรุณาลองใหม่อีกครั้ง.","dev_changepass_form.php");
}
?>