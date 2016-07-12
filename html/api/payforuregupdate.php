<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
include '../admin/controller/bank.php';
#$secretcode = "twz123456";
$secretcode = "WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq";
$member = new member();
$eservice = new eservice();
$payment = new payment();
$bank = new bank();
$modulename='payforuregupdate.php';
$param_trancode = (!empty($_REQUEST["trancode"])) ? $_REQUEST["trancode"] : "";
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";
$param_membercode= (!empty($_REQUEST["membercode"])) ? $_REQUEST["membercode"] : "";
$param_secretcode= (!empty($_REQUEST["secretcode"])) ? $_REQUEST["secretcode"] : "";
$param_amount= (!empty($_REQUEST["amount"])) ? $_REQUEST["amount"] : "";
$param_dateregister= (!empty($_REQUEST["dateregister"])) ? $_REQUEST["dateregister"] : "";
$param_dateactive= (!empty($_REQUEST["dateactive"])) ? $_REQUEST["dateactive"] : "";
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_trancode,$param_membercode,'FE:REQ',$modulename,$request);

if ($param_membercode=='' || $param_status == "") {
        //error_log("Response register from IPPS membercode=> ".$param_membercode."\n",3,"/tmp/mylog.txt"); 
        //error_log("Response register from IPPS status=> ".$param_status."\n",3,"/tmp/mylog.txt"); 
        $resultstr="membercode=&trancode=&status=06&remark=&bankcode=&bank_account_id=&bank_account_name=";
}
else{
	$havemember = $member->havememberbycodeIPPS($param_membercode);
        error_log("Response register from IPPS=> ".$havemember."\n",3,"/tmp/mylog.txt"); 
	if ($havemember) {
                      $memberarray = $member->getdatabycode($param_membercode);	
                      if (count($memberarray) >0) {
                            $bank_code = $memberarray[0]['m_bankcode']; 
                            $bank_id = $memberarray[0]['m_bankid']; 
                            $bank_name = $memberarray[0]['m_bankname']; 
         	            $bank_shortcode = $bank->getcode($bank_id);  
                      }
                      if ($param_secretcode == $param_secretcode && $param_status == '01') { 
                       $timestamp = date("YmdHis");  
                       $sqlAdd = "insert into tbl_payforu_reg_response (trancode,status,membercode,dateregister,dateactive,timestamp) values ('".$param_trancode."','".$param_status."','".$param_membercode."','".$param_dateregister."','".$param_dateactive."','".$timestamp."')";
                       //error_log("Response register from IPPS sqlAdd=> ".$sqlAdd."\n",3,"/tmp/mylog.txt"); 
                       $ResultAdd = $DatabaseClass->DataExecute($sqlAdd);
                       $memberstatus = $member->updatememberstatus_success($param_membercode); 
                       $resultstr="membercode=".$param_membercode."&trancode=".$param_trancode."&status=01&remark=&bank_code=".$bank_shortcode."&bank_account_id=".$bank_code."&bank_account_name=".$String->tis2utf8($bank_name);
                       }        
                      else {
                            $resultstr="membercode=".$param_membercode."&trancode=".$param_trancode."&status=03&remark=&bankcode=&bank_account_id=&bank_account_name=";
                       }
        }
	else{
                $resultstr="membercode=".$param_membercode."&trancode=".$param_trancode."&status=03&remark=member doesn't existed&bankcode=&bank_account_id=&bank_account_name=";
	}
}
//error_log("Response register from IPPS resultstr => ".$resultstr."\n",3,"/tmp/mylog.txt"); 
$resultlogging = $payment->insertlog($param_trancode,$param_membercode,'FE:RES',$modulename,$String->utf82tis($resultstr));
print $resultstr;
?>

