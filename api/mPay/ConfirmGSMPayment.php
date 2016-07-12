<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../../admin/controller/eservice.php';
include '../IPPS/ipps.php';
include './mpay.config.php';
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$payment = new payment();
$member = new member();
$eservice = new eservice();
$ipps = new ipps();
$param_req = $_REQUEST['req'];
$param_refid = $_REQUEST['refid'];
$param_seqnum = $_REQUEST['seqNum'];
$param_sessionid = $_REQUEST['sessionid'];
$param_email = $_REQUEST['email'];
$modulename = "ConfirmGSMPayment.php"; 
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
if ($param_req=='' || $param_refid=='' || $param_sessionid=='' || $param_seqnum=='') {
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
             $tt_charge = stripslashes($paymentarray[$b]['p_charge']);
       }
    }


    if ($ans && $havepayment) {
        $parameter = "channelName=MERCHANT&command=GSMBILL2&sessionId=".$param_sessionid."&shoppingChannel=MERCHANT&billSeq=".$param_seqnum."&mobileNo=".MASTERMOBILE."&merchantRef=".$param_refid;
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$modulename,$parameter);
        #error_log("TOPUPGSM2:request  ".$parameter."\n",3,"/tmp/mylog.txt");  
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, MPAYURL1 . "/mediator/mpayservice?" . $parameter);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false); 
	curl_setopt($ch, CURLOPT_SSLKEY, "mpayweb.keystore"); 
	curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "changit"); 
	curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "changit"); 
	curl_setopt($ch, CURLOPT_SSLVERSION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$server_output = curl_exec ($ch);
	curl_close ($ch);	
		
	$responsedata = $paymentmpay->extractdata(trim($server_output));
        #error_log("TOPUPGSM2:responsedata ".$responsedata."\n",3,"/tmp/mylog.txt");  
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$modulename,$server_output); 
        #$xml = simplexml_load_string($responsedata);
        $xml = simplexml_load_string(str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$responsedata));
	$status = (string) $xml->status;
	$detail = (string) $xml->detail;
	$totalAmt = (string) $xml->totalAmt;
	$responsecode = (string) $xml->responsecode;
	$tranStatus1 = (string) $xml->tranStatus1;
	$sessionId = (string) $xml->sessionId;
	$inccustfee = (string) $xml->incCustFee;
	$tranid = (string) $xml->tranId;
	$tranid2 = (string) $xml->tranId2;
	$tranamt1 = (string) $xml->tranAmt1;
	$tranamt2 = (string) $xml->tranAmt2;
	$pilist = (string) $xml->piList;
        #error_log("TOPUPGSM2:xml_parser ".$tranId."\n",3,"/tmp/mylog.txt");  
        #error_log("TOPUPGSM2:xml_parser ".$status."\n",3,"/tmp/mylog.txt");  
        #error_log("TOPUPGSM2:xml_parser ".$status."\n",3,"/tmp/mylog.txt");  
        error_log("TOPUPGSM2:xml_parser ".$tranStatus1."\n",3,"/tmp/mylog.txt");  

	/*$property_brandid = simplexml_load_string($invlist)->array->void->object->void[0]->int;
	$property_mcash = simplexml_load_string($invlist)->array->void->object->void[0]->double;
	$property_custid = simplexml_load_string($invlist)->array->void->object->void[0]->long;
	$property_ivrcode = simplexml_load_string($pilist)->array->void->object->void[2]->string;*/
	$property_piid = simplexml_load_string($pilist)->array->void->object->void[2]->piId;
        

	if ($status=='' || $status=='error') {
           #$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($detail),"refid"=>"");
           $dataarray = array("result"=>"FAIL","result_desc"=>$detail,"refid"=>"");
	}
        else{
	     if ($totalAmt=='' || $totalAmt=='0') {
		   $msg = 'เกิดปัญหาในการติดต่อ Server ต้นทางกรุณาติดต่อผู้ดูแลระบบด้วยค่ะ';
		   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
                   $payment->updatepaymentstatusfail($param_refid); 
             }else{
                   $parameter = "channelName=MERCHANT&command=GSMBILL3&sessionId=".$param_sessionid."&shoppingChannel=MERCHANT&piSeq=".$property_piid."&mobileNo=".MASTERMOBILE."&merchantRef=".$param_refid;
                   $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$modulename,$parameter);
                   #error_log("TOPUPGSM2:request  ".$parameter."\n",3,"/tmp/mylog.txt");  
	           $ch = curl_init(); 
	           curl_setopt($ch, CURLOPT_URL, MPAYURL1 . "/mediator/mpayservice?" . $parameter);
	           curl_setopt($ch, CURLOPT_POST, 1);
	           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   curl_setopt($ch, CURLOPT_HEADER, false); 
                   curl_setopt($ch, CURLOPT_SSLKEY, "mpayweb.keystore"); 
	           curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "changit"); 
	           curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "changit"); 
	           curl_setopt($ch, CURLOPT_SSLVERSION, 1);
	           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	           $server_output = curl_exec ($ch);
	           curl_close ($ch);	

		   $responsedata = $paymentmpay->extractdata(trim($server_output));
                   #error_log("TOPUPGSM2:responsedata ".$responsedata."\n",3,"/tmp/mylog.txt");  
                   $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$modulename,$server_output); 
                   $xml = simplexml_load_string(str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$responsedata));
                   $status = (string) $xml->status;
                   $detail = (string) $xml->detail;
                   $totalAmt = (string) $xml->totalAmt;
                   $responsecode = (string) $xml->responsecode;
                   $sessionId = (string) $xml->sessionId;
                   $inccustfee = (string) $xml->incCustFee;
                   $tranid = (string) $xml->tranId;
                   $tranid2 = (string) $xml->tranId2;
                   $tranamt1 = (string) $xml->tranAmt1;
                   $tranamt2 = (string) $xml->tranAmt2;
                   $pilist = (string) $xml->piList;
      
                    if ($status=='' || $status=='error') {
                      #$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($detail),"refid"=>"");
                      $dataarray = array("result"=>"FAIL","result_desc"=>$detail,"refid"=>"");
                    }
                    else{ 
                      $payment->updatepaymentstatus($param_refid);
                      $payment->usedcardnobyemail($param_email,$tt_total);
                      #$dataarray = array("result"=>"OK","result_desc"=>"","brandid"=>trim($property_brandid),"amount"=>$totalAmt,"sessionid"=>trim($param_sessionid),"email"=>trim($param_email),"msisdn"=>trim($param_msisdn),"refid"=>trim($param_refid));
                      $dataarray = array("result"=>"OK","result_desc"=>"");
                      $memberid = $member->getcodebyemail($param_email); 
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
                     } 
                    }
             }
        }
       }else{
                   $dataarray = array("result"=>"FAIL","result_desc"=>$detail);
                   $payment->updatepaymentstatusfail($param_refid);
        }
       // else{
       //      $msg = 'ไม่พบข้อมูลสำหรับดำเนินการในระบบ';
       //      $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
       // }
}
 
$paymentmpay->updateRecord($tt_msisdn,$tt_price,$param_refid,$param_email,$tranid,$status);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
