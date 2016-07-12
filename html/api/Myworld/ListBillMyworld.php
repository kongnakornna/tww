<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'myworld.php';
//header('Content-Type: text/html; charset=utf-8');
header('Content-Type: application/json; charset=utf-8');
$payment = new payment();
$member = new member();
$myworld = new myworld();
//$param_req = $_REQUEST['req'];
//$param_refid = $_REQUEST['refid'];
$param_email = $_REQUEST['email'];
$param_msisdn = $_REQUEST['msisdn'];
$param_refid = $String->GenKey('16');
$modulename='ListBillMyworld.php';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
if ($param_msisdn == '') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
elseif (strlen($param_msisdn) <> 10) {
	$msg = 'ËÁÒÂàÅ¢â·ÃÈÑ¾·ìÁ×Í¶×ÍäÁè¶Ù¡µéÍ§';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
        //Login Request
        $reqstr = $myworld->login_request_msg();
        $urlstr = "https://118.172.47.185/bluews/thirdParty/login";
        $module_name_detail=$modulename.":login_request";
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,json_encode($reqstr)); //Logging
        $resstr = $myworld->myworld_submit_req($urlstr,json_encode($reqstr));
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resstr); //Logging
        $result_array = json_decode($resstr,true);        
        //Bill List Request
        if ($result_array['responseCode'] == '1')  {
               $urlstr = "https://118.172.47.185/bluews/postpaid/listUnpaidBills";
               $reqstr = $myworld->listbill_request_msg($result_array['sessionId'],$param_refid,$param_msisdn);
               $module_name_detail=$modulename.":list_unpaid_bills";
               $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,json_encode($reqstr)); //Logging
               $resstr = $myworld->myworld_submit_req($urlstr,json_encode($reqstr));
               $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resstr); //Logging
               $result_array = json_decode($resstr,true);
               if ($result_array['responseCode'] == '1') {
                  $bill_array_size = sizeof($result_array['bills']);
                  $counter = 0;
                  $Invoice_array = "";
                  while ($counter < $bill_array_size) {
                        $temp_array = $result_array['bills'][$counter];
                        $Invoice_array[$counter] = $temp_array;
                        $counter = $counter + 1;
                  } 
                  $dataarray = array("result"=>"OK","result_desc"=>"","transactionId"=>$result_array['transactionId'],"sessionId"=>$result_array['sessionId'],"billDetail"=>$Invoice_array); 
               }
               else {
                   $dataarray = array("result"=>"FAIL","result_desc"=>$result_array['responseMessage']);
               }
        }
        else {
              $dataarray = array("result"=>"FAIL","result_desc"=>$result_array['responseMessage']);
        }
}

//$paymentmpay->updateRecord ($param_msisdn,$param_price,$param_refid,$param_email,$tranId,$status);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
