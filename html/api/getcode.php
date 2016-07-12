<?php
include '../leone.php';
include '../admin/controller/user.php';
header('Content-Type: application/json; charset=utf-8');
$user = new user();

$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_value = (!empty($_REQUEST["value"])) ? $_REQUEST["value"] : "";

if ($param_code=='' || $param_value=='') {
	$msg = "��سҢ��������ú�������˹����¤��";
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $result = $user->getcode($param_code,$param_value);
	if ($result) {
	   $dataarray = array("result"=>"OK","result_desc"=>"");
	}else{
  	   $msg = "��辺���ʷ���ͧ��ä��";
	   $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>