<?php
include '../leone.php';
include '../admin/controller/pos.php';
header('Content-Type: application/json; charset=utf-8');
$pos = new pos();

$posdata = $pos->getdata();
if (sizeof($posdata) > 0) {		
	for ($p=0;$p<count($posdata);$p++) {
		$cid = $posdata[$p]['p_counterid'];
		$ctitle = stripslashes($posdata[$p]['p_countername']);
 	        $dataarray[$p] = array ("pos_id"=>$cid,"pos_name"=>$String->tis2utf8($ctitle));
	}
}
$filearray = array("poslist"=>$dataarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
