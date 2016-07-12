<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_catid = (!empty($_REQUEST["catid"])) ? $_REQUEST["catid"] : "";
$param_status = $_REQUEST["status"];

$SqlCheck = "select * from tbl_product where p_id='".trim($param_id)."' and p_updateid not in ('') order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_updateid = stripslashes($RowCheck['p_updateid']);
		 $db_code = stripslashes($RowCheck['p_code']);
		 $db_title = stripslashes($RowCheck['p_title']);
		 $db_partner = stripslashes($RowCheck['p_partnerid']);
		 $db_type = stripslashes($RowCheck['p_type']);
		 $db_cate = stripslashes($RowCheck['p_categorie']);
		 $db_detail = stripslashes($RowCheck['p_detail']);
		 $db_whatnew = stripslashes($RowCheck['p_whatnew']);
		 $db_price = stripslashes($RowCheck['p_price']);
		 $db_clipurl = stripslashes($RowCheck['p_clipurl']);
		 $db_url = stripslashes($RowCheck['p_url']);
		 $db_gallery = stripslashes($RowCheck['p_gallery']);
		 $db_status = stripslashes($RowCheck['p_status']);
		 $db_version = stripslashes($RowCheck['p_version']);
	}

	$SqlUpdate = "update tbl_product set p_partnerid='".addslashes($db_partner)."',p_code='".addslashes($db_code)."',p_date=now(),p_title='".addslashes($db_title)."',p_categorie='".addslashes($db_cate)."',p_detail='".addslashes($db_detail)."',p_whatnew='".addslashes($db_whatnew)."',p_version='".addslashes($db_version)."',p_price='".addslashes($db_price)."',p_type='".addslashes($db_type)."',p_gallery='".$db_gallery."',p_status='".$param_status."',p_clipurl='".trim($db_clipurl)."',p_url='".trim($db_url)."' where p_id='".$db_updateid."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

	$SqlDelete = "delete from tbl_product where p_id='".trim($param_id)."'";
    $ResultDelete = $DatabaseClass->DataExecute($SqlDelete);
}else{
	$SqlUpdate = "update tbl_product set p_status='".$param_status."' where p_id='".trim($param_id)."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย.","productnew_view.php?catid=" . $param_catid);
die();
?>