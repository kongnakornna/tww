<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';

header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$modulename='geteservicepayconfirm.php';
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_refcode = (!empty($_REQUEST["refcode"])) ? $_REQUEST["refcode"] : "";
$param_cmd = (!empty($_REQUEST["cmd"])) ? $_REQUEST["cmd"] : "";

$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refcode,$param_email,'FE:REQ',$modulename,$request);

if ($param_refcode=='' || $param_email=='') {
	$msg = '�� parameter �����ú���';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
	$havepayment = $payment->checkpayment($param_refcode,$param_email);
	if ($havepayment) {
        $paymentarray = $payment->getpaymentdata($param_refcode,$param_email);
		for ($b=0;$b<count($paymentarray);$b++) {
			$tt_id = $paymentarray[$b]['p_id'];
			$tt_price = stripslashes($paymentarray[$b]['p_price']);
			$tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
			$tt_productid = stripslashes($paymentarray[$b]['p_productid']);
			$tt_email = stripslashes($paymentarray[$b]['p_email']);
			$tt_total = stripslashes($paymentarray[$b]['p_total']);
		}

                //session_start();
                //get key from ThaiLemon
                //Test key is "111E72E07656B30FE09FE321D056891C"
                //Production key will auto generate every 5 minute
                $ch = curl_init();
                //UAT
                //curl_setopt($ch, CURLOPT_URL, "http://ipayuat.thailemonpay.com/services/getkey.php");
                //Production
                //curl_setopt($ch, CURLOPT_URL, "https://www.thailemonpay.com/services/getkey.php");
                //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //$tlp_key = curl_exec($ch);
               $amount = $tt_price;
               $membercode = $member->getcodefromemail($param_email);
               $username = 'gamecards01';
               #$password = '38DUzrnLmR'; 
               #$password = 'Gamecards01'; 
               $password = '66735926'; 
               #$MYURL1 = 'https://wepay.gotdns.org/client_api.php'; 
               $MYURL1 = 'https://www.wepay.in.th/client_api.php'; 
               $respurl = 'https://easycard.club/api/wePay/respwepay.php';
               $type = 'billpay';

                //Check operator code
                if ($tt_productid == 'ES0004')
                    $pay_code = "AISGSM"; 
                if ($tt_productid == 'ES0011')
                    $pay_code = "DTAC"; 
                if ($tt_productid == 'ES0012')
                    $pay_code = "TRMV"; 
                if ($tt_productid == 'ES0009')
                    $pay_code = "AIRNET"; 
                if ($tt_productid == 'ES0013')
                    $pay_code = "AISFIBRE"; 
                if ($tt_productid == 'ES0014')
                    $pay_code = "TI"; 

               //error_log("pay code => ".$pay_code."\n",3,"/tmp/mylog.txt");
               $myreq = "username=".$username."&password=".$password."&resp_url=".$respurl."&dest_ref=".$param_refcode."&type=".$type."&pay_to_amount=".$tt_price."&pay_to_company=".$pay_code."&pay_to_ref1=".$tt_msisdn;
               error_log("wepay payment request => ".$myreq."\n",3,"/tmp/mylog.txt");
               curl_setopt($ch,CURLOPT_URL,$MYURL1);
               curl_setopt($ch,CURLOPT_POST,1);
               curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq);
               curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); 
               curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
               $resultlogging = $payment->insertlog($param_refcode,$param_email,'BE:REQ',$modulename,$myreq); 
               $server_output = curl_exec($ch); 
               curl_close($ch);
               //error_log("wepay payment server_output => ".$server_output."\n",3,"/tmp/mylog.txt");
               $new_array = $payment->extractresultwepay(trim($server_output));
               //error_log("wepay payment status output => ".$new_array['status']."\n",3,"/tmp/mylog.txt");
               $resultlogging = $payment->insertlog($param_refcode,$param_email,'BE:RES',$modulename,json_encode($new_array)); 
               if ($new_array['status'] == 'SUCCEED') {
                   $dataarray = array("result"=>"OK","result_desc"=>"","tran_id"=>$new_array['TID']);
                   $payment->updatepaymentstatuswepay($param_refcode,$new_array['TID']); 
                   $payment->usedcardnobyemail($tt_email,$tt_total);
               }
               else {
                   $dataarray = array("result"=>"FAIL","result_desc"=>$new_array['description']);
                   $payment->updatepaymentstatusfail($param_refcode); 
               }
                //echo "<hr>";
                $resultlogging = $payment->insertlog($param_refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray))); 
                $bookdata = array ("resultdata"=>$dataarray);
                print json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
      }
 }
?>

