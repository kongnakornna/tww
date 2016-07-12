<?php
include "leone.php";
header('Content-Type: text/html; charset=tis-620');
$param_i = trim($_REQUEST['i']);

$SqlCheck = "select * from tbl_member where m_key='".trim($param_i)."' order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck > 0) {
    $SqlUpdate = "update tbl_member set m_status='1' where m_key='".trim($param_i)."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
}
$DatabaseClass->DBClose();
$Web->AlertWinGo("ระบบทำการเปิดใช้งานเรียบร้อยค่ะ.","https://www.easycard.club");
die();
?>
