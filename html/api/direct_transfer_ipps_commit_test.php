<?php
include '../leone.php';
include '../admin/controller/eservice.php.tmp';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
include './IPPS/ipps_test.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_memberid = (!empty($_REQUEST["memberid"])) ? $_REQUEST["memberid"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_txnid = (!empty($_REQUEST["txnid"])) ? $_REQUEST["txnid"] : "";
$param_otp = (!empty($_REQUEST["otp"])) ? $_REQUEST["otp"] : "";
$modulename='direct_transfer_member_commit.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_refid=='' || $param_txnid==''  || $param_email=='' || $param_otp=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
        $memberid = $member->getcodebyemail($param_email);
        $reqstr = $ipps->direct_transfer_member_commit_msg($memberid,$param_memberid,$param_refid,$param_txnid,$param_otp);
        $urlstr = "https://test.payforu.com/webService/payforuservice.svc/TransferToMember"; // Transfer money to member Confirm
        $module_name_detail=$modulename.":direct_transfer_member_confirm";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //E-wallet Deduct Confirm API        
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr); 
        if ($result_array['result'] == '01')  {
	
            // Sync E-wallet Pay for U
            $reqstr = $ipps->direct_customer_info($memberid);
            $urlstr = "https://test.payforu.com/WebService/payforuservice.svc/Customerinfo";
            $module_name_detail=$modulename.":direct_customer_info";
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
            $result_array = $ipps->extractresult($resstr);
            if ($result_array['result'] == '01') {
               $balance_new = $result_array['account_balance'];
               $payment->adjustcardnobyemail($param_email,$balance_new);
            }
           
            // Deduct the local wallet 
            $havepayment = $payment->checkpayment($param_refid,$param_email);
            $memberid = $member->getcodebyemail($param_email);
            if ($havepayment) {
                $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
                for ($b=0;$b<count($paymentarray);$b++) {
                        $tt_total = stripslashes($paymentarray[$b]['p_total']);
                        $tt_price = stripslashes($paymentarray[$b]['p_price']);
                        $tt_charge = stripslashes($paymentarray[$b]['p_charge']);
                        $tt_productid = stripslashes($paymentarray[$b]['p_productid']);
                }
                $payment->usedcardnobyemail($param_email,$tt_total); 
                $discount=$eservice->getediscount_withdraw($param_memberid,$tt_price);
                $module_name_detail=$modulename.":discount_revenue_req";
                $urlstr = "https://test.payforu.com/webservice/payforuservice.svc/discountRevenue";
                $mycode = '04';
                $reqstr = $ipps->discount_revenue_req_msg($param_refid,$param_memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],$mycode);
                $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Discount Revenue API
                $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                $result_array = $ipps->extractresult($resstr);
                if ($result_array['status'] == '01')  {
                    $mytext = "ส่วนลดจากการทำรายการเอง";
                    $payment->insert ($param_memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_own'],'0',$discount['discount_result_own'],$param_refid,$tt_total,$tt_charge,'N',$param_email,'','TWZ','','1');
                    if ($discount['memberid_other'] != '') {
                        $mytext = "ส่วนลดจากผู้อื่นทำรายการ";
                        $other_email = $member->getemailbycode($discount['memberid_other']);
                        $payment->insert ($param_memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ','','1');
                    } 
               }
            }
            $dataarray = array("result"=>"OK","result_desc"=>"");
        }
        else
        {
            $error_mesg=$payment->geterrormesg('direct_transfer_member.php','IPPS',$result_array['result']);
            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));     
        }	
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

