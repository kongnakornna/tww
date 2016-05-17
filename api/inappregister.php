<?php
include '../leone.php';
include '../admin/controller/partner.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$partner = new partner();
$param_pcode = (!empty($_REQUEST["pcode"])) ? $_REQUEST["pcode"] : "";

if ($param_pcode=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"token"=>"");
}else{
    $havepartner = $partner->havepartner($param_pcode);
    if ($havepartner) {
		$tokenkey = $String->GenKey('33');
		$result = $member->insert($param_pcode,$tokenkey);
		$dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg),"token"=>$tokenkey);
	}else{
		$msg = "ผู้ให้บริการ ไม่ได้รับอนุญาติให้บริการค่ะ";
       	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"token"=>"");
	}
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>