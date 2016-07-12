<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

$SqlAdd = "insert into tbl_banner (b_title,b_url,b_startdate,b_enddate,b_status,b_addby,b_adddate) values ('".$String->sqlEscape($param_title)."','".$String->sqlEscape($param_url)."','".$startdate."','".$enddate."','1','".$_SESSION['TWZUsername']."',now())";
$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);

if ($_FILES['image1']['name']!='') {
    $GenCode = "bnn_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_banner set b_file='".$newfilename."' where b_id=last_insert_id()";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}

if ($_FILES['image2']['name']!='') {
    $GenCode = "bnn_".$String->GenKey(6);
	$uploadpath = $photo_folder . $Ext;
	list ($newfilename,$uploadresult) = $GC->uploadPhoto("image2",$GenCode,$uploadpath,'','jpg|jpeg|gif|png','10240');
    if ($uploadresult!='ERROR') {
		$SqlUpdate = "update tbl_banner set b_fileapp='".$newfilename."' where b_id=last_insert_id()";
		$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
	}
}
$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","banner_view.php");
die();
?>