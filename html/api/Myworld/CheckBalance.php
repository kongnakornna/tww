<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../../admin/controller/eservice.php';
include './mpay.config.php';
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$payment = new payment();
$member = new member();
$eservice = new eservice();
$param_req = $_REQUEST['req'];
$param_email = $_REQUEST['email'];
$param_price = $_REQUEST['price'];
$param_msisdn = $_REQUEST['msisdn'];
$param_code = $_REQUEST['code'];
$modulename='checkBalanceGSM.php';
$refkey = $String->GenKey('16');
#error_log("check balance req => ".$param_price."\n",3,"/tmp/mylog.txt");  
#error_log("Check balance process\n",$param_price,"/tmp/mylog.txt");  
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refkey,$param_email,'FE:REQ',$modulename,$request);
if ($param_req=='' || $param_email=='' || $param_price =='' || $param_msisdn =='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}
elseif (strlen($param_msisdn) <> 10) {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}
else{
        $havemember = $member->havemember($param_email);
        if ($havemember) {
         $sercharge = "0";
         $totalprice = $param_price + $sercharge;
         $mprice = $member->getprice($param_email); 
        if ($mprice<>$mprice) { //Disable local wallet	
            $msg = "ยอดเงินของท่าน มีจำนวนไม่พอกับราคาสินค้า หรือบริการที่ท่านต้องการ กรุณาเติมเงินเพิ่มด้วยค่ะ";
            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
        }
        else{ 
           $ch = curl_init(); 
	   $balance_req =  MPAYURL . "/mediator/webservice?cmd=mcash_balance&msisdn=" . MASTERMOBILE_CHK;
           #error_log("check balance req => ".$balance_req."\n",3,"/tmp/mylog.txt");  
	   curl_setopt($ch, CURLOPT_URL, MPAYURL . "/mediator/webservice?cmd=mcash_balance&msisdn=" . MASTERMOBILE_CHK);
           $resultlogging = $payment->insertlog($refkey,$param_email,'BE:REQ',$modulename,$balance_req);
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
           #error_log("check balance res => ".$server_output."\n",3,"/tmp/mylog.txt");  
           $resultlogging = $payment->insertlog($refkey,$param_email,'BE:RES',$modulename,$server_output);
	   $xml = simplexml_load_string($server_output);

           $responsecode = (string) $xml->responsecode;
	   $detail = (string) $xml->detail;
	   $actualbalance = (string) $xml->actualbalance;
	   $maxactualbalance = (string) $xml->maxactualbalance;
	   $terminaltxid = (string) $xml->terminaltxid;

       	   $data = "responsecode : " . $responsecode . "\n";
 	   $data .= "detail : " . $detail . "\n";
	   $data .= "actualbalance : " . $actualbalance . "\n";
	   $data .= "maxactualbalance : " . $maxactualbalance . "\n";
	   $data .= "terminaltxid : " . $terminaltxid . "\n\n";

	   if ($responsecode=='0') {
		$paymentmpay->insertCheckBalance ($param_email,$actualbalance,$param_req,$refkey,MASTERMOBILE,$data);
                $servicename = $eservice->gettitle ($param_code);
                $partnercode = $eservice->getpaymentmap ($param_code);
                $resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,$sercharge,$totalprice,$refkey,"","",'N',$param_email,$param_email,'',$param_msisdn,'0'); 
		#$dataarray = array("result"=>"OK","result_desc"=>"","refid"=>$refkey);
                $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refkey,"price"=>$param_price,"sercharge"=>$sercharge,"totalprice"=>$totalprice);
	   }
           else{
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($detail));
           }
        }
        }
        else{
                $msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
                $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
        }
}
$resultlogging = $payment->insertlog($refkey,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
