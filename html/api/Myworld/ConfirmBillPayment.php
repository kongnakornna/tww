<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../../admin/controller/eservice.php';
include '../IPPS/ipps.php';
include './myworld.php';
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
$payment = new payment();
$member = new member();
$myworld = new myworld();
$eservice = new eservice();
$ipps = new ipps();

$param_refid = $_REQUEST['refid'];
$param_billid = $_REQUEST['billid'];
$param_sessionid = $_REQUEST['sessionid'];
$param_email = $_REQUEST['email'];
$modulename = "ConfirmMyworldPayment.php[Myworld]"; 
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
if ($param_refid=='' || $param_sessionid=='' || $param_billid=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $havepayment = $payment->checkpayment($param_refid,$param_email);
    if ($havepayment) {
        $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
        for ($b=0;$b<count($paymentarray);$b++) {
             $tt_id = $paymentarray[$b]['p_id'];
             $tt_price = stripslashes($paymentarray[$b]['p_price']);
             $tt_ref1 = stripslashes($paymentarray[$b]['p_ref1']);
             $tt_ref2 = stripslashes($paymentarray[$b]['p_ref2']);
             $tt_ref3 = stripslashes($paymentarray[$b]['p_ref3']);
             $tt_ref4 = stripslashes($paymentarray[$b]['p_ref4']);
             $tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
             $tt_productid = stripslashes($paymentarray[$b]['p_productid']);
             $tt_email = stripslashes($paymentarray[$b]['p_email']);
             $tt_total = stripslashes($paymentarray[$b]['p_total']);
             $tt_charge = stripslashes($paymentarray[$b]['p_charge']);
       }
    }


    if ($havepayment) {
        $urlstr = "https://118.172.47.185/bluews/postpaid/payBills";
        $reqstr = $myworld->paybill_request_msg($param_sessionid,$param_refid,$tt_msisdn,$param_billid,$tt_price,'eazycard');
        $module_name_detail=$modulename.":makePayment";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,json_encode($reqstr)); //Logging
        #$resstr = $myworld->myworld_submit_req($urlstr,json_encode($reqstr));
        error_log("Myworld => ".json_encode(server_output)."\n",3,"/tmp/mylog.txt");  
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resstr); //Logging
        #$result_array = json_decode($resstr,true);
        $result_array['responseCode'] = 1;
       if ($result_array['responseCode'] == '1') {
            $dataarray = array("result"=>"OK","result_desc"=>""); 
            $payment->updatepaymentstatus($param_refid);
            $payment->usedcardnobyemail($param_email,$tt_total);
            /*$memberid = $member->getcodebyemail($param_email);
            $discount = $eservice->getediscount($tt_productid,$memberid,$tt_price);
            $module_name_detail=$modulename.":discount_revenue_req";
            $urlstr = "https://www.payforu.com/webservice/payforuservice.svc/discountRevenue";
            $reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],'01');
            $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Discount Revenue API
            $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr);
            if ($result_array['status'] == '01')  {
                 $mytext = "ส่วนลดจากการทำรายการเอง";
                 $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_own'],'0',$discount['discount_result_own'],$param_refid,$tt_total,$tt_charge,'N',$tt_email,'','TWZ',$tt_msisdn,'1');
                 if ($discount['memberid_other'] != '') {
                     $mytext = "ส่วนลดจากผู้อื่นทำรายการ";
                     $other_email = $member->getemailbycode($discount['memberid_other']);
                     $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ',$tt_msisdn,'1');
                 }
           }*/
       }
       else{ 
            $payment->updatepaymentstatusfail($param_refid);
            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($result_array['responseMessage']));
       }
    }
    else {
          $dataarray = array("result"=>"FAIL","Can't find payment record");
    }
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
