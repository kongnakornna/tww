<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";

$SqlAdd = "insert into tbl_categorie (c_title,c_url) values ('".$String->sqlEscape($param_title)."','".$String->sqlEscape($param_url)."')";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

if ($_FILES['image1']['name']!='') {
    $GenCode = "categorie_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_categorie set c_banner='".$newfilename."' where c_id=last_insert_id()";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}

if ($_FILES['image2']['name']!='') {
    $GenCode = "categorie_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image2",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_categorie set c_bannerapp='".$newfilename."' where c_id=last_insert_id()";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}
$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","categorie_view.php");
die();
?>