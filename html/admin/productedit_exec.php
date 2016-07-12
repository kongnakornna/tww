<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_status = $_REQUEST["mstatus"];
$param_partnerid = (!empty($_REQUEST["partnerid"])) ? $_REQUEST["partnerid"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_showtype = (!empty($_REQUEST["showtype"])) ? $_REQUEST["showtype"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_categorie = (!empty($_REQUEST["categorie"])) ? $_REQUEST["categorie"] : "";
$param_detail = (!empty($_REQUEST["detail"])) ? $_REQUEST["detail"] : "";
$param_whatnew = (!empty($_REQUEST["whatnew"])) ? $_REQUEST["whatnew"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_vers = (!empty($_REQUEST["vers"])) ? $_REQUEST["vers"] : "";
$param_clipurl = (!empty($_REQUEST["clipurl"])) ? $_REQUEST["clipurl"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";

if ($param_clipurl=='') {
	$urlcode = "";
}else{
    list ($tmpurl,$urlcode) = explode ("?v=",$param_clipurl);
}

$param_type = "F";
$param_price = "0";

if ($_FILES['image1']['name']!='') {
    $GenCode = "apk_".$String->GenKey(6);
	$uploadpath = $apk_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','apk','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_product set p_partnerid='".addslashes($param_partnerid)."',p_showtype='".$param_showtype."',p_date=now(),p_title='".addslashes($param_title)."',p_categorie='".addslashes($param_categorie)."',p_detail='".addslashes($param_detail)."',p_whatnew='".addslashes($param_whatnew)."',p_version='".addslashes($param_vers)."',p_price='".addslashes($param_price)."',p_type='".addslashes($param_type)."',p_status='".$param_status."',p_clipurl='".trim($urlcode)."',p_url='".trim($param_url)."' where p_id='".$param_id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

		$SqlUpdate = "update tbl_product set p_apk='".$newfilename."' where p_id='".$param_id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

		$DatabaseClass->DBClose();
		$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","product_view.php?catid=" . $param_categorie);
	}else{
		$DatabaseClass->DBClose();
		$Web->AlertWinGo("พบข้อผิดพลาดในการ upload ไฟล์ กรุณาตรวจสอบ ขนาดไฟล์ไม่เกิน 10240 kb และ นามสกุล .apk เท่านั้น","product_view.php?catid=" . $param_categorie);
	}
}else{
	$SqlUpdate = "update tbl_product set p_partnerid='".addslashes($param_partnerid)."',p_showtype='".$param_showtype."',p_date=now(),p_title='".addslashes($param_title)."',p_categorie='".addslashes($param_categorie)."',p_detail='".addslashes($param_detail)."',p_whatnew='".addslashes($param_whatnew)."',p_version='".addslashes($param_vers)."',p_price='".addslashes($param_price)."',p_type='".addslashes($param_type)."',p_status='".$param_status."',p_clipurl='".trim($urlcode)."',p_url='".trim($param_url)."' where p_id='".$param_id."'";
	$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

	$DatabaseClass->DBClose();
	$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","product_view.php?catid=" . $param_categorie);
}
die();
?>