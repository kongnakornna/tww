<?php
include "./leone.php";
include "./admin/controller/partner.php";
include "./admin/controller/config.php";
require './class.phpmailer.php';
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_pass = (!empty($_REQUEST["pass"])) ? $_REQUEST["pass"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_address1 = (!empty($_REQUEST["address1"])) ? $_REQUEST["address1"] : "";
$param_postcode = (!empty($_REQUEST["postcode"])) ? $_REQUEST["postcode"] : "";
$param_phone = (!empty($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$param_chkcode = (!empty($_REQUEST["chkcode"])) ? $_REQUEST["chkcode"] : "";

$partner = new partner();

if ($param_chkcode=='' || $param_chkcode!=$_SESSION['TWZSessCode']) {
     $Web->AlertWinGo("รหัสลับที่ท่านกรอกไม่ตรงกับในระบบ รบกวนลองใหม่อีกครั้งค่ะ.","dev_register_form.php");
	 die();
}else{
	 $config = new config();
	 $toemail = $config->getbycode('01');

	 $SqlUpdate = "insert into tbl_partner (p_title,p_fullname,p_password,p_email,p_username,p_address1,p_province,p_postcode,p_mobile,p_createdate,p_status) values ('".addslashes($param_title)."','".addslashes($param_fname)."',MD5('".$param_pass."'),'".addslashes($param_email)."','".addslashes($param_email)."','".addslashes($param_address1)."','".addslashes($param_province)."','".addslashes($param_postcode)."','".addslashes($param_phone)."',now(),'0')";
	 $ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);

	 $Subject = "Partner Register '".$param_title."'";
	 $mailbody = "Dear Easy Card Team<br/>";
	 $mailbody .= "&nbsp;&nbsp;Now we have new partner want to use easy card eWallet please see detail as below:<br/><br/>";

	 $mailbody .= "Partner Name :  ".$param_title."<br/>";
	 $mailbody .= "Email Address : ".$param_email."<br/><br/>";
	 $mailbody .= "Best Regards,<br/>";

	 $mail = new phpmailer();
	 $mail->IsHTML(true);
	 $mail->Priority = 1;
	 $mail->From = "service-developer@easycard.club";
	 $mail->FromName = "ฝ่ายดูแลผู้ร่วมค้า Easy Card";
	 $mail->Username = "service-developer@easycard.club";
	 $mail->Password = "service2";
	 $mail->Mailer = "smtp";
	 $mail->SMTPDebug = false;
	 $mail->Subject = $Subject;
	 $mail->Body = $mailbody;
	 $mail->CharSet = "tis-620";
	 $mail->AddReplyTo($param_email);
	 $mail->AddAddress($toemail);
	 $mail->Send();
	 $mail->ClearAddresses();

	 $Web->AlertWinGo("ระบบได้ดำเนินการจัดส่งข้อความของท่านเรียบร้อยค่ะ","mainpage.php");
	 die();
}
?>