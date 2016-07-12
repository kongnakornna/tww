<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$OldPassword = (!empty($_REQUEST["cname"])) ? $_REQUEST["cname"] : "";
$NewPassword = (!empty($_REQUEST["npass1"])) ? $_REQUEST["npass1"] : "";

$SqlCheck = "select * from tbl_username where u_username='".trim($_SESSION['TWZUsername'])."' and u_password=MD5('".$OldPassword."') limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck > 0) {
	$SqlUpdate = "update tbl_username set u_password=MD5('".$NewPassword."') where u_username='".trim($_SESSION['TWZUsername'])."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("รหัสผ่านได้ถูกเปลี่ยนเรียบร้อย.","changepass_form.php");
} else {
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("รหัสผ่านเดิมไม่ตรงกับที่มีในระบบ กรุณาลองใหม่อีกครั้ง.","changepass_form.php");
}
die();
?>