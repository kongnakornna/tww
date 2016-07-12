<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";

$SqlCheck = "select * from tbl_banner where b_id='".$param_id."' order by b_id limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($w=0;$w<$RowsCheck;$w++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$w);
		 $db_id = $RowCheck['b_id'];
		 $db_photo = $RowCheck['b_file'];
		 $db_photo2 = $RowCheck['b_fileapp'];
	}
}
unset($RowCheck);

if ($param_type=='1') {
	$FileNamePath = $photo_folder . $Ext . $db_photo;

	if (is_file($FileNamePath)) {
	   unlink ($FileNamePath);
	}
	$SqlUpdate = "update tbl_banner set b_file='' where b_id='".$param_id."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
}

if ($param_type=='2') {
	$FileNamePath2 = $photo_folder . $Ext . $db_photo2;

	if (is_file($FileNamePath2)) {
	   unlink ($FileNamePath2);
	}

	$SqlUpdate = "update tbl_banner set b_fileapp='' where b_id='".$param_id."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบรูปภาพเรียบร้อย.","banneredit_form.php?id=" . $param_id);
die();
?>