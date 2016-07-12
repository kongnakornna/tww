<?php
require '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
include './IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_memberid = (!empty($_REQUEST["memberid"])) ? $_REQUEST["memberid"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$modulename='direct_transfer_ipps_prepare.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$refcode = $String->GenKey("16"); 
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));
if ($param_memberid=='' || $param_price=='' || $param_code=='' || $param_email=='') {
  	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>($msg));
}else{
	$havemember = $member->havemember($param_email);
        $sercharge = $eservice->getecharge($param_code);       
        if ($havemember) {
        $memberid = $member->getcodebyemail($param_email);
        $reqstr = $ipps->direct_customer_info($memberid); 	
        $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/Customerinfo";
        $module_name_detail=$modulename.":direct_customer_info"; 
        $resultlogging = $payment->insertlog($refcode,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API         
        $resultlogging = $payment->insertlog($refcode,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr);
        $totalprice = $param_price + $sercharge; 
        if ($result_array['account_status'] == 'Active' && ($result_array['result'] == '01' || $result_array['result'] == '00'))
        {
            if ( $totalprice <= $result_array['account_balance']) {
            $totalprice_ipps = $totalprice; // IPPS requirement 
            $reqstr = $ipps->direct_transfer_member_req_msg($memberid,$param_memberid,$refcode,$param_price);
            $module_name_detail=$modulename.":direct_transfer_member_req"; 
            $resultlogging = $payment->insertlog($refcode,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr));
            $urlstr = "https://www.payforu.com/webService/payforuservice.svc/TransferToMember";
            $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Transfer money in IPPS API         
            $resultlogging = $payment->insertlog($refcode,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr));
            $result_array = $ipps->extractresult($resstr);
                 if ($result_array['result'] == '01')  // Status success 
                 {
                       $servicegroup = $eservice->getegroup($param_code); 
                       $servicename = $eservice->gettitle ($param_code);
                       $partnercode = $eservice->getpaymentmap ($param_code);
                       $resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,$result_array['fee'],$totalprice,$refcode,$result_array['txnid'],$param_memberid,'N',$param_email,$param_email,'','','0');
                        
                       $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refcode,"txnid"=>$result_array['txnid'],"price"=>$param_price,"sercharge"=>$result_array['fee'],"totalprice"=>$totalprice,"otp"=>"","discount"=>"0"); 
                 }
                 else
                 {
                      $error_mesg=$payment->geterrormesg('direct_transfer_member.php','IPPS',$result_array['result']);
                      $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));         
                 }  
            }
            else {
 		$msg = "เงินในบัญชีไม่เพียงพอ โปรดตรวจสอบเงินในบัญชีอีกครั้ง";
 		$dataarray = array("result"=>"FAIL","result_desc"=>$msg);
  	    }
	}               
        else {
	       $error_mesg=$payment->geterrormesg('direct_customer_info.php','IPPS',$result_array['result']);
               $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg)); 		
        }
     }
     else {
          $msg = "ไม่พบสมาชิกนี้ในฐานข่้อมูลสมาชิกค่ะ";
          $dataarray = array("result"=>"FAIL","result_desc"=>$msg);
     }
 }
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

