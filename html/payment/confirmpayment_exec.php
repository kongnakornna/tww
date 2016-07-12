<?php
include '../leone.php';
include '../admin/controller/confirmpin.php';
include '../admin/controller/payment.php';
$confirmpin = new confirmpin();
$payment = new payment();
$param_ref = (!empty($_POST["r"])) ? $_POST["r"] : "";

$verifyref = $confirmpin->checkref($param_ref);
if ($verifyref==false) {
	$status = "FAIL";
	$msg = "เลขที่อ้างอิงนี้ไม่มีในระบบ Easy Card";
}else{
	$result_data = $confirmpin->getdetail($param_ref);
	if ($result_data[0]!='') {
	   $db_id = $result_data[0]['cp_id'];
	   $db_ref = $result_data[0]['cp_ref'];
	   $db_email = $result_data[0]['cp_email'];
	   $db_token = $result_data[0]['cp_token'];
	   $db_partnerid = $result_data[0]['cp_partnerid'];
	   $db_respurl = $result_data[0]['cp_respurl'];
	   $db_backurl = $result_data[0]['cp_backurl'];
	   $db_price = $result_data[0]['cp_price'];
	   $db_total = $result_data[0]['cp_total'];
	   $db_appcode = $result_data[0]['cp_appcode'];
	   $db_ref1 = $result_data[0]['cp_ref1'];
	   $db_ref2 = $result_data[0]['cp_ref2'];	 
	}
}

$status = "OK";
$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,$db_respurl . "?status=".$status."&ref=".$db_ref1 ."&msg=".urlencode($msg));
curl_setopt($ch, CURLOPT_HTTPGET, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$server_output = curl_exec ($ch);
curl_close ($ch);	 

$confirmpin->update($param_ref,$db_token,$db_backurl . "?status=".$status."&ref=".$param_ref ."&msg=".$msg);

$mainurlresp = $db_respurl . "?" . "status=".$status."&ref=".$db_ref1 ."&msg=".urlencode($msg);

$server_output = strtoupper(trim($server_output));

$resp = $confirmpin->updaterespanswer($server_output,$mainurlresp,$param_ref);

if ($server_output=='OK') {
   $payment->updatepaymentstatus($db_ref);
   $payment->usedcardnobyemail($db_email,$db_total);
}

if (strlen($db_backurl) > 10) {
   $backurl = $db_backurl;
}else{
   $backurl = "https://www.easycard.club/payment/thankyou.php";
}
Header ("Location: " . $backurl . "?status=".$status);
die();
?>