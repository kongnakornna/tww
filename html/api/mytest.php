<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
include '../admin/controller/bank.php';
#header('Content-Type: application/json; charset=utf-8');
header('Content-Type: text/plain; charset=utf-8');
$MYURL1 = "https://test.payforu.com/WebService/payforuservice.svc/RegisterCheck";
$MYURL2 = "https://test.payforu.com/WebService/payforuservice.svc/APIDirectRegisterURequest";
$member = new member();
$eservice = new eservice();
$payment = new payment();
$bank = new bank();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
                           $membername = $member->getnamefromemail($param_email);	
                           $numspace = substr_count($membername,' ');
                           if ($numspace == 1) {
                               $mynamearray = explode(" ",$membername);
                               $fname = $mynamearray[0];
                               $lname = $mynamearray[1];   
                           }
                           else {
                                $fname = $membername;
                                $lname = " ";
                           }
                           //$myregtemp = $String->tis2utf8($myreg);
                           //$myreg = $myregtemp;   
                           print $String->tis2utf8($membername); 
?>

