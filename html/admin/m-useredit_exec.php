<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_phone = (!empty($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";
$param_shoptitle = (!empty($_REQUEST["shoptitle"])) ? $_REQUEST["shoptitle"] : "";
$param_shopaddress = (!empty($_REQUEST["shopaddress"])) ? $_REQUEST["shopaddress"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_postcode = (!empty($_REQUEST["postcode"])) ? $_REQUEST["postcode"] : "";
$param_bankname = (!empty($_REQUEST["bankname"])) ? $_REQUEST["bankname"] : "";
$param_bankcode = (!empty($_REQUEST["bankcode"])) ? $_REQUEST["bankcode"] : "";

if ($param_pname==''){
   $SqlPass = "";
}else{
   $SqlPass = ",u_password=MD5('".$param_pname."')";
}

$SqlUpdate = "update tbl_username set u_bankname='".$param_bankname."',u_bankcode='".$param_bankcode."',u_shoptitle='".$param_shoptitle."',u_shopaddress='".$param_shopaddress."',u_shopprovince='".$param_province."',u_shoppostcode='".$param_postcode."',u_fullname='".$param_fname."',u_phone='".$param_phone."',u_email ='".$param_email."',u_status='".$param_status."' $SqlPass where u_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("แก้ไขข้อมูลเรียบร้อย","m-user_view.php?page=1");
die();
?>