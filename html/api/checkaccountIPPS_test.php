<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$MYURL = "https://test.payforu.com/WebService/payforuservice.svc/CustomerInfo";
#$MYURL = "https://www.payforu.com/WebService/payforuservice.svc/CustomerInfo";
$modulename='checkaccountIPPS.php';
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

$refcode = $String->GenKey("12");
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$request);

if ($param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
	$havemember = $member->havemember($param_email);
	if ($havemember) {
                        $membercode = $member->getcodefromemail($param_email);	
         	        $ch = curl_init();	
                        #$merchantid = "200000006523"; 
                        $merchantid = "200000001777"; 
                        $ref_date = date("YmdHis");
                        #$secretcode = "WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq";
                        $secretcode = "twz123456";
                        $myreq =  "merchantid=".$merchantid."&customer_id=".$membercode."&requestdate=".$ref_date;
                        //error_log("check account IPPS => ".$myreq."\n",3,"/tmp/mylog.txt"); 
                        $hashstring = $merchantid.$membercode.$ref_date.$secretcode;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        curl_setopt($ch,CURLOPT_URL,$MYURL); 
                        curl_setopt($ch,CURLOPT_POST,1); 
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq); 
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                        #curl_setopt($ch,CURLOPT_POST,1); 
                        //error_log("check account IPPS hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt"); 
                        //error_log("check account IPPS mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt"); 
                        $resultlogging = $payment->insertlog($refcode,$param_email,'BE:REQ',$modulename,$myreq);
                        $server_output = curl_exec ($ch);    
                        curl_close($ch);
                        //error_log("check account IPPS server_output => ".$server_output."\n",3,"/tmp/mylog.txt"); 
 		        $new_array = $payment->extractresult(trim($server_output)); 
                        $resultlogging = $payment->insertlog($refcode,$param_email,'BE:RES',$modulename,json_encode($new_array));
                        if ($new_array['result'] == '01')
                        { 
                          if ($new_array['bank_account_name'] == '' || $new_array['bank_account_no'] == '')
	  		      $dataarray = array("result"=>"OK1","result_desc"=>"");
                          else 
	  		      $dataarray = array("result"=>"OK","result_desc"=>"");
                        }
                        else
                        {
		          $dataarray = array("result"=>"FAIL","result_desc"=>$new_array['result']);
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
?>

