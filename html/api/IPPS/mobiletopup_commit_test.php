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
$modulename = "mobiletopup_commit_test.php[IPPS]";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);

if ($param_refid=='' || $param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
        $havepayment = $payment->checkpayment($param_refid,$param_email);
        $memberid = $member->getcodebyemail($param_email); 
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
        //Check operator code
        if ($tt_productid == 'ES1001') // Happy DTAC
             $service_id = "2";
        if ($tt_productid == 'ES1002') // True Move
             $service_id = "1";
     
        //Mobile Topup Request 
        $reqstr = $ipps->mobile_topup_request_msg($memberid,$service_id,$param_refid,$tt_price,$tt_msisdn);
        $urlstr = "http://202.6.20.61/gc_mobile_topup_test.php";
        //$urlstr = "http://202.6.20.61/gc_mobile_topup_twz.php";
        $module_name_detail=$modulename.":mobile_topup_request";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr); 
     
        //payment status 
        if ($result_array['status'] == '0101' || $result_array['status'] == '0102')  {
               if ($result_array['status'] == '0101')  {
               $payment->updatepaymentstatus($param_refid);
               $dataarray = array("result"=>"OK","result_desc"=>"");
               }
               else{
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
               $error_mesg=$payment->geterrormesg('mobile_topup.php','IPPS',$result_array['status']);
               $payment->updatepaymentstatusfail($param_refid);
               $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));
        }      
	}
        else{
   	       $msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
	       $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

