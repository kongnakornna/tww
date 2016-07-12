<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include './mpay.config.php';
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$param_req = $_REQUEST['req'];
$param_refid = $_REQUEST['refid'];
$param_email = $_REQUEST['email'];
$param_msisdn = $_REQUEST['msisdn'];
$param_price = $_REQUEST['price'];

if ($param_req=='' || $param_refid=='' || $param_msisdn=='') {
	$msg = '�� parameter �����ú���';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $ans = $paymentmpay->checkPaymentRecord($param_refid,$param_email);
    error_log("ans => ".$ans."\n",3,"/tmp/mylog.txt");

    if ($ans) {
		$ch = curl_init(); 
		$myreq =  MPAYURL . "/mediator/mpayservice?channelName=MERCHANT&command=One2Call&shoppingChannel=MERCHANT&serviceId=1100150002117314&appName=12callAgent&parameter=12CALL_AGENT_OTHER&mobileNo=".MASTERMOBILE."&payeeMobile=".$param_msisdn."&pin=".MCASHPIN."&amount=" . $param_price;
		
                error_log("myreq => ".$myreq."\n",3,"/tmp/mylog.txt");
                curl_setopt($ch, CURLOPT_URL, MPAYURL . "/mediator/mpayservice?channelName=MERCHANT&command=One2Call&shoppingChannel=MERCHANT&serviceId=1100150002117314&appName=12callAgent&parameter=12CALL_AGENT_OTHER&mobileNo=".MASTERMOBILE."&payeeMobile=".$param_msisdn."&pin=".MCASHPIN."&amount=" . $param_price);
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

		//"https://saichon-beauty.ais.co.th:8002/mediator/mpayservice?channelName=MERCHANT&command=One2Call&shoppingChannel=MERCHANT&serviceId=1100150000000225&appName=12callAgent&parameter=12CALL_AGENT_OTHER&mobileNo=0870182314&payeeMobile=0899833338&pin=0405&amount=10";
		
		$responsedata = $paymentmpay->extractdata(trim($server_output));
                error_log("myres => ".$responsedata."\n",3,"/tmp/mylog.txt");
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
                error_log("data => ".$data."\n",3,"/tmp/mylog.txt");
		
		if ($status=='ok') {
		   if ($processStatus=='N') {
			   $msg = '�Թ㹡����� mCash ����';
			   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		   }else{
			   $dataarray = array("result"=>"OK","result_desc"=>"");
                           error_log("dataarray => ".$dataarray."\n",3,"/tmp/mylog.txt");
		   }
		}else{
		   $dataarray = array("result"=>"FAIL","result_desc"=>$detail);
		}
	}else{
	   $msg = '��辺����������Ѻ���Թ�����к�';
	   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}

$paymentmpay->updateRecord ($param_msisdn,$param_price,$param_refid,$param_email,$tranId,$status);

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
