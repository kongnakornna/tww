<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_partnerid = (!empty($_REQUEST["partnerid"])) ? $_REQUEST["partnerid"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_showtype = (!empty($_REQUEST["showtype"])) ? $_REQUEST["showtype"] : "";
$param_categorie = (!empty($_REQUEST["categorie"])) ? $_REQUEST["categorie"] : "";
$param_detail = (!empty($_REQUEST["detail"])) ? $_REQUEST["detail"] : "";
$param_whatnew = (!empty($_REQUEST["whatnew"])) ? $_REQUEST["whatnew"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_vers = (!empty($_REQUEST["vers"])) ? $_REQUEST["vers"] : "";
$param_status = $_REQUEST["status"];
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
		$SqlAdd = "insert into tbl_product (p_partnerid,p_showtype,p_date,p_title,p_categorie,p_detail,p_whatnew,p_version,p_price,p_clipurl,p_url,p_type,p_status) values ('".addslashes($param_partnerid)."','".$param_showtype."',now(),'".addslashes($param_title)."','".addslashes($param_categorie)."','".addslashes($param_detail)."','".addslashes($param_whatnew)."','".addslashes($param_vers)."','".addslashes($param_price)."','".$urlcode."','".$param_url."','".addslashes($param_type)."','".$param_status."')";
		$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
		$id = mysql_insert_id();
		$SqlUpdate = "update tbl_product set p_apk='".$newfilename."' where p_id='".$id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

		$DatabaseClass->DBClose();
		$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","product_view.php");
	}else{
		$DatabaseClass->DBClose();
		$Web->AlertWinGo("พบข้อผิดพลาดในการ upload ไฟล์ กรุณาตรวจสอบ ขนาดไฟล์ไม่เกิน 10240 kb และ นามสกุล .apk เท่านั้น","product_view.php");
	}
}else{
	$SqlAdd = "insert into tbl_product (p_partnerid,p_showtype,p_date,p_title,p_categorie,p_detail,p_whatnew,p_version,p_price,p_clipurl,p_url,p_type,p_status) values ('".addslashes($param_partnerid)."','".$param_showtype."',now(),'".addslashes($param_title)."','".addslashes($param_categorie)."','".addslashes($param_detail)."','".addslashes($param_whatnew)."','".addslashes($param_vers)."','".addslashes($param_price)."','".$urlcode."','".$param_url."','".addslashes($param_type)."','".$param_status."')";
	$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
	$DatabaseClass->DBClose();
	$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","product_view.php");
}
die();
?>