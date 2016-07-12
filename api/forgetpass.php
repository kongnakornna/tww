<?php
include '../leone.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$member = new member();

if($param_email!=''){
	$haveemail = $member->havemember($param_email);
	if ($haveemail) {
		$newPass = $String->GenKey(5);
		$result = $member->changepassword($param_email,$newPass);
		if ($result) {
			$subject = "เปลี่ยนรหัสผ่าน Easy Card";
			$mailBody = "เรียน ท่านสมาชิก<br/><br/>";
			$mailBody .= "       บริการ Easy Card ได้ทำการเปลี่ยนรหัสผ่านให้ท่านใหม่เป็น '$newPass'<br/><br/>ท่านสามารถ Log in เข้าใช้งานบริการ Easy Card ได้ด้วยรหัสผ่านใหม่นี้ และเพื่อความสะดวกในการใช้รหัสผ่าน หากท่านไม่สะดวกใช้งานรหัสผ่านนี้ เมื่อ Log in เข้าสู่บริการได้แล้ว ท่านสามารถเปลี่ยนรหัสผ่านได้ใหม่ ที่คำสั่ง เปลี่ยนรหัสผ่าน ในเมนู บัญชีผู้ใช้งานของฉัน<br/><br/>ขอบคุณที่ใช้บริการ Easy Card<br/><br/>ฝ่ายดูแลสมาชิก Easy Card";

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
			$headers .= 'From: ฝ่ายดูแลสมาชิก Easy Card <noreply@easycard.club>' . "\r\n";
			mail($param_email, $subject, $mailBody, $headers);

			$msg = "ระบบได้ดำเนินการเปลี่ยนรหัสผ่านให้ท่านชั่วคราวกรุณา ดูรหัสผ่านใหม่ที่อีเมล์ที่ท่านลงทะเบียนค่ะ";
			$dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg));
		}
	}else{
		$msg = "อีเมล์นี้ไม่มีในระบบค่ะ กรุณาใช้อีเมล์อื่น";
        $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}else{
	$msg = "กรุณากรอกอีเมล์ด้วยค่ะ";
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>