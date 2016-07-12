<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_categorie = (!empty($_REQUEST["categorie"])) ? $_REQUEST["categorie"] : "";
$param_detail = (!empty($_REQUEST["detail"])) ? $_REQUEST["detail"] : "";
$param_whatnew = (!empty($_REQUEST["whatnew"])) ? $_REQUEST["whatnew"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_vers = (!empty($_REQUEST["vers"])) ? $_REQUEST["vers"] : "";
$param_oldapk = (!empty($_REQUEST["oldapk"])) ? $_REQUEST["oldapk"] : "";
$param_clipurl = (!empty($_REQUEST["clipurl"])) ? $_REQUEST["clipurl"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";

if ($param_clipurl=='') {
	$urlcode = "";
}else{
    list ($tmpurl,$urlcode) = explode ("?v=",$param_clipurl);
}

$SqlAdd = "insert into tbl_product (p_updateid,p_apk,p_partnerid,p_code,p_date,p_title,p_categorie,p_detail,p_whatnew,p_version,p_price,p_clipurl,p_url,p_type,p_status) values ('".$param_id."','".$param_oldapk."','".$_SESSION['DVID']."','".addslashes($param_code)."',now(),'".addslashes($param_title)."','".addslashes($param_categorie)."','".addslashes($param_detail)."','".addslashes($param_whatnew)."','".addslashes($param_vers)."','".addslashes($param_price)."','".$urlcode."','".$param_url."','".addslashes($param_type)."','0')";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
$id = mysql_insert_id();

if ($_FILES['image1']['name']!='') {
    $GenCode = "apk_".$String->GenKey(6);
	$uploadpath = $apk_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','apk','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_product set p_apk='".$newfilename."' where p_id='".$id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}
$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย ระบบจะนำท่านไปขั้นตอนต่อไป.","dev_appedit_step2.php?id=" . $id);
die();
?>