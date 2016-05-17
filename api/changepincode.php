<?php
include '../leone.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$member = new member();
if ($param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $havemember = $member->havemember($param_email);
	if ($havemember) {
		$newpin = $String->GenKey("4");

		$result = $member->changepincode($param_email,$newpin);
		$subject = "เปลี่ยน PIN Code Easy Card";

		$mailBody = "เรียน ท่านผู้ใช้บริการ<br/><br/>";
		$mailBody .= "&nbsp;&nbsp;บริการ Easy Card ได้ทำการเปลี่ยน PIN Code ให้ท่านใหม่เป็น ".$newpin."<br/><br/>ท่านสามารถนำ PIN Code ใหม่นี้ ไปใช้ทำการยืนยันเมื่อซื้อสินค้า หรือ บริการ ของ Easy Card ได้ตามที่ท่านต้องการ<br/><br/>";
		$mailBody .= "ขอบคุณที่ใช้บริการ Easy Card<br/>ฝ่ายดูแลสมาชิก Easy Card";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
		$headers .= 'From: ฝ่ายดูแลสมาชิก Easy Card <service-member@easycard.club>' . "\r\n";
		mail($param_email, $subject, $mailBody, $headers);

		if ($result) {
			$dataarray = array("result"=>"OK","result_desc"=>"");
		}else{
		    $msg = "ไม่สามารถเปลี่ยน Pincode ให้ได้ กรุณาติดต่อผู้ดูแลระบบค่ะ";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}
	}else{
		$msg = "อีเมล์นี้ไม่มีในระบบค่ะ";
        $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>