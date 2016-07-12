<?php
include '../leone.php';
include '../admin/controller/province.php';
header('Content-Type: application/json; charset=utf-8');
$province = new province();

$provincedata = $province->getdata();
if (sizeof($provincedata) > 0) {		
	for ($p=0;$p<count($provincedata);$p++) {
		$cid = $provincedata[$p]['p_id'];
		$ctitle = stripslashes($provincedata[$p]['p_title_th']);
	    $dataarray[$p] = array ("province_id"=>$cid,"province_name"=>$String->tis2utf8($ctitle));
	}
}
$filearray = array("provincelist"=>$dataarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>