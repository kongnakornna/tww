<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/member.php';
include './mpay.config.php';
include '../IPPS/ipps_test.php';
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$payment = new payment();
$eservice = new eservice();
$member = new member();
$ipps = new ipps();
$param_req = $_REQUEST['req'];
$param_refid = $_REQUEST['refid'];
$param_email = $_REQUEST['email'];
$param_msisdn = $_REQUEST['msisdn'];
$param_price = $_REQUEST['price'];
$modulename='TopUpOne2Call.php[Mpay]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
if ($param_req=='' || $param_refid=='' || $param_msisdn=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $ans = $paymentmpay->checkPaymentRecord($param_refid,$param_email);
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
       }
    }
     

     #error_log("ans => ".$ans."\n",3,"/tmp/mylog.txt");

    if ($ans && $havepayment) {
		$ch = curl_init(); 
		$myreq =  MPAYURL1 . "?channelName=MERCHANT&command=One2Call&shoppingChannel=MERCHANT&serviceId=1100150002117314&appName=12callAgent&parameter=12CALL_AGENT_OTHER&mobileNo=".MASTERMOBILE."&payeeMobile=".$param_msisdn."&pin=".MCASHPIN."&amount=" . $param_price;
	        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$modulename,$myreq); 	
                #error_log("myreq => ".$myreq."\n",3,"/tmp/mylog.txt");
                curl_setopt($ch, CURLOPT_URL, MPAYURL1 . "?channelName=MERCHANT&command=One2Call&shoppingChannel=MERCHANT&serviceId=1100150002117314&appName=12callAgent&parameter=12CALL_AGENT_OTHER&mobileNo=".MASTERMOBILE."&payeeMobile=".$param_msisdn."&pin=".MCASHPIN."&amount=" . $param_price);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false); 
		curl_setopt($ch, CURLOPT_SSLKEY, "mpayweb.keystore"); 
		#curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "changit"); 
		#curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "changit"); 
		curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "0934145546"); 
		curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "X@4rQWYK"); 
		curl_setopt($ch, CURLOPT_SSLVERSION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$server_output = curl_exec ($ch);
		curl_close ($ch);	

		#"https://saichon-beauty.ais.co.th:8002/mediator/mpayservice?channelName=MERCHANT&command=One2Call&shoppingChannel=MERCHANT&serviceId=1100150000000225&appName=12callAgent&parameter=12CALL_AGENT_OTHER&mobileNo=0870182314&payeeMobile=0899833338&pin=0405&amount=10";
		
		$responsedata = $paymentmpay->extractdata(trim($server_output));
                #error_log("myres => ".$responsedata."\n",3,"/tmp/mylog.txt");
                $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$modulename,$server_output);	
        	$xml = simplexml_load_string($responsedata);
		$status = (string) $xml->status;
		$detail = (string) $xml->detail;
		$responsecode = (string) $xml->responsecode;
		$tranId = (string) $xml->tranId;
		$processStatus = (string) $xml->processStatus;

		$data = "status : " . $status . "\n";
		$data .= "detail : " . $detail . "\n";
		$data .= "responsecode : " . $responsecode . "\n";
		$data .= "tranId : " . $tranId . "\n";
		$data .= "processStatus : " . $processStatus . "\n\n";
                #error_log("data => ".$data."\n",3,"/tmp/mylog.txt");
		
		if ($status=='ok') {
		   if ($processStatus=='N') {
			   $msg = 'เงินในกระเป๋า mCash ไม่พอ';
			   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		           $payment->updatepaymentstatusfail($param_refid); 
                   }else{
			   $dataarray = array("result"=>"OK","result_desc"=>"");
                           $payment->updatepaymentstatus($param_refid);
                           $payment->usedcardnobyemail($param_email,$tt_total);
                           $memberid = $member->getcodebyemail($param_email);
                           $discount = $eservice->getediscount($tt_productid,$memberid,$tt_price);
                           $module_name_detail=$modulename.":discount_revenue_req";
                           $urlstr = "https://test.payforu.com/webservice/payforuservice.svc/discountRevenue";
                           $reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],'02');
                           $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                           $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Discount Revenue API
                           $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                           $result_array = $ipps->extractresult($resstr);
                           if ($result_array['status'] == '01')  { 
                            $mytext = "ส่วนลดจากการทำรายการเอง"; 
                            $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_own'],'0',$discount['discount_result_own'],$param_refid,'','','N',$tt_email,'','TWZ','','1'); 
                             if ($discount['memberid_other'] != '') {
                             $mytext = "ส่วนลดจากผู้อื่นทำรายการ";
                             $payment->insert ($discount['memberid_other'],$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,'','','N',$tt_email,'','TWZ','','1'); 
                             }
                           }		  
                   } 
		}else{
		   $dataarray = array("result"=>"FAIL","result_desc"=>$detail);
	           $payment->updatepaymentstatusfail($param_refid);	
                }
	}else{
	   $msg = 'ไม่พบข้อมูลสำหรับดำเนินการในระบบ';
	   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}

$paymentmpay->updateRecord ($param_msisdn,$param_price,$param_refid,$param_email,$tranId,$status);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
