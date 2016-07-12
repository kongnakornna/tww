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
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_txnid = (!empty($_REQUEST["txnid"])) ? $_REQUEST["txnid"] : "";
$modulename='ewalletpaycancel.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_refid=='' || $param_txnid==''  || $param_email=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èĞ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
        $memberid = $member->getcodebyemail($param_email);
        $reqstr = $ipps->ewallet_deduct_refund_msg($memberid,$param_refid,$param_txnid);
        $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/EWalletCancelRequest"; // E-wallet Deduct Confirm
        $module_name_detail=$modulename.":e_wallet_deduct_refund_request";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //E-wallet Deduct Confirm API        
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr); 
        if ($result_array['status'] == '01')  {
            $reqstr = $ipps->ewallet_deduct_refund_confirm_msg($memberid,$param_txnid);
            $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/EWalletCancelConfirmRequest"; // E-wallet Deduct Confirm
            $module_name_detail=$modulename.":e_wallet_deduct_refund_confirm";
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //E-wallet Deduct Confirm API        
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr); 
           
            if ($result_array['status'] == '01')  {
            $remarktxt = 'Refund Success';
            $payment->updatepaymentremark($remarktxt,$param_refid);
            $payment->updatepaymentstatusfail($param_refid);

            // Sync E-wallet Pay for U
            $reqstr = $ipps->direct_customer_info($memberid);
            $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/Customerinfo";
            $module_name_detail=$modulename.":direct_customer_info";
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr);
            if ($result_array['result'] == '01') {
               $balance_new = $result_array['account_balance'];
               $payment->adjustcardnobyemail($param_email,$balance_new);
            }


            // Refund local wallet 
            $havepayment = $payment->checkpayment($param_refid,$param_email);
            if ($havepayment) {
                $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
                for ($b=0;$b<count($paymentarray);$b++) {
                        $tt_total = stripslashes($paymentarray[$b]['p_total']);
                }
                $payment->refundcardnobyemail($param_email,$tt_total);
            }
           
	    $dataarray = array("result"=>"OK","result_desc"=>"");
            }
            else {
            $remarktxt = 'Refund Failed with code '.$result_array['status'];
            $payment->updatepaymentremark($remarktxt,$param_refid);
            $dataarray = array("result"=>"OK","result_desc"=>"");
            } 
        }
        else
        {
            $remarktxt = 'Refund Failed with code '.$result_array['status'];
            $payment->updatepaymentremark($remarktxt,$param_refid);
            $dataarray = array("result"=>"OK","result_desc"=>"");
            #$error_mesg=$payment->geterrormesg('e_wallet_request.php','IPPS',$result_array['status']);
            #$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));     
        }	
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

