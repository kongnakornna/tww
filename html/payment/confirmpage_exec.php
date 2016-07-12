<?php
include '../leone.php';
include '../admin/controller/confirmpin.php';
include '../admin/controller/partner.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
$confirmpin = new confirmpin();
$member = new member();
$partner = new partner();
$payment = new payment();
$param_ref = (!empty($_POST["ref"])) ? $_POST["ref"] : "";
$param_email = (!empty($_POST["inputEmail"])) ? $_POST["inputEmail"] : "";
$param_pin = (!empty($_POST["inputPIN"])) ? $_POST["inputPIN"] : "";
$param_token = (!empty($_POST["token"])) ? $_POST["token"] : "";
$param_sercharge = (!empty($_POST["sercharge"])) ? $_POST["sercharge"] : "";
$param_total = (!empty($_POST["gtotal"])) ? $_POST["gtotal"] : "";

$cmd = "";
$verifyemail = $confirmpin->checkemail($param_email);
if ($verifyemail==false) {
	$status = "FAIL";
	$msg = "ชื่อบัญชีนี้ไม่มีในระบบ Easy Card";
	$cmd = "1";
}else{
	$ansresult = $confirmpin->checkpin($param_pin,$param_email);
	if ($ansresult==false) {
		$status = "FAIL";
		$msg = "รหัสยืนยันการชำระเงินไม่ถูกต้อง กรุณาใช้รหัสที่ถูกต้อง";
		$cmd = "2";
	}else{		
		$result_data = $confirmpin->getdata($param_ref,$param_token);
		if ($result_data[0]!='') {
		   $db_id = $result_data[0]['cp_id'];
		   $db_ref = $result_data[0]['cp_ref'];
		   $db_token = $result_data[0]['cp_token'];
		   $db_partnerid = $result_data[0]['cp_partnerid'];
		   $db_respurl = $result_data[0]['cp_respurl'];
		   $db_backurl = $result_data[0]['cp_backurl'];
		   $db_price = $result_data[0]['cp_price'];
		   $db_appcode = $result_data[0]['cp_appcode'];
		   $db_ref1 = $result_data[0]['cp_ref1'];
		   $db_ref2 = $result_data[0]['cp_ref2'];

		   $confirmpin->updateemail($param_email,number_format($param_sercharge,2,'.',''),number_format($param_total,2,'.',''),$db_id);
		}

		$mprice = $member->getprice($param_email);
		$mcode = $member->getcodebyemail($param_email);
		if ($mprice<$param_total) {
			$msg = "จำนวนเงินในบัญชีของท่านไม่พอชำระค่าสินค้า หรือค่าบริการนี้ กรุณาเติมเงินเข้าบัญชีเพิ่ม ขอบคุณค่ะ";
			$status = "FAIL";
		    $cmd = "3";
		}else{
            $resultpayment = 
			$payment->insert($db_partnerid,'',$db_appcode,'I',number_format($db_price,2,'.',''),number_format($param_sercharge,2,'.',''),number_format($param_total,2,'.',''),$String->tis2utf8($db_ref),$String->tis2utf8($db_ref1),$String->tis2utf8($db_ref2),'N',$param_email,'','','','3');// 3 wait for partner confirm
			$status = "OK";
			$msg = "";
		}	
	}
}
$confirmpin->releasetoken($param_ref,$param_token);

if ($param_email=='havemoney1@twz.com' || $param_email=='havemoney2@twz.com' || $param_email=='havemoney3@twz.com' || $param_email=='nomoney@twz.com' || $param_email=='jgodsonline@gmail.com') {
  //
}else{
    $newpin = $String->GenPassword(6);
	$member->changepincode($param_email,$newpin);
}

if ($status=='OK') {
   Header ("Location: confirmpayment_form.php?r=".$db_ref);
}else{
   Header ("Location: fail.php?cmd=".$cmd."&r=".$param_ref);
}
die();
?>