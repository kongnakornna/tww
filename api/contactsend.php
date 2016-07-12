<?php
require '../leone.php';
include "../admin/controller/config.php";
header('Content-Type: application/json; charset=utf-8');
$config = new config();
$toemail = $config->getbycode('01');

$param_contactname = (!empty($_REQUEST["contactname"])) ? $_REQUEST["contactname"] : "";
$param_contacttopic = (!empty($_REQUEST["contacttopic"])) ? $_REQUEST["contacttopic"] : "";
$param_contactdetail = (!empty($_REQUEST["contactdetail"])) ? $_REQUEST["contactdetail"] : "";
$param_phone = (!empty($_REQUEST["phone"])) ? $_REQUEST["phone"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

foreach($_REQUEST as $name => $value) {
	$params[$name] = $value;
}

foreach($params as $name => $value) {
	$basedata .= $name . "  :  " . $value . "\n";
}

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
$headers .= 'From: EasyCard Web Site <noreply@easycard.com>' . "\r\n";
mail("preeda.s@sanfarnix.com", "Contact Send", $basedata, $headers);
$param_contactname = $String->utf82tis($param_contactname);
$param_contactemail = $String->utf82tis($param_contactemail);
$param_contacttopic = $String->utf82tis($param_contacttopic);
$param_contactdetail = $String->utf82tis($param_contactdetail);

if ($param_contactname!='' && $param_contactdetail!='') {
	$mailBody = "Customer Name : $param_contactname<br/>";
	$mailBody .= "Customer Email : $contactemail<br/>";
	$mailBody .= "Customer Phone : $contactemail<br/>";
	$mailBody .= "Topic : $param_contacttopic<br/>";
	$mailBody .= "Message : $param_contactdetail<br/>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
	$headers .= 'From: ฝ่ายดูแลสมาชิก Easy Card <service-member@easycard.club>' . "\r\n";
	mail($toemail, $param_contacttopic, $mailBody, $headers);
	$msg = 'ระบบได้ทำการส่งข้อความของท่านไปยังผู้ดูแลเรียบร้อยค่ะ';
	$dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg));
}else{
	$msg = "กรุณาข้อมูลให้ครบตามที่กำหนดด้วยค่ะ";
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>