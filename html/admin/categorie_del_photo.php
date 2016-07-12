<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";

$SqlCheck = "select * from tbl_categorie where c_id='".$param_id."' order by c_id limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($w=0;$w<$RowsCheck;$w++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$w);
		 $db_id = $RowCheck['c_id'];
		 $db_photo = $RowCheck['c_banner'];
		 $db_photoapp = $RowCheck['c_bannerapp'];
	}
}
unset($RowCheck);
$FileNamePath = $photo_folder . $Ext . $db_photo;
$FileNamePathApp = $photo_folder . $Ext . $db_photoapp;
if ($param_type=='1') {
	if (is_file($FileNamePath)) {
	   unlink ($FileNamePath);
	}
	$SqlUpdate = "update tbl_categorie set c_banner='' where c_id='".$param_id."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
}

if ($param_type=='2') {
	if (is_file($FileNamePathApp)) {
	   unlink ($FileNamePathApp);
	}
	$SqlUpdate = "update tbl_categorie set c_bannerapp='' where c_id='".$param_id."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบรูปภาพเรียบร้อย.","categorieedit_form.php?id=" . $param_id);
die();
?>