<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_catid = (!empty($_REQUEST["catid"])) ? $_REQUEST["catid"] : "";

$SqlCheck = "select * from tbl_product where p_id='".trim($param_id)."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	 for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_apk = $RowCheck['p_apk'];
		 $db_gallery = stripslashes($RowCheck['p_gallery']);
	 }
	 if ($db_gallery!='') {
	   $PhotoArray = explode ("|",$db_gallery);
	 }
}
unset($RowCheck);

for ($t=0;$t<count($PhotoArray);$t++) {
	$FileNamePath = $photo_folder . $Ext . "gallery" . $Ext . $PhotoArray[$t];
	if (is_file($FileNamePath)) {
	   unlink ($FileNamePath);
	}
}

$FileNameApk = $apk_folder . $Ext . $db_apk;
if (is_file($FileNameApk)) {
   unlink ($FileNameApk);
}

$SqlDelete = "delete from tbl_product where p_id='".trim($param_id)."'";
$ResultDelete = $DatabaseClass->DataExecute($SqlDelete);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบข้อมูลเรียบร้อย.","product_view.php?catid=" . $param_catid);
die();
?>