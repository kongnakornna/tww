<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$modulename='geteservicepay_ipps.php';
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$param_ref2 = (!empty($_REQUEST["ref2"])) ? $_REQUEST["ref2"] : "";
$param_ref3 = (!empty($_REQUEST["ref3"])) ? $_REQUEST["ref3"] : "";
$param_ref4 = (!empty($_REQUEST["ref4"])) ? $_REQUEST["ref4"] : "";
$param_msisdn = (!empty($_REQUEST["msisdn"])) ? $_REQUEST["msisdn"] : "";
$refcode = $String->GenKey("12");
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$request);
#error_log("logging=>".$request,3,"/tmp/mylog.txt");
if ($param_code=='' || $param_price=='' || $param_ref1=='' || $param_email=='' || $param_msisdn=='') {
	$msg = '�� parameter �����ú���';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	#$refcode = $String->GenKey("12");
        $sercharge = $eservice->getecharge($param_code);
        $totalprice = $param_price + $sercharge;
	$servicename = $eservice->gettitle ($param_code);
        $partnercode = $eservice->getpaymentmap ($param_code);
        $resultpayment = $payment->insertlemon($partnercode,$param_code,$servicename,'I',$param_price,$sercharge,$totalprice,$refcode,$param_ref1,$param_ref2,$param_ref3,$param_ref4,'N',$param_email,$param_email,'',$param_msisdn,'0');
	$dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refcode,"price"=>$param_price,"sercharge"=>$sercharge,"totalprice"=>$totalprice);
}
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,json_encode($dataarray));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

