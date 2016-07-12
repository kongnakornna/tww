<?php
include '../leone.php';
header('Content-Type: application/json; charset=utf-8');
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
error_log("param_email => ".$param_email."\n",3,"/tmp/mylog.txt");
error_log("param_price => ".$param_price."\n",3,"/tmp/mylog.txt");

if ($param_email=='' || $param_price=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"url"=>"");
}else{

	$dataarray = array("result"=>"OK","result_desc"=>"","url"=>"https://www.easycard.club/payforyou/prepareform.php?price=".$param_price."&email=" . $param_email);
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>
