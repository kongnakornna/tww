<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include './mpay.config.php';
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$param_req = $_REQUEST['req'];
$param_refid = $_REQUEST['refid'];
$param_seqnum = $_REQUEST['seqnum'];
$param_sessionid = $_REQUEST['sessionId'];
$param_email = $_REQUEST['email'];
$param_msisdn = $_REQUEST['msisdn'];

if ($param_req=='' || $param_refid=='' || $param_sessionid=='' || $param_msisdn=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $ans = $paymentmpay->checkPaymentRecord($param_refid,$param_email);
 //   if ($ans) {
		$parameter = "channelName=MERCHANT&command=GSMBILL2&sessionId=".$param_sessionid."&shoppingChannel=MERCHANT&billSeq=".$param_seqnum."&mobileNo=".MASTERMOBILE."&merchantRef=".$param_refid;
                error_log("TOPUPGSM2:request  ".$parameter."\n",3,"/tmp/mylog.txt");  
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, MPAYURL . "/mediator/mpayservice?" . $parameter);
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
                error_log("TOPUPGSM2:responsedata ".$responsedata."\n",3,"/tmp/mylog.txt");  
                $xml = simplexml_load_string($responsedata);
                error_log("TOPUPGSM2:xml_parser ".print_r($xml,true)."\n",3,"/tmp/mylog.txt");  
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

		/*$property_brandid = simplexml_load_string($invlist)->array->void->object->void[0]->int;
		$property_mcash = simplexml_load_string($invlist)->array->void->object->void[0]->double;
		$property_custid = simplexml_load_string($invlist)->array->void->object->void[0]->long;
		$property_ivrcode = simplexml_load_string($pilist)->array->void->object->void[2]->string;
		$property_piid = simplexml_load_string($pilist)->array->void->object->void[2]->piId;
                */

		if ($status=='' || $status=='error') {
           $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($detail),"refid"=>"");
		}else{
			if ($totalAmt=='' || $totalAmt=='0') {
			   $msg = 'เกิดปัญหาในการติดต่อ Server ต้นทางกรุณาติดต่อผู้ดูแลระบบด้วยค่ะ';
			   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
			}else{
			   $dataarray = array("result"=>"OK","result_desc"=>"","brandid"=>trim($property_brandid),"amount"=>$totalAmt,"sessionid"=>trim($param_sessionid),"email"=>trim($param_email),"msisdn"=>trim($param_msisdn),"refid"=>trim($param_refid));
			}
		}

//	}else{
//	   $msg = 'ไม่พบข้อมูลสำหรับดำเนินการในระบบ';
//	   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
//	}
}

//$paymentmpay->updateRecord ($param_msisdn,$param_price,$param_refid,$param_email,$tranId,$status);

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
