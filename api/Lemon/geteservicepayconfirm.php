<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include './lib/nusoap.php';

header('Content-Type: application/json; charset=utf-8');
$modulename='geteservicepayconfirm.php';
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_refcode = (!empty($_REQUEST["refcode"])) ? $_REQUEST["refcode"] : "";
$param_cmd = (!empty($_REQUEST["cmd"])) ? $_REQUEST["cmd"] : "";

$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refcode,$param_email,'FE:REQ',$modulename,$request);

if ($param_refcode=='' || $param_email=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
	$havepayment = $payment->checkpayment($param_refcode,$param_email);
	if ($havepayment) {
        $paymentarray = $payment->getpaymentdata($param_refcode,$param_email);
		for ($b=0;$b<count($paymentarray);$b++) {
			$tt_id = $paymentarray[$b]['p_id'];
			$tt_price = stripslashes($paymentarray[$b]['p_price']);
			$tt_ref1 = stripslashes($paymentarray[$b]['p_ref1']);
			$tt_ref2 = stripslashes($paymentarray[$b]['p_ref2']);
			$tt_ref3 = stripslashes($paymentarray[$b]['p_ref3']);
			$tt_ref4 = stripslashes($paymentarray[$b]['p_ref4']);
			$tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
			$tt_productid = stripslashes($paymentarray[$b]['p_productid']);
			$tt_email = stripslashes($paymentarray[$b]['p_email']);
			$tt_total = stripslashes($paymentarray[$b]['p_total']);
		}

                session_start();
                //get key from ThaiLemon
                //Test key is "111E72E07656B30FE09FE321D056891C"
                //Production key will auto generate every 5 minute
                $ch = curl_init();
                //UAT
                //curl_setopt($ch, CURLOPT_URL, "http://ipayuat.thailemonpay.com/services/getkey.php");
                //Production
                curl_setopt($ch, CURLOPT_URL, "https://www.thailemonpay.com/services/getkey.php");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $tlp_key = curl_exec($ch);
               curl_close($ch);

                $pwd = "EC2thailmp";
                //$pwd = "ipayuat123";
                //Encrypt_password by 3 steps
                //1.Use MD5
                //2.Use base64_encode
                //3.Combine with thailemon key
                $password = base64_encode(md5($pwd)) . $tlp_key;

                //Check email and password
                $email = 'theboxes@twz.co.th';
                //$email = 'mepayuat@thailemonpay.com';
                $ref1 = '';
                $ref2 = '';
                $ref3 = '';
                $ref4 = '';
 
                //error_log("product_id => ".$tt_productid."\n",3,"/tmp/mylog.txt");

                //Check operator code
                if ($tt_productid == 'ES0005' || $tt_productid == 'ES0015') {
                    if ($tt_productid == 'ES0005') 
                        $pay_code = "MEA";
                    if ($tt_productid == 'ES0015') 
                        $pay_code = "MEA";
                    $ref1 = $tt_ref1;
                    $ref2 = $tt_ref2;
                }
                
                if ($tt_productid == 'ES0006' || $tt_productid == 'ES0016') {
                    if ($tt_productid == 'ES0006') 
                        $pay_code = "MWA";
                    if ($tt_productid == 'ES0016') 
                        $pay_code = "MWA2";
                    $ref1 = $tt_ref1;
                    $ref2 = $tt_ref2;
                    $ref3 = $tt_ref3;
                    $ref4 = $tt_ref4;
                }
                
                if ($tt_productid == 'ES0007' || $tt_productid == 'ES0017') {
                    if ($tt_productid == 'ES0007') 
                        $pay_code = "PEA";
                    if ($tt_productid == 'ES0017') 
                        $pay_code = "PEA2";
                    $ref1 = $tt_ref1;
                }
                
                if ($tt_productid == 'ES0008' || $tt_productid == 'ES0018') {
                    if ($tt_productid == 'ES0008') 
                        $pay_code = "PWA";
                    if ($tt_productid == 'ES0018') 
                        $pay_code = "PWA2";
                    $ref1 = $tt_ref1;
                    $ref2 = $tt_ref2;
                    $ref3 = $tt_ref3;
                }
 
                //error_log("pay code => ".$pay_code."\n",3,"/tmp/mylog.txt");
                

                 $tran_id = $param_refcode; //Running no.
                //$amount of 12CALL: 10,20,30,40,50,60,70,80,90,100,150,200,300,350,400,500,800
                //$amount of HAPPY: 10,20,30,40,50,60,100,200,300,500,800
                $amount = $tt_price;
                $mobile = $tt_msisdn;

                //Call Web Services
                //UAT : Test by SoapUI.
                //$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
                //$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_bill.php?wsdl", true);
                //$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_bill.php?wsdl", true);
                //$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
                //Production
                //$client = new nusoap_client("https://www.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
                $client = new nusoap_client("https://www.thailemonpay.com/services/plsp_bill.php?wsdl", true);

                $params = array(
                'email' => $email,
                'password' => $password,
                'pay_code' => $pay_code,
                'tran_id' => $tran_id,
                'amount' => $amount,
                'mobile' => $mobile,
                'ref1' => $ref1,
                'ref2' => $ref2,
                'ref3' => $ref3,
                'ref4' => $ref4,
                );
                $resultlogging = $payment->insertlog($param_refcode,$param_email,'BE:REQ',$modulename,json_encode($params));
                $return_arr = $client->call("payment", $params); //Topup
                $resultlogging = $payment->insertlog($param_refcode,$param_email,'BE:RES',$modulename,json_encode($return_arr));
                $status = $return_arr[9];
                $tranId = $return_arr[2];
                $price = $return_arr[3];
                if ($return_arr[9] == 'Error') 
                    $resultdesc = $return_arr[10];
                else
                    $resultdesc = $return_arr[9];
                $sercharge = 0;
                $totalprice = $price;
                if ($return_arr[9] == 'Success') {
                   $dataarray = array("result"=>"OK","result_desc"=>"");
                   $payment->updatepaymentstatus($tran_id); 
                   $payment->usedcardnobyemail($tt_email,$tt_total);
                }
                else {
                   $dataarray = array("result"=>"FAIL","result_desc"=>$resultdesc);
                   $payment->updatepaymentstatusfail($tran_id); 
                }
                //$myret = print_r ($return_arr,true);
                //error_log("return soap => ".$myret."\n",3,"/tmp/mylog.txt");
                //echo "<hr>";
                $resultlogging = $payment->insertlog($param_refcode,$param_email,'FE:RES',$modulename,json_encode($dataarray));
                $bookdata = array ("resultdata"=>$dataarray);
                print json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
      }
 }
?>

