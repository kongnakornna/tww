<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');

$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_oldfile = (!empty($_REQUEST["oldfile"])) ? $_REQUEST["oldfile"] : "";
$param_oldfileapp = (!empty($_REQUEST["oldfileapp"])) ? $_REQUEST["oldfileapp"] : "";
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

$FileNamePath = $photo_folder . $Ext . $param_oldfile;
$FileNamePathApp = $photo_folder . $Ext . $param_oldfileapp;
$SqlUpdate = "update tbl_banner set b_title='".$String->sqlEscape($param_title)."',b_url='".$String->sqlEscape($param_url)."',b_startdate='".$startdate."',b_enddate='".$enddate."',b_status='".$param_status."' where b_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

if ($_FILES['image1']['name']!='') {
	if (is_file($FileNamePath)) {
	   unlink ($FileNamePath);
	}

    $GenCode = "bnn_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_banner set b_file='".$newfilename."' where b_id='".$param_id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}

if ($_FILES['image2']['name']!='') {
	if (is_file($FileNamePathApp)) {
	   unlink ($FileNamePathApp);
	}

    $GenCode = "bnn_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image2",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_banner set b_fileapp='".$newfilename."' where b_id='".$param_id."'";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","banner_view.php");
die();
?>