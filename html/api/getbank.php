<?php
include '../leone.php';
include '../admin/controller/bank.php';
header('Content-Type: application/json; charset=utf-8');
$bank = new bank();

$bankdata = $bank->getdata();
if (sizeof($bankdata) > 0) {		
	for ($p=0;$p<count($bankdata);$p++) {
		$cid = $bankdata[$p]['b_id'];
		$ctitle = stripslashes($bankdata[$p]['b_title']);
	    $dataarray[$p] = array ("bank_id"=>$cid,"bank_name"=>$String->tis2utf8($ctitle));
	}
}
$filearray = array("banklist"=>$dataarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>