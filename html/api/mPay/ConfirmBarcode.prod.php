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
$ipps = new ipps();
$param_refid = $_REQUEST['refid'];
$param_code = $_REQUEST['code'];
$param_sessionid = $_REQUEST['sessionid'];
$param_email = $_REQUEST['email'];
$modulename='ConfirmBarcode.php[MPAY]';
#error_log("Check balance process\n",3,"/tmp/mylog.txt");  
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$request);
if ($param_refid=='' || $param_code =='' || $param_sessionid=='') {
        $msg = '�� parameter �����ú���';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}
else{
        $MASTERMOBILE = '0934145546';
        $param_serviceid = $eservice->getserviceid($param_code);
        #$MPAYURL = 'https://saichon-beauty.ais.co.th:8002/mediator/mpayservice'; 
        $MPAYURL = 'https://mediator.mpay.co.th/mediator/mpayservice'; 
        $module_name_detail=$modulename."GENERALBILLN2"; 
        $payment->updatepaymenttxnid($param_refid,$param_sessionId); 
        $mystr = $mpay->general_bill2_request_msg($MASTERMOBILE,$param_serviceid,$param_sessionid);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$mystr);
        $resultstr = $mpay->mpay_submit_req($MPAYURL,$mystr);
        $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$resultstr);
        $result_array = $mpay->extractresult($resultstr);          
            if ($result_array['status'] == 'ok') {
                $payment->updatepaymentstatus($param_refid); 
                $dataarray = array("result"=>"OK","result_desc"=>"");
                $havepayment = $payment->checkpayment($param_refid,$param_email);
                if ($havepayment) {
                    $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
                    for ($b=0;$b<count($paymentarray);$b++) {
           	    $tt_price = stripslashes($paymentarray[$b]['p_price']);
           	    $tt_total = stripslashes($paymentarray[$b]['p_total']);
           	    $tt_charge = stripslashes($paymentarray[$b]['p_charge']);
           	    $tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
                    }
                }
                $memberid = $member->getcodebyemail($param_email); 
                $discount = $eservice->getediscount($param_code,$memberid,$tt_price);
                $module_name_detail=$modulename.":discount_revenue_req";
                           $urlstr = "https://www.payforu.com/webservice/payforuservice.svc/discountRevenue";
                           $reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],'01'); 
                           $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                           $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Discount Revenue API
                           $resultlogging = $payment->insertlog($param_refid,$tt_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                           $result_array = $ipps->extractresult($resstr);
                           if ($result_array['status'] == '01')  {
                               $mytext = "��ǹŴ�ҡ��÷���¡���ͧ";
                               $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_own'],'0',$discount['discount_result_own'],$param_refid,$tt_total,$tt_charge,'N',$tt_email,'','TWZ',$tt_msisdn,'1'); 
                             if ($discount['memberid_other'] != '') {
                               $mytext = "��ǹŴ�ҡ�����蹷���¡��";
                               $other_email = $member->getemailbycode($discount['memberid_other']); 
                               #$payment->insert ($discount['memberid_other'],$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ','','1');
                               $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ',$tt_msisdn,'1');
                             } 
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
