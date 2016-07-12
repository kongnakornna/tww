<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'ipps_test.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_msisdn = (!empty($_REQUEST["msisdn"])) ? $_REQUEST["msisdn"] : "";
$param_txnid = (!empty($_REQUEST["txnid"])) ? $_REQUEST["txnid"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$param_ref2 = (!empty($_REQUEST["ref2"])) ? $_REQUEST["ref2"] : "";
$param_ref3 = (!empty($_REQUEST["ref3"])) ? $_REQUEST["ref3"] : "";
$param_ref4 = (!empty($_REQUEST["ref4"])) ? $_REQUEST["ref4"] : "";
$payment_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_totalprice = (!empty($_REQUEST["totalprice"])) ? $_REQUEST["totalprice"] : "";
$param_sercharge = (!empty($_REQUEST["sercharge"])) ? $_REQUEST["sercharge"] : "";
$modulename='billpayment_prepare_test.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_code=='' || $param_price=='' || $param_txnid=='' || $param_email=='' || $param_refid=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$servicename = $eservice->gettitle ($param_code);
        $partnercode = $eservice->getpaymentmap ($param_code);
        $payment_type = '02';
        $resultpayment = $payment->insertipps($partnercode,$param_code,$servicename,'I',$param_price,$param_sercharge,$param_totalprice,$param_refid,$param_ref1,$param_ref2,$param_ref3,$param_ref4,'N',$param_email,$param_email,'',$param_msisdn,'0');
        $resultpayment = $payment->updatepaymenttxnid_wallet($param_refid,$param_txnid);
        if ($param_code == 'ES1012') {
            $service_id = 'TRUE33';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,'','','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1011') {
            $service_id = 'DTAC01';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,'','','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1013') {
            $service_id = 'AEON07';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1014') {
            $service_id = 'BBL105';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1015') {
            $service_id = 'AMEX01';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1016') {
            $service_id = 'TES87';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1017') {
            $service_id = 'SVC81';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1018') {
            $service_id = 'HPC24';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1019') {
            $service_id = 'SC132';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1020') {
            $service_id = 'CC19';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1021') {
            $service_id = 'TMB02';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        if ($param_code == 'ES1022') {
            $service_id = 'KTC02';
            $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,$param_ref1,'','','','','','',$param_price); 
        } 
        
        //Bill payment Preparation 
        $urlstr = "http://202.6.20.61/gc_mobile_billpayment_test.php";
        //$urlstr = "http://service.wopthailand.com/gc_mobile_billpayment_twz.php";
        $module_name_detail=$modulename.":bill_payment_request:Request";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);

        if ($result_array['status'] == '0101' || $result_array['status'] == '0102')  {
            $mytxnid = $result_array['txn_id'];  
            $payment->updatepaymenttxnid($param_refid,$mytxnid);            
            error_log("withdraw wallet IPPS => ".$mytxnid."\n",3,"/tmp/mylog.txt"); 
            $reqstr = $ipps->bill_payment_verify_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,'','','','','','','',$mytxnid,$param_price); 
            $urlstr = "http://202.6.20.61/gc_mobile_billpayment_test.php";
            #$urlstr = "https://service.wopthailand.com/gc_mobile_billpayment_twz.php";
            $module_name_detail=$modulename.":bill_payment_request:Verify";
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr);
            if ($result_array['status'] == '0101' || $result_array['status'] == '0102')  {
                $dataarray = array("result"=>"OK","result_desc"=>"");
            }
            else {
               $error_mesg=$payment->geterrormesg('bill_payment.php','IPPS',$result_array['status']);
               $payment->updatepaymentstatusfail($param_refid);
               // Refund E-wallet to be coded
               $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));
            }
        }
        else {
            $error_mesg=$payment->geterrormesg('bill_payment.php','IPPS',$result_array['status']);
            $payment->updatepaymentstatusfail($param_refid);
               // Refund E-wallet to be coded
            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));
        }
}

$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

