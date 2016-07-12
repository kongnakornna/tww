<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../../admin/controller/eservice.php';
include './mpay.config.php';
include './mpay.test.php';
include '../IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$payment = new payment();
$member = new member();
$eservice = new eservice();
$mpay = new mpay();
$param_ref1 = $_REQUEST['ref1'];
$param_email = $_REQUEST['email'];
$param_code = $_REQUEST['code'];
$param_reportphone = $_REQUEST['msisdn'];
$modulename='AirnetCheck.php[MPAY]';
#$refkey = $param_refid;
$refkey = $String->GenKey('16');
#error_log("Check balance process\n",3,"/tmp/mylog.txt");  
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refkey,$param_email,'FE:REQ',$modulename,$request);
$mylen = strlen($param_reportphone);
if ($param_ref1=='' || $param_email =='' || $param_reportphone=='' || $mylen != 10 ) {
        if ($mylen != 10) {
            $msg = 'หมายเลขโทรศัพท์เพื่อใช้รายงานผลไม่ถูกต้อง';
        }
        else {
            $msg = 'ส่ง parameter มาไม่ครบค่ะ';
        }	
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}
else{
        #$MASTERMOBILE = '0934145546'; 
        $MASTERMOBILE = '0870182314'; 
        #$MASTERMOBILE = '0870182314'; 
        $param_serviceid = $eservice->getserviceid($param_code);
        $MPAYURL = 'https://saichon-beauty.ais.co.th:8002/mediator/mpayservice'; 
        #$MPAYURL = 'https://mediator.mpay.co.th/mediator/mpayservice'; 
        #$MPAYURL = 'https://buffet-seafood.ais.co.th/mediator/mpayservice'; 
        #$MPAYURL = 'https://buffet-seafood.ais.co.th'; 
        #$mystr = $mpay->calfee_request_msg($MASTERMOBILE,$refkey,$param_serviceid);
        $mystr = $mpay->sbn_request_msg($MASTERMOBILE,$param_serviceid,$refkey,$param_ref1,$param_reportphone);
        $module_name_detail=$modulename.":SBN1"; 
        $resultlogging = $payment->insertlog($refkey,$param_email,'BE:REQ',$module_name_detail,$mystr);
        $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
        $resultlogging = $payment->insertlog($refkey,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resultstr));
        $result_array = $mpay->extractresult($resultstr);          
        if ($result_array['status'] == 'ok') {
            #$resultpayment = $payment->insertipps($partnercode,$param_code,$servicename,'I',$param_price,$sercharge,$totalprice,$refkey,$ref1,$ref2,$ref3,$ref4,'N',$param_email,$param_email,'',$param_reportphone,'0'); 
            $totalprice = $result_array['productAmt'] + $result_array['incCustFee'];
            $dataarray = array("result"=>"OK","result_desc"=>"","refId"=>$refkey,"price"=>$result_array['productAmt'],"sercharge"=>$result_array['incCustFee'],"totalprice"=>$result_array['totalAmt'],"sessionId"=>$result_array['sessionId']);
        } 
        else{
		$dataarray = array("result"=>"FAIL","result_desc"=>$result_array['detail']);
        }
}
$resultlogging = $payment->insertlog($refkey,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
