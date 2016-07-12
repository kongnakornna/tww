<?php
include '../leone.php';
include '../admin/controller/payment.php';
header('Content-Type: application/json; charset=utf-8');
$payment = new payment();
$param_value = (!empty($_REQUEST["value"])) ? $_REQUEST["value"] : "";

if ($param_value=='') {
	$msg = "กรุณาข้อมูลให้ครบตามที่กำหนดด้วยค่ะ";
    $dataarray = array("result"=>"FAIL","result_detail"=>$String->tis2utf8($msg));
}else{
    $result = $payment->getpaymentcard($param_value);
	if ($result) {
       $dataarray = array("result"=>"OK","result_detail"=>"");
	}else{
	   $msg = "Payment Card ไม่สามารถใช้งานได้ค่ะ";
       $dataarray = array("result"=>"FAIL","result_detail"=>$String->tis2utf8($msg));
	}
}
$bookdata = array ("result"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>