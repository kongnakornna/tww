<?php
header('Content-Type: text/html; charset=utf-8');
include './leone.php';
include './admin/controller/payment.php';
$payment = new payment();
$param_responsecode = $_REQUEST['responsecode'];
$param_merchantcode = $_REQUEST['merchantcode'];
$param_ref = $_REQUEST['ref'];
$param_amount = $_REQUEST['amount'];
$param_amount2 = $_REQUEST['amount2'];
$param_refcode = $_REQUEST['refcode'];
$param_refdate = $_REQUEST['refdate'];
$param_remark = $_REQUEST['remark'];

$param_remark = $String->utf82tis($param_remark);

$RemarkData = "responsecode : " . $param_responsecode . "\n";
$RemarkData .= "merchantcode : " . $param_merchantcode . "\n";
$RemarkData .= "ref : " . $param_ref . "\n";
$RemarkData .= "refcode : " . $param_refcode . "\n";
$RemarkData .= "amount : " . $param_amount . "\n";
$RemarkData .= "amount2 : " . $param_amount2 . "\n";
$RemarkData .= "refdate : " . $param_refdate . "\n";
$RemarkData .= "remark : " . $param_remark . "\n";

if (trim(strtolower ($param_remark))=='channel = tesco lotus') {
   $station = "LOTUS";
}else if (trim(strtolower ($param_remark))=='channel = big c') {
   $station = "BIGC";
}else if (trim(strtolower ($param_remark))=='channel = bay') {
   $station = "BAY";
}else if (trim(strtolower ($param_remark))=='channel = scb') {
   $station = "SCB";
}else if (trim(strtolower ($param_remark))=='channel = á¨ëÇ (Dtac)') {
   $station = "DTAC";
}else{
   $station = "";
}

if ($param_responsecode=='01') {
	$status = "1";
}else{
	$status = "0";
}

$b_email = "";
$payment->updatepaymentpayforu($status,$station,$RemarkData,$param_refcode,$param_refdate,$param_ref);
$b_email = $payment->getemailfromref($param_ref);
if (strlen(trim($b_email)) > 0) {
	$dprice = substr ($param_amount,-2);
	$amount = substr ($param_amount,0,-2) . "." . $dprice;
    $payment->updatecardnobyemail($b_email,$amount);
}
print "noted";
?>