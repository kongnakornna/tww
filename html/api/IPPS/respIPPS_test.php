<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'ipps_test.php';
header('Content-Type: text/html; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";
$param_refid = (!empty($_REQUEST["member_ref"])) ? $_REQUEST["member_ref"] : "";
$param_txnid = (!empty($_REQUEST["txn_id"])) ? $_REQUEST["txn_id"] : "";
$param_memberid = (!empty($_REQUEST["member_id"])) ? $_REQUEST["member_id"] : "";
$modulename='respIPPS_test.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,'IPPS','FE:REQ',$modulename,$String->utf82tis($request));
/*error_log("update status wepay status => ".$param_status."\n",3,"/tmp/mylog.txt");
error_log("update status wepay refid => ".$param_refid."\n",3,"/tmp/mylog.txt");
error_log("update status wepay txnid => ".$param_txnid."\n",3,"/tmp/mylog.txt");
error_log("update status wepay sms => ".$param_sms."\n",3,"/tmp/mylog.txt");
error_log("update status wepay oper_txnid => ".$param_operator_txnid."\n",3,"/tmp/mylog.txt");*/
if ($param_status == '' || $param_refid == '' || $param_memberid == '') {
    $respstr = "SUCCEED|".$param_txnid;
}
else {
$paymentarray = $payment->getpaymentdatabyrefcode($param_refid);
for ($b=0;$b<count($paymentarray);$b++) {
	$tt_id = $paymentarray[$b]['p_id'];
	$tt_price = stripslashes($paymentarray[$b]['p_price']);
	$tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
	$tt_productid = stripslashes($paymentarray[$b]['p_productid']);
	$tt_email = stripslashes($paymentarray[$b]['p_email']);
	$tt_total = stripslashes($paymentarray[$b]['p_total']);
	$tt_txnid = stripslashes($paymentarray[$b]['p_txnid_wallet']);
}

if ((trim($param_status))=='0101') {
     $payment->updatepaymentstatus($param_refid);
     $payment->usedcardnobyemail($tt_email,$tt_total);
     $memberid=$member->getcodebyemail($tt_email); 
     #error_log("memberid => ".$memberid."\n",3,"/tmp/mylog.txt");      
     #error_log("product_id => ".$tt_productid."\n",3,"/tmp/mylog.txt");      
     #error_log("price => ".$tt_price."\n",3,"/tmp/mylog.txt");      
     $discount=$eservice->getediscount($tt_productid,$memberid,$tt_price);
     #error_log("memberid_own => ".print_r($discount,true)."\n",3,"/tmp/mylog.txt");      
     #error_log("memberid_other => ".$discount['memberid_other']."\n",3,"/tmp/mylog.txt");      
     #error_log("discount => ".$discount['discount_result_own']."\n",3,"/tmp/mylog.txt");      
     $module_name_detail=$modulename.":discount_revenue_req";
     $urlstr = "https://test.payforu.com/webservice/payforuservice.svc/discountRevenue";
     if ($tt_productid == 'ES9996' || $tt_productid == 'ES1001' || $tt_productid == 'ES1002') 
          $mycode = '02';
     else 
          $mycode = '01';	 
     #$reqstr = $ipps->discount_revenue_req_msg($param_refid,'15120000389','2.5','0.15','0.15','01');
     #$reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],'15080000004','0.07',$discount['rev_share_ipps'],$discount['rev_share'],'02');
     $reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],$mycode);
     $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
     $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Discount Revenue API
     $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
     $result_array = $ipps->extractresult($resstr);
     if ($result_array['status'] == '01')  {
         $mytext = "��ǹŴ�ҡ��÷���¡���ͧ"; 
         $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_own'],'0',$discount['discount_result_own'],$param_refid,'','','N',$tt_email,'','TWZ','','1');  
         if ($discount['memberid_other'] != '') {
             $mytext = "��ǹŴ�ҡ�����蹷���¡��";
  	     $payment->insert ($discount['memberid_other'],$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,'','','N',$tt_email,'','TWZ','','1');  
         }  
     }
}
else{
    $payment->updatepaymentstatusfail($param_refid);
    $memberid = $member->getcodebyemail($tt_email);
    $reqstr = $ipps->ewallet_deduct_refund_msg($memberid,$param_refid,$tt_txnid);
    $urlstr = "https://test.payforu.com/WebService/payforuservice.svc/EWalletCancelRequest"; // E-wallet Deduct Confirm
    $module_name_detail=$modulename.":e_wallet_deduct_refund";
    $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
    $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //E-wallet Deduct Confirm API
    $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
    $result_array = $ipps->extractresult($resstr);
    if ($result_array['status'] == '01')  {
            $reqstr = $ipps->ewallet_deduct_refund_confirm_msg($memberid,$tt_txnid);
            $urlstr = "https://test.payforu.com/WebService/payforuservice.svc/EWalletCancelConfirmRequest"; // E-wallet Deduct Confirm
            $module_name_detail=$modulename.":e_wallet_deduct_refund_confirm";
            $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //E-wallet Deduct Confirm API
            $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr);

            if ($result_array['status'] == '01')  {

            $remarktxt = 'Refund Success'; 
            $payment->updatepaymentremark($remarktxt,$param_refid);
 
             // Sync E-wallet Pay for U
             $reqstr = $ipps->direct_customer_info($memberid);
             $urlstr = "https://test.payforu.com/WebService/payforuservice.svc/Customerinfo";
             $module_name_detail=$modulename.":direct_customer_info";
             $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
             $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API
             $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
             $result_array = $ipps->extractresult($resstr);
             $balance_new = $result_array['account_balance']; 
             if ($result_array['result'] == '01') {
               $payment->adjustcardnobyemail($tt_email,$balance_new);
             }
           }
           else {
                  $remarktxt = 'Refund Failed with code '.$result_array['status'];
                  $payment->updatepaymentremark($remarktxt,$param_refid);
           }

   }
    else
    {
            $remarktxt = 'Refund Failed with code '.$result_array['status']; 
            $payment->updatepaymentremark($remarktxt,$param_refid);
    }
}
$respstr = "SUCCEED|".$param_txnid;
}
$resultlogging = $payment->insertlog($param_refid,'IPPS','FE:RES',$modulename,$String->utf82tis($respstr));
print $respstr;
?>
