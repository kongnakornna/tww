<?php
require '../leone.php';
header('Content-Type: application/json; charset=utf-8');
require '../admin/controller/member.php';
require '../admin/controller/payment.php';
require '../class.phpmailer.php';
$member = new member();
$payment = new payment();

$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_servicename = (!empty($_REQUEST["servicename"])) ? $_REQUEST["servicename"] : "";
$param_mailto = (!empty($_REQUEST["mailto"])) ? $_REQUEST["mailto"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_paiddate = (!empty($_REQUEST["paiddate"])) ? $_REQUEST["paiddate"] : "";

$havepayment = $payment->checkpayment($param_refid,$param_email);
if ($havepayment) {
    $paymentarray = $payment->getpaymentdata($param_refid,$param_email);
    for ($b=0;$b<count($paymentarray);$b++) {
                        $tt_id = $paymentarray[$b]['p_id'];
                        $tt_price = stripslashes($paymentarray[$b]['p_price']);
                        $tt_msisdn = stripslashes($paymentarray[$b]['p_msisdn']);
                        $tt_productid = stripslashes($paymentarray[$b]['p_productid']);
                        $tt_email = stripslashes($paymentarray[$b]['p_email']);
                        $tt_total = stripslashes($paymentarray[$b]['p_total']);
                        $tt_charge = stripslashes($paymentarray[$b]['p_charge']);
    }
}

$Subject = "เปิดใช้งาน Easy Card";
$mailbody = "<p>เรียนคุณลูกค้า</p>";
$mailbody .= "<p>เอกสารยืนยันการทำรายการจากบริการ <strong>Easy CARD&nbsp;</strong>ฉบับนี้ ถูกส่งโดยอัตโนมัติ โดยแสดงรายละเอียดการทำรายการของท่านผ่านบริการ&nbsp;<strong>Easy CARD </strong>ดังนี้</p>";
$mailbody .=  "<p>รายการชำระ ".$String->utf82tis($param_servicename)."</p>";
$mailbody .=  "<p>เลขที่อ้างอิง (รหัสการชำระเงิน)  ".$param_refid."&nbsp;</p>";
$mailbody .=  "<p>จำนวนเงิน &nbsp;".$tt_total." บาท (รวมค่าธรรมเนียม ".$tt_charge." บาท)&nbsp;</p>";
$mailbody .=  "<p>วันที่ &nbsp; &nbsp; ".$param_paiddate."&nbsp;</p>";
$mailbody .=  "<p>ขอขอบคุณที่ใช้บริการ <strong>Easy CARD</strong> &nbsp;ค่ะ</p>";
$mailbody .=  '<p>อีเมล์ &nbsp; <a href="mailto:theboxes.info@gmail.com">theboxes.info@gmail.com</a></p>';
$mailbody .=  "<p>ศูนย์ลูกค้าสัมพันธ์ &nbsp;02-953-9400 ต่อ 129, 097-099-9922, 097-099-9955 &nbsp;&nbsp;</p>";
$mailbody .=  "<p>(* กรุณาเก็บอีเมล์ฉบับนี้ไว้เป็นหลักฐาน &nbsp; &nbsp;บริษัท เดอะบอกซ์เซส จำกัด 18/1 ถนนเทศบาลสงเคราะห์ แขวงลาดยาว เขตจตุจักร กรุงเทพฯ 10900&nbsp;เป็นตัวแทน mPAY STATION ในการรับชาระค่าสินค้าและบริการต่างๆ)</p>";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
$headers .= 'From: ฝ่ายดูแลสมาชิก Easy Card <service-member@easycard.club>' . "\r\n";
mail($param_mailto, $Subject, $mailbody, $headers);

$msg = "กรุณายืนยันการสมัครสมาชิก อีกครั้งทาง อีเมล์ที่ใช้ลงทะเบียน หากไม่ทำการยืนยัน สถานะสมาชิกจะไม่สมบูรณ์ และจะไม่สามารถใช้บริการได้";
$dataarray = array("result"=>"OK","result_desc"=>"");
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

