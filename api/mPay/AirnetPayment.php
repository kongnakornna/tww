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
$param_sessionId = $_REQUEST['sessionId'];
$param_refId = $_REQUEST['refId'];
$param_email = $_REQUEST['email'];
$param_code = $_REQUEST['code'];
$modulename='AirnetPayment.php[MPAY]';
#error_log("Check balance process\n",3,"/tmp/mylog.txt");  
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refkey,$param_email,'FE:REQ',$modulename,$request);
$mylen = strlen($param_reportphone);
if ($param_refId=='' || $param_sessionId =='' || $param_email=='' ) {
        $msg="Failed";	
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
        $mystr = $mpay->sbn2_request_msg($MASTERMOBILE,$param_refId,$param_sessionId);
        $module_name_detail=$modulename.":SBN2"; 
        $resultlogging = $payment->insertlog($refkey,$param_email,'BE:REQ',$module_name_detail,$mystr);
        $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
        $resultlogging = $payment->insertlog($refkey,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resultstr));
        $result_array = $mpay->extractresult($resultstr);          
        if ($result_array['status'] == 'ok') {
                $dataarray = array("result"=>"OK","result_desc"=>"");
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

