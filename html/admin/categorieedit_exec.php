<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_oldfile = (!empty($_REQUEST["oldfile"])) ? $_REQUEST["oldfile"] : "";
$param_oldfileapp = (!empty($_REQUEST["oldfileapp"])) ? $_REQUEST["oldfileapp"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";

$SqlUpdate = "update tbl_categorie set c_title='".$String->sqlEscape($param_title)."' where c_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

$FileNamePath = $photo_folder . $Ext . $param_oldfile;
$FileNamePathApp = $photo_folder . $Ext . $param_oldfileapp;

if ($_FILES['image1']['name']!='') {
	if (is_file($FileNamePath)) {
	   unlink ($FileNamePath);
	}

    $GenCode = "categorie_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_categorie set c_banner='".$newfilename."' where c_id='".$param_id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}

if ($_FILES['image2']['name']!='') {
	if (is_file($FileNamePathApp)) {
	   unlink ($FileNamePathApp);
	}

    $GenCode = "categorie_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image2",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_categorie set c_bannerapp='".$newfilename."' where c_id='".$param_id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","categorie_view.php");
die();
?>