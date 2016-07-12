<?php
include '../leone.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();

$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

if ($param_email=='') {
	$msg = "ส่ง parameter มาไม่ครบค่ะ"; 
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"pincode"=>"");
}else{
    $havemember = $member->havemember($param_email);
    if ($havemember) {
		if ($param_email=='havemoney1@twz.com') {
			$newpin = "21Dq34";
		}else if ($param_email=='havemoney2@twz.com') {
			$newpin = "12w34r";
		}else if ($param_email=='havemoney3@twz.com') {
			$newpin = "E45tYd";
		}else if ($param_email=='nomoney@twz.com') {
			$newpin = "123456";
		}else if ($param_email=='jgodsonline@gmail.com') {
			$newpin = "my0090";
		}else{
			$newpin = $String->GenPassword(6);
		}
		$member->changepincode($param_email,$newpin);   
		$dataarray = array("result"=>"OK","result_desc"=>"","pincode"=>$newpin);
	}else{
		$msg = "สมาชิกท่านนี้ ไม่ได้รับอนุญาติให้ใช้งานระบบค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"pincode"=>"");
	}
}

$xmldata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($xmldata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>