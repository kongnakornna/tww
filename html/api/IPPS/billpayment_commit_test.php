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
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$modulename='billpayment_commit_test.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_email=='' || $param_refid=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
        $memberid = $member->getcodebyemail($param_email); 
        $havepayment = $payment->checkpayment($param_refid,$param_email);        
        if ($havepayment) {
        $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
                for ($b=0;$b<count($paymentarray);$b++) {
                        $tt_id = $paymentarray[$b]['p_id'];
                        $tt_price = stripslashes($paymentarray[$b]['p_price']);
                        $tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
                        $tt_productid = stripslashes($paymentarray[$b]['p_productid']);
                        $tt_email = stripslashes($paymentarray[$b]['p_email']);
                        $tt_total = stripslashes($paymentarray[$b]['p_total']);
                        $tt_txnid = stripslashes($paymentarray[$b]['p_txnid']);
                } 

        if ($param_code == 'ES1012') {
            $service_id = 'TRUE33';
        } 
        if ($param_code == 'ES1011') {
            $service_id = 'DTAC01';
        } 
        if ($param_code == 'ES1013') {
            $service_id = 'AEON07';
        } 
        if ($param_code == 'ES1014') {
            $service_id = 'BBL105';
        }
        if ($param_code == 'ES1015') {
            $service_id = 'AMEX01';
        }
        if ($param_code == 'ES1016') {
            $service_id = 'TES87';
        }
        if ($param_code == 'ES1017') {
            $service_id = 'SVC81';
        }
        if ($param_code == 'ES1018') {
            $service_id = 'HPC24';
        }
        if ($param_code == 'ES1019') {
            $service_id = 'SC132';
        }
        if ($param_code == 'ES1020') {
            $service_id = 'CC19';
        }
        if ($param_code == 'ES1021') {
            $service_id = 'TMB02';
        }
        if ($param_code == 'ES1022') {
            $service_id = 'KTC02';
        }

        $reqstr = $ipps->bill_payment_confirm_msg($member_id,$service_id,$param_refid,$tt_txnid); 
        #$urlstr = "http://202.43.47.14/CentralService.svc/BillPaymentConfirm";
        $urlstr = "http://202.6.20.61/gc_mobile_billpayment_test.php";
        #$urlstr = "https://service.wopthailand.com/gc_mobile_billpayment_twz.php";
        
        $module_name_detail=$modulename.":bill_payment_commit";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);
        

        //payment status
        if ($result_array['status'] == '0101' || $result_array['status'] == '0102')  {
               #$payment->usedcardnobyemail($param_email,$tt_total);
               if ($result_array['status'] == '0101') {
                   $payment->updatepaymentstatus($param_refid);
                   $dataarray = array("result"=>"OK","result_desc"=>"");
               } 
               else {
                    $mycount = 0;
                    while ($mycount <= 3) 
                    {
                        $paymentarray1 = $payment->getpaymentdata($param_refid,$param_email);
                        for ($b=0;$b<count($paymentarray1);$b++) {
                        $tt_status = stripslashes($paymentarray1[$b]['p_status']);
                        } 
                        if ($tt_status <> 0) 
                        {
                            if ($tt_status == 1)
                                $dataarray = array("result"=>"OK","result_desc"=>"");
                            else
                                $dataarray = array("result"=>"FAIL1","result_desc"=>"พบความผิดพลาด ขณะดำเนินการชำระเงิน");
                            $mycount = 4;
                        } 
                        else  {
                           sleep(3);   
                        } 
                        $mycount = $mycount + 1;   
                   } 
                   if ($mycount == 4)
                       $dataarray = array("result"=>"OK","result_desc"=>"");
             } 
        }
        else {
               $error_mesg=$payment->geterrormesg('bill_payment.php','IPPS',$result_array['status']);
               $payment->updatepaymentstatusfail($param_refid);
               $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));
        }
        }
        else {
             $msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
             $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
        }
}

$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

