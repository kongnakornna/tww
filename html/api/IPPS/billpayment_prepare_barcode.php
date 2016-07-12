<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'ipps.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$modulename='billpayment_prepare_barcode.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$param_refid = $String->GenKey('16'); 
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_code=='' || $param_email==''|| param_ref1=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$servicename = $eservice->gettitle ($param_code);
        $partnercode = $eservice->getpaymentmap ($param_code);
        $payment_type = '01';
        if ($param_code == 'ES1027') {
            $service_id = 'PWA67';
        }
        $reqstr = $ipps->bill_payment_request_msg($service_id,$param_refid,$param_email,$payment_type,$param_ref1,'','','','','','','',''); 
        
        //Bill payment Preparation 
        //$urlstr = "http://202.6.20.61/gc_mobile_billpayment_test.php";
        $urlstr = "http://service.wopthailand.com/gc_mobile_billpayment_twz.php";
        $module_name_detail=$modulename.":bill_payment_request:Request";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);

        if ($result_array['status'] == '0101' || $result_array['status'] == '0102')  {
            $mytxnid = $result_array['txn_id'];  
            #$payment->updatepaymenttxnid($param_refid,$mytxnid);            
            #error_log("withdraw wallet IPPS => ".$mytxnid."\n",3,"/tmp/mylog.txt"); 
            $ref1 = $result_array['ref1']; 
            $ref2 = $result_array['ref2']; 
            $ref3 = $result_array['ref3']; 
            $ref4 = $result_array['ref4']; 
            $ref5 = $result_array['ref5']; 
            $ref6 = $result_array['ref6']; 
            $ref7 = $result_array['ref7']; 
            $ref8 = $result_array['ref8']; 
            $param_sercharge = $eservice->getecharge($param_code); 
            $param_price = $result_array['amount'];
            $param_totalprice = $param_price + $param_sercharge; 
            $resultpayment = $payment->insertipps($partnercode,$param_code,$servicename,'I',$param_price,$param_sercharge,$param_totalprice,$param_refid,$ref1,$ref2,$ref3,$ref4,'N',$param_email,$param_email,'','','0');
            $payment->updatepaymenttxnid($param_refid,$mytxnid);            
            $reqstr = $ipps->bill_payment_verify_msg($service_id,$param_refid,$param_email,$payment_type,$ref1,$ref2,$ref3,$ref4,$ref5,$ref6,$ref7,$ref8,$mytxnid,$param_price); 
            #$reqstr = $ipps->bill_payment_verify_msg($service_id,$param_refid,$param_email,$payment_type,$param_msisdn,'','','','','','','',$mytxnid,$param_price); 
            #$urlstr = "http://202.6.20.61/gc_mobile_billpayment_test.php";
            $urlstr = "https://service.wopthailand.com/gc_mobile_billpayment_twz.php";
            $module_name_detail=$modulename.":bill_payment_request:Verify";
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr);
            if ($result_array['status'] == '0101' || $result_array['status'] == '0102')  {
              $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$param_refid,"price"=>$param_price,"sercharge"=>$param_sercharge,"totalprice"=>$param_totalprice,"ref1"=>$ref1,"ref2"=>$ref2,"ref3"=>$ref3,"ref4"=>$ref4,"ref5"=>$ref5,"ref6"=>$ref6,"ref7"=>$ref7,"ref8"=>$ref8,"txnid"=>$mytxnid,"duedate"=>$result_array['due_date']);
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

