<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$modulename='geteservicepay.php';
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_msisdn = (!empty($_REQUEST["msisdn"])) ? $_REQUEST["msisdn"] : "";
$refcode = $String->GenKey("12");
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$request);

if ($param_code=='' || $param_price=='' || $param_msisdn=='' || $param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$havemember = $member->havemember($param_email);
	if ($havemember) {
        $sercharge = "0";
		$totalprice = $param_price + $sercharge;

        $mprice = $member->getprice($param_email);
		if ($mprice<$totalprice) {
			$msg = "ยอดเงินของท่าน มีจำนวนไม่พอกับราคาสินค้า หรือบริการที่ท่านต้องการ กรุณาเติมเงินเพิ่มด้วยค่ะ";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}else{
			#$refcode = $String->GenKey("12");
			$servicename = $eservice->gettitle ($param_code);
                        $partnercode = $eservice->getpaymentmap ($param_code);
 		        $resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,$sercharge,$totalprice,$refcode,"","",'N',$param_email,$param_email,'',$param_msisdn,'0');
			$dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refcode,"price"=>$param_price,"sercharge"=>$sercharge,"totalprice"=>$totalprice);
		}
	}else{
		$msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

