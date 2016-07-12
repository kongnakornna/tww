<?php
include '../leone.php';
include '../admin/controller/eservice.php';
header('Content-Type: application/json; charset=utf-8');

$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";

$eservice = new eservice();
$cdata = $eservice->gettopup($param_code);
for ($b=0;$b<count($cdata);$b++) {
	$tt_price = $cdata[$b]['t_price'];

    $dataarray[$b] = array ("price"=>$tt_price);
}

$filearray = array("status"=>"OK","status_detail"=>"","pricelist"=>$dataarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

