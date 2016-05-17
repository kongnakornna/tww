<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/bill.php';
require './controller/member.php';
require './controller/payment.php';
require '../api/IPPS/ipps.php';
header('Content-Type: text/html; charset=tis620');
$bill = new bill();
$member = new member();
$payment = new payment();
$ipps = new ipps();
$param_cardcode = (!empty($_REQUEST["cardcode"])) ? $_REQUEST["cardcode"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$modulename = 'front_payment_exec.php[IPPS]'; 

$membercode = $payment->getmembercodefromcardno($param_cardcode);
$memberemail = $member->getemailfromcode($membercode);
$memberresult = $payment->checkfirstpaymentandupdate($memberemail);

        $ordernumber = $bill->runid();
        //Sync Balance IPPS
        $refcode = $ordernumber;
        $m_balance_new = ceil($param_price);
        $m_balance_nodecimal = $m_balance_new * 100;
        $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Barcode','PARTNER',$m_balance_new);
        #$urlstr = "https://test.payforu.com/payforuservice.svc/APIDirectTopupRequest";
        $urlstr  = "https://www.payforu.com/webservice/payforuservice.svc/APIDirectTopupRequest";
        $module_name_detail=$modulename.":direct_topup_request";
        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);

        if ($result_array['type'] == 'Barcode' && $result_array['status'] == '01') {
            $barcodetxt = $result_array['responsedata'];
            $my_string = preg_replace(array('/\n/', '/\r/'), '#PH#', $barcodetxt);
            $barcodetxt_arr = explode('#PH#', $my_string);
            print_r($barcodetxt_arr);
            if (!empty($barcodetxt_arr)) {
                $ipps_custid = $barcodetxt_arr[1];
                $refid_ipps = $barcodetxt_arr[2];
                $reqstr = $ipps->twz_topup_request_msg($ipps_custid,'Check',$refid_ipps,$refcode,$m_balance_nodecimal);
                $urlstr = "https://www.payforu.com/webservice/payforuservice.svc/partnerbillrequest";
                $module_name_detail=$modulename.":TWZ_topup_request";
                $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging

                $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
                $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                $result_array = $ipps->extractresult($resstr);

                
                                if ($result_array['status'] == '01') {
                                        $reqstr = $ipps->twz_topup_request_msg($ipps_custid,'Request',$refid_ipps,$refcode,$m_balance_nodecimal);
                                        $urlstr = "https://www.payforu.com/webservice/payforuservice.svc/partnerbillrequest";
                                        $module_name_detail=$modulename.":TWZ_topup_request";
                                        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                                        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
                                        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                                        $result_array = $ipps->extractresult($resstr);
                                        if ($result_array['status'] == '01') {
                                                print "Transfer Successfully";
                                                $payment->insert ('TWZ','',strtoupper($param_cardcode),'A',$param_price,'0',$param_price,$param_ref,$ordernumber,$refid_ipps,'N',$memberemail,$_SESSION['TWZUsername'],'TWZ','','1');
                                                
            					// Sync E-wallet Pay for U
           					 $reqstr = $ipps->direct_customer_info($membercode);
           					 $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/Customerinfo";
           					 $module_name_detail=$modulename.":direct_customer_info";
           					 $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
            					 $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API
            					$resultlogging = $payment->insertlog($refcode,$memberemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
           		  		         $result_array = $ipps->extractresult($resstr);
           					 if ($result_array['result'] == '01') {
             					  $payment->adjustcardnobyemail($memberemail,$result_array['account_balance']);
           					 }
                                        }
                                        else {
                                                $payment->insert ('TWZ','',strtoupper($param_cardcode),'A',$param_price,'0',$param_price,$param_ref,$ordernumber,'Error 1','N',$memberemail,$_SESSION['TWZUsername'],'TWZ','','9');
                                        }
                }
                                else {
                                                $payment->insert ('TWZ','',strtoupper($param_cardcode),'A',$param_price,'0',$param_price,$param_ref,$ordernumber,'Error 2','N',$memberemail,$_SESSION['TWZUsername'],'TWZ','','9');
                                }
            }
                        else {
                $payment->insert ('TWZ','',strtoupper($param_cardcode),'A',$param_price,'0',$param_price,$ref,$ordernumber,'Error 3','N',$memberemail,$_SESSION['TWZUsername'],'TWZ','','9');
                        }
                }
                else {
                $payment->insert ('TWZ','',strtoupper($param_cardcode),'A',$param_price,'0',$param_price,$param_ref,$ordernumber,'Error 4','N',$memberemail,$_SESSION['TWZUsername'],'TWZ','','9');
                }



$DatabaseClass->DBClose();
?>
<script type="text/javascript">
<!--
	document.location.replace('front_paymentview_form.php?keyword=<?php echo $membercode;?>');
//-->
</script>
