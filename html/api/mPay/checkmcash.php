<?php
include '../../leone.php';
include '../../admin/controller/payment_mpay.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/member.php';
include '../../admin/controller/wallet.php';
include './mpay.config.php';
include '../IPPS/ipps.php';
$payment = new payment();
$paymentmpay = new paymentmpay();
$wallet = new wallet();
$ipps = new ipps();
$modulename="mcash_balance.php";

	$ch = curl_init(); 
	$myreq =  MPAYURL . "?cmd=mcash_balance&msisdn=" . MASTERMOBILE_CHK;
        $resultlogging = $payment->insertlog('IPPS','IPPS','BE:REQ',$modulename,$myreq); 	
        curl_setopt($ch, CURLOPT_URL,$myreq); 
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false); 
	curl_setopt($ch, CURLOPT_SSLKEY, "mpayweb.keystore"); 
	curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "0934145546"); 
	curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "X@4rQWYK"); 
	curl_setopt($ch, CURLOPT_SSLVERSION, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$server_output = curl_exec ($ch);
	curl_close ($ch);	
	
        $resultlogging = $payment->insertlog('IPPS','IPPS','BE:RES',$modulename,$server_output);	
      	$xml = simplexml_load_string($server_output);
	$actualbalance = (string) $xml->actualbalance;
	$responsecode = (string) $xml->responsecode;
	$terminaltxid = (string) $xml->terminaltxid;

	if ($responsecode=='0') {
            $mydate = date("Ymd"); 
            $retvalue = $wallet->checkwallet($mydate,'01');
            if ($retvalue == -1) {
                   $myret = $wallet->insertwallet($mydate,'01',$actualbalance);
            }
            else {
                  $myret = $wallet->updatewallet($mydate,$actualbalance,'01');
            } 

            print $actualbalance."\n";
        } 
        else{
            print $responsecode."\n";
        }
?>
