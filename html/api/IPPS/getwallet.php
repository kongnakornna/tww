<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'ipps_test.php';
header('Content-Type: application/json; charset=utf-8');

$ipps = new ipps();
$payment = new payment();
$modulename = "getwallet_request.php[IPPS]";
$param_channel = (!empty($_REQUEST["channel"])) ? $_REQUEST["channel"] : "";
$param_refdate = (!empty($_REQUEST["refdate"])) ? $_REQUEST["refdate"] : "";
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);

if ($param_refdate=='' || $param_channel=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
        //Check Wallet 
        $reqstr = $ipps->getwallet_request_msg($param_channel,$param_refdate);
        //$urlstr = "http://202.6.20.61/gc_mobile_topup_test.php";
        $urlstr = "http://202.6.20.61/GetMyWalletByType.php";
        $module_name_detail=$modulename.":getwallet_request_bytype";
        $resultlogging = $payment->insertlog('IPPS','IPPS','BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog('IPPS','IPPS','BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr); 
     
        //Check Wallet Status
        if ($result_array['status'] == '0101')  {
               $dataarray = array("result"=>"OK","result_desc"=>"","balance"=>$result_array['balance']);
        } 
        else {
               $dataarray = array("result"=>"FAIL","result_desc"=>$status);
        }      
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

