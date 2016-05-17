<?php
include "./leone.php";
include "./admin/controller/member.php";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_chkcode = (!empty($_REQUEST["chkcode"])) ? $_REQUEST["chkcode"] : "";
if ($param_chkcode=='' || $param_chkcode!=$_SESSION['TWZSessCode']) {
    $Web->AlertWinGo("รหัสลับที่ท่านกรอกไม่ตรงกับในระบบ รบกวนลองใหม่อีกครั้งค่ะ.","forgetpassword.php");
	die();
}else{
	$member = new member();
	$newPass = $String->GenKey(5);
	$result = $member->changepassword($param_email,$newPass);
	if ($result) {
		$subject = "ลืมรหัสผ่าน";
		$mailBody = "เรียน ท่านสมาชิก<br/><br/>";
		$mailBody .= "    ระบบได้ดำเนินการเปลี่ยนรหัสผ่านใหม่ให้ท่านชั่วคราวเป็น '$newPass' หากท่านสมาชิกสามารถเข้าสู่ระบบได้แล้ว กรุณาเปลี่ยนรหัสผ่านด้วยค่ะ<br/><br/>ขอแสดงความนับถือ";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
		$headers .= 'From: TWZpay Web Site <service-developer@easycard.club>' . "\r\n";
		mail($param_email, $subject, $mailBody, $headers);

		$Web->AlertWinGo("ระบบได้ดำเนินการเปลี่ยนรหัสผ่านให้ท่านชั่วคราวกรุณา ดูรหัสผ่านใหม่ที่อีเมล์ค่ะ","mainpage.php");
	}else{
		$Web->AlertWinGo("ระบบไม่สามารถดำเนินการได้ กรุณาลองใหม่อีกครั้งค่ะ","mainpage.php");
	}
	die();
}
?>