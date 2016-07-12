<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
include '../admin/controller/bank.php';
include './IPPS/ipps_test.php';
header('Content-Type: application/json; charset=utf-8');
#header('Content-Type: text/plain; charset=utf-8');
$modulename='add_bank_info_ipps.php';
$member = new member();
$eservice = new eservice();
$payment = new payment();
$bank = new bank();
$ipps = new ipps();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_bankid = (!empty($_REQUEST["bankid"])) ? $_REQUEST["bankid"] : "";
$param_bankname= (!empty($_REQUEST["bankname"])) ? $_REQUEST["bankname"] : "";
$param_name= (!empty($_REQUEST["name"])) ? $_REQUEST["name"] : "";
//error_log("create account IPPS name => ".$param_name."\n",3,"/tmp/mylog.txt"); 

$refcode = $String->GenKey("12");
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_email=='' || $param_bankid == "" || $param_bankname == "") {
        //error_log("create account IPPS email => ".$param_email."\n",3,"/tmp/mylog.txt"); 
        //error_log("create account IPPS bankid => ".$param_bankid."\n",3,"/tmp/mylog.txt"); 
        //error_log("create account IPPS bankname => ".$param_bankname."\n",3,"/tmp/mylog.txt"); 
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
	$havemember = $member->havemember($param_email);
	if ($havemember) {
                        $member->changebankbyemail($param_email,$param_bankname,$param_bankid,$String->sqlEscape($String->utf82tis($param_name)));
                        $membercode = $member->getcodefromemail($param_email);	
                        $bankcode = $bank->getcode($param_bankname);	
                        $reqstr = $ipps->direct_update_bank_msg($membercode,$bankcode,$param_name,$param_bankid);
                        $urlstr = "https://test.payforu.com/WebService/payforuservice.svc/UpdateBankAccount";
                        $module_name_detail=$modulename.":direct_update_bank_account";
               		$resultlogging = $payment->insertlog('',$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                	$resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API
                	$resultlogging = $payment->insertlog('',$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                	$result_array = $ipps->extractresult($resstr);
               	        if ($result_array['result'] == '01') { 
                            $dataarray = array("result"=>"OK","result_desc"=>"");
                        } 
                        else {
                            $error_mesg=$payment->geterrormesg('update_bank.php','IPPS',$result_array['status']);
                            $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg)); 
                        } 
        }
	else{
		$msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>"The member doesn't exist");
	}
}
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
