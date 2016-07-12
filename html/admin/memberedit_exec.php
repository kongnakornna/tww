<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/imei.php';
require './controller/product.php';
header('Content-Type: text/html; charset=tis-620');
$imei = new imei();
$product = new product();
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_mobileno = (!empty($_REQUEST["mobileno"])) ? $_REQUEST["mobileno"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_brand = (!empty($_REQUEST["brandname"])) ? $_REQUEST["brandname"] : "";
$param_cardid = (!empty($_REQUEST["cardid"])) ? $_REQUEST["cardid"] : "";
$param_bdate = (!empty($_REQUEST["bdate"])) ? $_REQUEST["bdate"] : "";
$param_bankid = (!empty($_REQUEST["bankid"])) ? $_REQUEST["bankid"] : "";
$param_bankcode = (!empty($_REQUEST["bankcode"])) ? $_REQUEST["bankcode"] : "";
$param_address = (!empty($_REQUEST["address"])) ? $_REQUEST["address"] : "";
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";

$bdate = $DT->ConvertDate($param_bdate);

if ($param_pname==''){
   $SqlPass = "";
}else{
   $SqlPass = ",m_password=MD5('".$param_pname."')";
}

list ($brand,$model) = explode ("@",$param_brand);
$param_type = $product->getphonemodeltype($model);
$SqlUpdate = "update tbl_member set m_bankid='".$param_bankid."',m_bankcode='".$param_bankcode."',m_fullname='".$String->sqlEscape($param_fname)."',m_cardid='".$String->sqlEscape($param_cardid)."',m_address='".$String->sqlEscape($param_address)."',m_bdate='".$String->sqlEscape($bdate)."',m_province='".$String->sqlEscape($param_province)."',m_mobile='".$String->sqlEscape($param_mobileno)."',m_email='".$String->sqlEscape($param_email)."',m_updateby='".$_SESSION['TWZUsername']."',m_updatedate=now(),m_producttype='".$String->sqlEscape($param_type)."',m_productbrand='".$String->sqlEscape($brand)."',m_productmodel='".$String->sqlEscape($model)."',m_status='".$param_status."' $SqlPass where m_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","member_view.php");
die();
?>