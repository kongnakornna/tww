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
$param_barcode1 = $_REQUEST['barcode1'];
$param_barcode2 = $_REQUEST['barcode2'];
$param_email = $_REQUEST['email'];
$param_code = $_REQUEST['code'];
$param_reportphone = $_REQUEST['msisdn'];
$modulename='CheckBarcode.php[MPAY]';
#$refkey = $param_refid;
$refkey = $String->GenKey('16');
#error_log("Check balance process\n",3,"/tmp/mylog.txt");  
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refkey,$param_email,'FE:REQ',$modulename,$request);
$mylen = strlen($param_reportphone);
if ($param_barcode1=='' || $param_barcode2=='' || $param_email =='' || $param_reportphone=='' || $mylen != 10 ) {
        if ($mylen != 10) {
            $msg = '�����Ţ���Ѿ����������§ҹ�����١��ͧ';
        }
        else {
            $msg = '�� parameter �����ú���';
        }	
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}
else{
        $MASTERMOBILE = '0934145546'; 
        $param_serviceid = $eservice->getserviceid($param_code);
        #$MPAYURL = 'https://saichon-beauty.ais.co.th:8002/mediator/mpayservice'; 
        $MPAYURL = 'https://mediator.mpay.co.th/mediator/mpayservice'; 
        #$MPAYURL = 'https://buffet-seafood.ais.co.th/mediator/mpayservice'; 
        #$MPAYURL = 'https://buffet-seafood.ais.co.th'; 
        $mystr = $mpay->calfee_request_msg($MASTERMOBILE,$refkey,$param_serviceid);
        $module_name_detail=$modulename.":CALFEE"; 
        $resultlogging = $payment->insertlog($refkey,$param_email,'BE:REQ',$module_name_detail,$mystr);
        $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
        $resultlogging = $payment->insertlog($refkey,$param_email,'BE:RES',$module_name_detail,$resultstr);
        $result_array = $mpay->extractresult($resultstr);          
        if ($result_array['status'] == 'ok') {
            $fee = $result_array['incCustFee'];
            $mystr = $mpay->check_barcode_request_msg($MASTERMOBILE,$refkey,$param_serviceid,$param_barcode1,$param_barcode2);
            $module_name_detail=$modulename."CheckBarcode"; 
            $resultlogging = $payment->insertlog($refkey,$param_email,'BE:REQ',$module_name_detail,$mystr);
            $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
            $resultlogging = $payment->insertlog($refkey,$param_email,'BE:RES',$module_name_detail,$resultstr);
            $result_array = $mpay->extractresult($resultstr);          
            if ($result_array['status'] == 'ok') {
                $ref1 = $result_array['reference1'];       
                $ref2 = $result_array['reference2'];       
                $ref3 = $result_array['reference3'];       
                $ref4 = $result_array['reference4'];       
                $ref5 = $result_array['reference5'];       
                $ref6 = $result_array['reference6'];       

                $partnercode = $eservice->getpaymentmap ($param_code);
                $servicename = $eservice->gettitle ($param_code); 
                $amount = $result_array['amount'];
                $duedate = $result_array['duedate'];
                $duedateFlag = $result_array['dueDateInputFlag'];
                $mystr = $mpay->general_bill_request_msg($MASTERMOBILE,$param_serviceid,$ref1,$ref2,$ref3,$ref4,$ref5,$ref6,$duedate,$amount,$param_reportphone);
                $module_name_detail=$modulename.":GENERALBILL";
                $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$mystr);
                $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
                $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resultstr);
                $result_array = $mpay->extractresult($resultstr); 
                if ($result_array['status'] == 'ok') {
                $totalprice  = $result_array['amount'] + $fee;
                $param_price = $result_array['amount'];
                $sercharge = $fee;
                $resultpayment = $payment->insertipps($partnercode,$param_code,$servicename,'I',$param_price,$sercharge,$totalprice,$refkey,$ref1,$ref2,$ref3,$ref4,'N',$param_email,$param_email,'',$param_reportphone,'0'); 
                $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refkey,"price"=>$param_price,"sercharge"=>$sercharge,"totalprice"=>$totalprice,"ref1"=>$ref1,"ref2"=>$ref2,"ref3"=>$ref3,"ref4"=>$ref4,"ref5"=>$ref5,"ref6"=>$ref6,"duedate"=>$duedate,"duedateflag"=>$duedateFlag,"sessionid"=>$result_array['sessionId']);
                }
                else {
                $dataarray = array("result"=>"FAIL","result_desc"=>($result_array['detail']));  
                }
           }
           else{
		$dataarray = array("result"=>"FAIL","result_desc"=>$result_array['detail']);
           }
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
