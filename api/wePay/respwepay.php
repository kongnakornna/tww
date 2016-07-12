<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
header('Content-Type: text/html; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";
$param_refid = (!empty($_REQUEST["dest_ref"])) ? $_REQUEST["dest_ref"] : "";
$param_txnid = (!empty($_REQUEST["transaction_id"])) ? $_REQUEST["transaction_id"] : "";
$param_sms = (!empty($_REQUEST["sms"])) ? $_REQUEST["sms"] : "";
$param_operator_txnid = (!empty($_REQUEST["operator_trxnsid"])) ? $_REQUEST["operator_trxnsid"] : "";

error_log("update status wepay status => ".$param_status."\n",3,"/tmp/mylog.txt");
error_log("update status wepay refid => ".$param_refid."\n",3,"/tmp/mylog.txt");
error_log("update status wepay txnid => ".$param_txnid."\n",3,"/tmp/mylog.txt");
error_log("update status wepay sms => ".$param_sms."\n",3,"/tmp/mylog.txt");
error_log("update status wepay oper_txnid => ".$param_operator_txnid."\n",3,"/tmp/mylog.txt");

$paymentarray = $payment->getpaymentdatabyrefcode($param_refid);
for ($b=0;$b<count($paymentarray);$b++) {
	$tt_id = $paymentarray[$b]['p_id'];
	$tt_price = stripslashes($paymentarray[$b]['p_price']);
	$tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
	$tt_productid = stripslashes($paymentarray[$b]['p_productid']);
	$tt_email = stripslashes($paymentarray[$b]['p_email']);
	$tt_total = stripslashes($paymentarray[$b]['p_total']);
}

if ((trim($param_status))=='2') {
   #$payment->updatepaymentstatus($param_id);
   #$payment->usedcardnobyemail($tt_email,$tt_total);
}
else{
   $payment->updatepaymentstatuswepayfail($param_refid,$param_txnid);
   $payment->refundcardnobyemail($tt_email,$tt_total);
}

$respstr = "SUCCEED|".$param_txnid;
print $respstr;
?>
