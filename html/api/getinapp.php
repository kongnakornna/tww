<?php
include '../leone.php';
include '../admin/controller/confirmpin.php';
include '../admin/controller/partner.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$confirmpin = new confirmpin();
$member = new member();
$partner = new partner();
$payment = new payment();
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_token = (!empty($_REQUEST["token"])) ? $_REQUEST["token"] : "";
$param_appcode = (!empty($_REQUEST["appcode"])) ? $_REQUEST["appcode"] : "";
$param_pcode = (!empty($_REQUEST["pcode"])) ? $_REQUEST["pcode"] : "";
$param_backurl = (!empty($_REQUEST["backurl"])) ? $_REQUEST["backurl"] : "";
$param_respurl = (!empty($_REQUEST["respurl"])) ? $_REQUEST["respurl"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$param_ref2 = (!empty($_REQUEST["ref2"])) ? $_REQUEST["ref2"] : "";

$data = "price : " . $_REQUEST["price"] . "\n";
$data .= "token : " . $_REQUEST["token"] . "\n";
$data .= "appcode : " . $_REQUEST["appcode"] . "\n";
$data .= "pcode : " . $_REQUEST["pcode"] . "\n";
$data .= "respurl : " . $_REQUEST["respurl"] . "\n";
$data .= "backurl : " . $_REQUEST["backurl"] . "\n";
$data .= "ref1 : " . $_REQUEST["ref1"] . "\n";
$data .= "ref2 : " . $_REQUEST["ref2"] . "\n";

if ($param_pcode=='' || $param_price=='' || $param_token=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $havetoken = $member->checktoken($param_pcode,$param_token);
	if ($havetoken) {
		$havepartner = $partner->havepartner($param_pcode);
		if ($havepartner) {
			$key = $String->GenPassword(21);
            $apptitle = $param_appcode;

			$confirmpin->insert ('',$key,$param_token,$param_pcode,$param_price,$param_backurl,$param_respurl,$apptitle,$param_ref1,$param_ref2,$data);

			$newkey = base64_encode ($key . "," . $param_token);
			$mainurl = "https://www.easycard.club/payment/confirmpage.php?r=".$newkey;


			$dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg),"confirm_url"=>$mainurl);
		}else{
			$msg = "คุณไม่ได้รับอนุญาติให้บริการค่ะ";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"confirm_url"=>"");
		}
	}else{
		$msg = "คุณไม่ได้รับอนุญาติให้บริการค่ะ เนื่องจากยังไม่ได้ลงทะเบียน";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"confirm_url"=>"");
	}
}

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>