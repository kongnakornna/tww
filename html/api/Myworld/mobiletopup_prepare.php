<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include './myworld.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$myworld = new myworld();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_msisdn = (!empty($_REQUEST["msisdn"])) ? $_REQUEST["msisdn"] : "";
$param_txnid = (!empty($_REQUEST["txnid"])) ? $_REQUEST["txnid"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_totalprice = (!empty($_REQUEST["totalprice"])) ? $_REQUEST["totalprice"] : "";
$param_sercharge = (!empty($_REQUEST["sercharge"])) ? $_REQUEST["sercharge"] : "";
$modulename='mobiletopup_prepare.php[Myworld]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_code=='' || $param_price=='' || $param_txnid=='' || $param_email=='' || $param_refid=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èĞ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else if (strlen($param_msisdn) <> 10) {
        $msg = 'ËÁÒÂàÅ¢â·ÃÈÑ¾·ìäÁè¶Ù¡µéÍ§';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
	$servicename = $eservice->gettitle ($param_code);
        $partnercode = $eservice->getpaymentmap ($param_code);
        #$resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,$param_sercharge,$param_totalprice,$param_refid,$param_txnid,"",'N',$param_email,$param_email,'',$param_msisdn,'0');
        $payment->updatepaymenttxnid_wallet($param_refid,$param_txnid); 
        $payment->updatepaymentmsisdn($param_refid,$param_msisdn); 
        $dataarray = array("result"=>"OK","result_desc"=>"");
}

$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

