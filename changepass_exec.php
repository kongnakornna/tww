<?php
include "leone.php";
if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
header('Content-Type: text/html; charset=tis-620');
$OldPassword = trim($_REQUEST['cname']);
$NewPassword = trim($_REQUEST['npass1']);

$SqlCheck = "select * from tbl_member where m_email='".trim($_SESSION['TWEmail'])."' and m_password=MD5('".$OldPassword."') limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck > 0) {
	$SqlUpdate = "update tbl_member set m_password=MD5('".$NewPassword."') where m_email='".trim($_SESSION['TWEmail'])."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("รหัสผ่านได้ถูกเปลี่ยนเรียบร้อย.","member_mainpage.php");
} else {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("รหัสผ่านเดิมไม่ตรงกับที่มีในระบบ กรุณาลองใหม่อีกครั้ง.","changepass_form.php");
}
?>