<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../../admin/controller/eservice.php';
include './mpay.config.php';
include './mpay.php';
include '../IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');
$paymentmpay = new paymentmpay();
$payment = new payment();
$member = new member();
$eservice = new eservice();
$mpay = new mpay();
$param_ref1 = $_REQUEST['ref1'];
$param_ref2 = $_REQUEST['ref2'];
$param_ref3 = $_REQUEST['ref3'];
$param_ref4 = $_REQUEST['ref4'];
$param_ref5 = $_REQUEST['ref5'];
$param_ref6 = $_REQUEST['ref6'];
$param_reportphone = $_REQUEST['reportphone'];
$param_amount = $_REQUEST['price'];
$param_email = $_REQUEST['email'];
$param_code = $_REQUEST['code'];
$param_duedate = $_REQUEST['duedate'];
$param_refid = $_REQUEST['refid'];
$param_serviceid = $_REQUEST['serviceid'];
$modulename='ConfirmBarcode_pea.php[MPAY]';
#error_log("Check balance process\n",3,"/tmp/mylog.txt");  
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
$mylen = strlen($param_reportphone);
if ($param_ref1=='' || $param_email =='' || $param_refid=='' || $param_reportphone=='' || $mylen != 10) {
	if ($strlen != 10) {
	    $msg = 'หมายเลขโทรศัพท์เพื่อใช้รายงานผลไม่ถูกต้อง';
	else {
		$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	}
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}
else{
        $MASTERMOBILE = '0870182314'; 
        $param_serviceid = $eservice->getserviceid($param_code);  
        $MPAYURL = 'https://saichon-beauty.ais.co.th:8002/mediator/mpayservice'; 
        #$MPAYURL = 'https://buffet-seafood.ais.co.th/mediator/mpayservice'; 
        $mystr = $mpay->general_bill_request_msg($MASTERMOBILE,$param_serviceid,$param_ref1,$param_ref2,$param_ref3,$param_ref4,$param_ref5,$param_ref6,$param_duedate,$param_amount,$param_reportphone);
        $module_name_detail=$modulename.":GENERALBILL"; 
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$mystr);
        $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resultstr);
        $result_array = $mpay->extractresult($resultstr);          
        if ($result_array['status'] == 'ok') {
            $module_name_detail=$modulename."GENERALBILLN2"; 
            $sessionId =  $result_array['sessionId']; 
            $payment->updatepaymenttxnid($param_refid,$sessionId); 
            $mystr = $mpay->general_bill2_request_msg($MASTERMOBILE,$param_serviceid,$sessionId);
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$mystr);
            $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
            $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resultstr);
            $result_array = $mpay->extractresult($resultstr);          
            if ($result_array['status'] == 'ok') {
                $payment->updatepaymentstatus($param_refid); 
                $dataarray = array("result"=>"OK","result_desc"=>"");
           }
           else{
                $payment->updatepaymentstatusfail($param_refid);	
               	$dataarray = array("result"=>"FAIL","result_desc"=>($result_array['detail']));
           }
        } 
        else{
                $payment->updatepaymentstatusfail($param_refid);	
		$dataarray = array("result"=>"FAIL","result_desc"=>($result_array['detail']));
        }
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
