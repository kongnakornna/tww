<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_status = $_REQUEST["status"];

if ($param_pname==''){
   $SqlPass = "";
}else{
   $SqlPass = ",u_password=MD5('".$param_pname."')";
}

$PermissionList = "";
for ($i=0;$i<count($_REQUEST['permission']);$i++) {
   if ($i==0) {
	   $PermissionList = $_REQUEST['permission'][$i];
   }else{
	   $PermissionList .= "|" . $_REQUEST['permission'][$i];
   }
}

$SqlUpdate = "update tbl_username set u_permission='".$PermissionList."',u_fullname='".$param_fname."',u_email ='".$param_email."',u_status='".$param_status."' $SqlPass where u_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$DatabaseClass->DBClose();
$Web->AlertWinGo("แก้ไขข้อมูลเรียบร้อย","userpayment_view.php?page=1");
die();
?>