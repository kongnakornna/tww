<?php
include '../leone.php';
include '../admin/controller/member.php';
include '../admin/controller/payment.php';
include './IPPS/ipps.php';
include './barcode-master/includes/BarcodeBase.php';
include './barcode-master/includes/Code128.php';

header('Content-Type: application/json; charset=utf-8');
$member = new member();
$payment = new payment();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_bankid = (!empty($_REQUEST["bankid"])) ? $_REQUEST["bankid"] : "";
$param_bankname = (!empty($_REQUEST["bankname"])) ? $_REQUEST["bankname"] : "";
$modulename = 'topup_bank_channel.php[IPPS]'; 
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));
$membercode = $member->getcodefromemail($param_email);
$memberemail = $param_email;
#$memberresult = $payment->checkfirstpaymentandupdate($memberemail);

        $refcode = $String->GenKey("12");
        //Sync Balance IPPS
        $m_balance_new = ceil($param_price);
        $m_balance_nodecimal = $m_balance_new * 100;
        if ($param_bankid == '1') 
           $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Redirect','DL SCB',$m_balance_new);
        else if ($param_bankid == '2')
           $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Redirect','DL KTB',$m_balance_new);
        else if ($param_bankid == '3')
           $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Redirect','DL BAY',$m_balance_new);
        else if ($param_bankid == '4')
           $reqstr = $ipps->direct_topup_request_msg($membercode,$refcode,'Redirect','DL BBL',$m_balance_new);
        #$urlstr = "https://test.payforu.com/payforuservice.svc/APIDirectTopupRequest";
        $urlstr  = "https://www.payforu.com/webservice/payforuservice.svc/APIDirectTopupRequest";
        $module_name_detail=$modulename.":direct_topup_request";
        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog($refcode,$memberemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);

        if ($result_array['type'] == 'Redirect' && $result_array['status'] == '01') {
            $dataarray = array("result"=>"OK","result_desc"=>"","url"=>$result_array['responsedata']);
        }else{
            $error_mesg=$payment->geterrormesg('payforu_request_topup.php','IPPS',$result_array['status']);
            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg)); 
        }

$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;

?>
