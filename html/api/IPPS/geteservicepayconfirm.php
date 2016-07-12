<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';

header('Content-Type: application/json; charset=utf-8');
$MYURL = "http://202.6.20.61/gc_mobile_billpayment_test.php";
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_refcode = (!empty($_REQUEST["refcode"])) ? $_REQUEST["refcode"] : "";
$param_cmd = (!empty($_REQUEST["cmd"])) ? $_REQUEST["cmd"] : "";

if ($param_refcode=='' || $param_email=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èĞ';
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
			$tt_txnid = stripslashes($paymentarray[$b]['p_ref1']);
		}

                $ch = curl_init();
                //$servicename = $eservice->gettitle ($param_code);
                //$partnercode = $eservice->getpaymentmap ($param_code);
                $service_id = "TMVH66";
                $ref_date = date("YmdHis");
                $myreq =  "member_id=TWZ&service_id=".$service_id."&ref_date=".$ref_date."&member_ref=".$param_refcode."&txn_id=".$tt_txnid;
                error_log("IPPS confirm transaction => ".$myreq."\n",3,"/tmp/mylog.txt");
                $tran_id = $param_refcode; //Running no.
                //$amount of 12CALL: 10,20,30,40,50,60,70,80,90,100,150,200,300,350,400,500,800
                //$amount of HAPPY: 10,20,30,40,50,60,100,200,300,500,800
                error_log("checkepayserviceconfirm TRUE request URL => ".$myreq."\n",3,"/tmp/mylog.txt");
                $hashstring = "TWZ".$service_id.$ref_date.$param_refcode.$tt_txnid."TWZ1234";
                $mdhashstring = md5($hashstring); 
                $myreq = $myreq."&hash=".$mdhashstring;
                curl_setopt($ch,CURLOPT_URL,$MYURL);
                curl_setopt($ch,CURLOPT_POST,1);
                curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq); 
                error_log("checkepayserviceconfirm TRUE $hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt");
                error_log("checkepayserviceconfirm TRUE $mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt");
                $server_output = curl_exec ($ch);
                curl_close($ch);         
                if (1==1) {
                   $dataarray = array("result"=>"OK","result_desc"=>"");
                  //$payment->updatepaymentstatus($tran_id); 
                   //$payment->usedcardnobyemail($tt_email,$tt_total);
                }
                else {
                   $dataarray = array("result"=>"FAIL","result_desc"=>$resultdesc);
                  //$payment->updatepaymentstatusfail($tran_id); 
                }
                $bookdata = array ("resultdata"=>$dataarray);
                print json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
      }
 }
?>

