<?php
require '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include '../../admin/controller/wallet.php';
include 'ipps.php';
$ipps = new ipps();
$payment = new payment();
$wallet = new wallet();
$modulename = "getwallet_request.php[IPPS]";
//Check Wallet 
        $servicecheck = array("02","03","04");
        $mydate = date("Ymd"); 
        foreach ($servicecheck as $value) { 
        $reqstr = $ipps->getwallet_request_msg($value,$mydate);
        $urlstr = "http://202.6.20.61/GetMyWalletByType.php";
        $module_name_detail=$modulename.":getwallet_request_bytype";
        $resultlogging = $payment->insertlog('IPPS','IPPS','BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
        $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
        $resultlogging = $payment->insertlog('IPPS','IPPS','BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
        $result_array = $ipps->extractresult($resstr); 
        //Check Wallet Status
        if ($result_array['status'] == '0101')  {
               $retvalue = $wallet->checkwallet($mydate,$value);
               if ($retvalue == -1) {
                   $myret = $wallet->insertwallet($mydate,$value,$result_array['balance']);
               }
               else {
                   $myret = $wallet->updatewallet($mydate,$result_array['balance'],$value);
               }
        } 
        else {
               print "error to get service ".$value."on ".$mydate."\n";
        }      
        }
?>

