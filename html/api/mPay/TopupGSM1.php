<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include './mpay.config.php';
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$payment = new payment();
$member = new member();
//$param_req = $_REQUEST['req'];
//$param_refid = $_REQUEST['refid'];
$param_email = $_REQUEST['email'];
$param_msisdn = $_REQUEST['msisdn'];
$param_refid = $String->GenKey('16');
$modulename='TOPUPGSM1.php';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
if ($param_msisdn == '') {
	$msg = '�� parameter �����ú���';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $ans = $paymentmpay->checkPaymentRecord($param_refid,$param_email);
   // if ($ans) {
		$parameter = "channelName=MERCHANT&command=GSMBILL&shoppingChannel=MERCHANT&parameter=GSM_AGENT&serviceId=1100150002413259&appName=GSM&mobileNo=".MASTERMOBILE."&payeeMobile=".$param_msisdn."&pin=".MCASHPIN."&merchantRef=" . $param_refid;
                #error_log("TOPUPGSM1:parameter => ".$parameter."\n",3,"/tmp/mylog.txt"); 
	        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$modulename,$parameter);	
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
                #error_log("TOPUPGSM1:responsedata => ".$responsedata."\n",3,"/tmp/mylog.txt"); 
                $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$modulename,$String->utf82tis($server_output));	
         	$xml = simplexml_load_string($responsedata);
		$status = (string) $xml->status;
		$detail = (string) $xml->detail;
		$responsecode = (string) $xml->responsecode;
		$accstatus = (string) $xml->accStatus;
		$invlist = base64_decode((string) $xml->invoiceList);
                #error_log("TOPUPGSM1:responsedata => ".$invlist."\n",3,"/tmp/mylog.txt"); 
                if ($status == 'ok') {
                $xmlinvlist =  simplexml_load_string($invlist);
                $InvoiceValue=""; 
                $arrayindx=0; 
                foreach ($xmlinvlist->array->void as $xmlinv) {
	 	       
                        foreach ($xmlinv->object->void as $xmllinv1) {
                                if ($xmllinv1->attributes() == 'amount') {
                                    $property_amount = $xmllinv1->double;
		                }
                                if ($xmllinv1->attributes() == 'billDate') {
                                    $property_billdate = $xmllinv1->string;
		                }
                                if ($xmllinv1->attributes() == 'billData') {
                                    $property_billdata = $xmllinv1->string;
		                }
                                if ($xmllinv1->attributes() == 'billType') {
                                    $property_billtype = $xmllinv1->string;
		                }
                                if ($xmllinv1->attributes() == 'isPay') {
                                    $property_isPay = $xmllinv1->string;
		                }
                                if ($xmllinv1->attributes() == 'billngAccount') {
                                    $property_billingAccount = $xmllinv1->string;
		                }
                                if ($xmllinv1->attributes() == 'compId') {
                                    $property_seqnum  = $xmllinv1->object->void[0]->long;
	  	                    $property_sessionid = $xmllinv1->object->void[1]->long;
		                } 
                                if ($xmllinv1->attributes() == 'overdue') {
                                    $property_overdue = $xmllinv1->double;
                                }  
                        } 
                        $temp_array=array("billType"=>trim($property_billtype),"seqNum"=>trim($property_seqnum),"amount"=>trim($property_amount),"sessionId"=>trim($property_sessionid),"overDueFee"=>trim($property_overdue),"billDate"=>trim($property_billdate),"billAccount"=>trim($property_billingAccount),"billData"=>trim($property_billdata));
                        $InvoiceValue[$arrayindx] = $temp_array;
                        #error_log("TOPUPGSM1:responsedata => ".$arrayindx."\n",3,"/tmp/mylog.txt"); 
                        $arrayindx = $arrayindx + 1;
                } 
		/*$data = "status : " . $status . "\n";
		$data .= "property_amount : " . $property_amount . "\n";
		$data .= "property_billtype : " . $property_billtype . "\n";
		$data .= "property_seqnum : " . $property_seqnum . "\n";
		$data .= "property_sessionid : " . $property_sessionid . "\n";
		$data .= "property_overdue : " . $property_overdue . "\n\n";
                */
                error_log("TOPUPGSM1:array => ".print_r($InvoiceValue,true)."\n",3,"/tmp/mylog.txt"); 
                }	
               	if ($status=='' || $status=='error') {
                        $dataarray = array("result"=>"FAIL1","result_desc"=>$String->tis2utf8($detail),"refid"=>"");
		}else{
			if ($property_amount=='' || $property_amount=='0') {
			   $msg = '�Դ�ѭ��㹡�õԴ��� Server �鹷ҧ��سҵԴ��ͼ������к����¤��';
			   $dataarray = array("result"=>"FAIL2","result_desc"=>$String->tis2utf8($msg));
			}else{
			   #$dataarray = array("result"=>"OK","result_desc"=>"","email"=>trim($param_email),"msisdn"=>trim($param_msisdn),"refid"=>trim($param_refid),"billtype"=>trim($property_billtype),"seqnum"=>trim($property_seqnum),"amount"=>trim($property_amount),"sessionid"=>trim($property_sessionid),"overdue"=>trim($property_overdue),"billdate"=>trim($property_billdate));
			   $dataarray = array("result"=>"OK","result_desc"=>"","email"=>trim($param_email),"msisdn"=>trim($param_msisdn),"refid"=>trim($param_refid),"InvoiceValue"=>$InvoiceValue);
			}
		}
    //}
}

//$paymentmpay->updateRecord ($param_msisdn,$param_price,$param_refid,$param_email,$tranId,$status);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
