<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'myworld.php';
include '../IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$myworld = new myworld();
$ipps = new ipps();
$modulename = "mobiletopup_commit.php[myworld]";
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
     
        //Login Request 
        $reqstr = $myworld->login_request_msg();
        $urlstr = "https://118.172.47.185/bluews/thirdParty/login";
        $module_name_detail=$modulename.":login_request";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,json_encode($reqstr)); //Logging
        $resstr = $myworld->myworld_submit_req($urlstr,json_encode($reqstr));
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resstr); //Logging
        $result_array = json_decode($resstr,true); 
     
        //Payment Request 
        if ($result_array['responseCode'] == '1')  {
               $myresult = $payment->updatepaymenttxnid($param_refid,$result_array['sessionId']);
               $urlstr = "https://118.172.47.185/bluews/prepaid/topup";
               $reqstr = $myworld->prepaid_request_msg($result_array['sessionId'],$param_refid,'eazycard',$tt_msisdn,$tt_price);
               $module_name_detail=$modulename.":mobile_topup_request";
               $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,json_encode($reqstr)); //Logging
               $resstr = $myworld->myworld_submit_req($urlstr,json_encode($reqstr));
               $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resstr); //Logging
               $result_array = json_decode($resstr,true); 
               if ($result_array['responseCode'] == '1') { 
                   $payment->updatepaymentstatus($param_refid);
                   $dataarray = array("result"=>"OK","result_desc"=>"");
                   $payment->usedcardnobyemail($param_email,$tt_total);
                   $memberid = $member->getcodebyemail($param_email);
                   $discount = $eservice->getediscount($tt_productid,$memberid,$tt_price);
                   $module_name_detail=$modulename.":discount_revenue_req";
                   $urlstr = "https://www.payforu.com/webservice/payforuservice.svc/discountRevenue";
                   $reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],'02');
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
                             #$payment->insert ($discount['memberid_other'],$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ','','1');
                             $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ',$tt_msisdn,'1');
                        } 
                   }
               }
               else{
                   $payment->updatepaymentstatusfail($param_refid);
                   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($result_array['responseMessage']));
               } 
        } 
        else {
               $payment->updatepaymentstatusfail($param_refid);
               $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($result_array['$responseMessage']));
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

