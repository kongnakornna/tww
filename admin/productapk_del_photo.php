<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlCheck = "select * from tbl_product where p_id='".trim($param_id)."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	 for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_apk = $RowCheck['p_apk'];
	 }
}
unset($RowCheck);

$FileNameApk = $apk_folder . $Ext . $db_apk;
if (is_file($FileNameApk)) {
   unlink ($FileNameApk);
}

$SqlDelete = "update tbl_product set p_apk='' where p_id='".trim($param_id)."'";
$ResultDelete = $DatabaseClass->DataExecute($SqlDelete);

$DatabaseClass->DBClose();
$Web->AlertWinGo("ลบไฟล์ apk เรียบร้อย.","productedit_form.php?id=" . $param_id);
die();
?>