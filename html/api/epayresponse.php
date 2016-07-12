<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: text/html; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_transid = $_POST['TRANSACTIONID'];
$param_status = $_POST['STATUS'];

$paymentarray = $payment->getpaymentdatabyrefcode($param_transid);
for ($b=0;$b<count($paymentarray);$b++) {
	$tt_id = $paymentarray[$b]['p_id'];
	$tt_price = stripslashes($paymentarray[$b]['p_price']);
	$tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
	$tt_productid = stripslashes($paymentarray[$b]['p_productid']);
	$tt_email = stripslashes($paymentarray[$b]['p_email']);
	$tt_total = stripslashes($paymentarray[$b]['p_total']);
}

if (strtoupper(trim($param_status))=='S')) {
   $Status = "OK";
   $StatusDetail = "";
   $payment->updatepaymentstatus($param_transid);
   $payment->usedcardnobyemail($tt_email,$tt_total);
}else if (strtoupper(trim($param_status))=='A')) {
   $Status = "FAIL";
   $StatusDetail = "Your mobile number does not subscribe.";
   $payment->updatepaymentstatusfail($param_transid);
}else if (strtoupper(trim($param_status))=='B')) {
   $Status = "FAIL";
   $StatusDetail = "Your mobile number is incorrect.";
   $payment->updatepaymentstatusfail($param_transid);
}else if (strtoupper(trim($param_status))=='C')) {
   $Status = "FAIL";
   $StatusDetail = "Payment fail.";
   $payment->updatepaymentstatusfail($param_transid);
}else{
   $Status = "FAIL";
   $StatusDetail = "Payment fail.";
   $payment->updatepaymentstatusfail($param_transid);
}

foreach($_POST as $name => $value) {
	$params[$name] = $value;
}

foreach($params as $name => $value) {
	$basedata .= $name . "  :  " . $value . "\n";
}
$param_contactemail = "preeda.s@sanfarnix.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
$headers .= 'From: ฝ่ายดูแลสมาชิก Easy Card <service-member@easycard.club>\r\nReply-to: '.$param_contactemail;
$headers .= 'From: ฝ่ายดูแลสมาชิก Easy Card <service-member@easycard.club>' . "\r\n" .
'Reply-To: ' . $param_contactemail . "\r\n" .
'X-Mailer: PHP/' . phpversion();

mail("preeda.s@sanfarnix.com", "ePay Response", $basedata, $headers);
print "RECEIVED";
?>