<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_msisdn = (!empty($_REQUEST["msisdn"])) ? $_REQUEST["msisdn"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$modulename='BillprepareMyworld.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$param_refid= $String->GenKey("16");
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_code=='' || $param_price=='' || $param_msisdn=='' || $param_email=='' || $param_ref1=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èĞ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
elseif ((strlen($param_msisdn) <> 10)) {
	$msg = 'ËÁÒÂàÅ¢â·ÃÈÑ¾·ìäÁè¶Ù¡µéÍ§';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
    $servicename = $eservice->gettitle ($param_code);
    $partnercode = $eservice->getpaymentmap ($param_code);
    $param_sercharge = $eservice->getecharge($param_code);       
    $param_totalprice = $param_price + $param_sercharge;     
    $resultpayment = $payment->insertipps($partnercode,$param_code,$servicename,'I',$param_price,$param_sercharge,$param_totalprice,$param_refid,$param_ref1,'','','','N',$param_email,$param_email,'',$param_msisdn,'0');
   #$dataarray = array("result"=>"OK","result_desc"=>"");
    $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$param_refid,"price"=>$param_price,"sercharge"=>$param_sercharge,"totalprice"=>$param_totalprice);
}

$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

