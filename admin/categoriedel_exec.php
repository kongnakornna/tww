<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";

$SqlCheck = "select * from tbl_categorie where c_id='".$param_id."' limit 0,1";
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
if (is_file($FileNamePath)) {
   unlink ($FileNamePath);
}
if (is_file($FileNamePathApp)) {
   unlink ($FileNamePathApp);
}


$SqlCheck = "delete from tbl_categorie where c_id='".trim($param_id)."'";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","categorie_view.php?keyword=".$param_keyword."&page=" . $param_page);
die();
?>