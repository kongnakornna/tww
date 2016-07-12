<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlCheck = "select * from tbl_banner where b_id='".$param_id."' limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($w=0;$w<$RowsCheck;$w++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$w);
		 $db_id = $RowCheck['b_id'];
		 $db_photo = $RowCheck['b_file'];
		 $db_photoapp = $RowCheck['b_fileapp'];
	}
}
unset($RowCheck);
$FileNamePath = $photo_folder . $Ext . $db_photo;
$FileNamePathApp = $photo_folder . $Ext . $db_photoapp;
if (is_file($FileNamePath)) {
   unlink ($FileNamePath);
}
if (is_file($FileNamePathApp)) {
   unlink ($FileNamePathApp);
}

$SqlUpdate = "delete from tbl_banner where b_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","banner_view.php");
die();
?>