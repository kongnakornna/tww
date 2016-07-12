<?php
include '../leone.php';
include '../admin/controller/content.php';
header('Content-Type: application/json; charset=utf-8');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";

$content = new content();

$msgdata = $content->getmessage($param_code);
$msgtitle = stripslashes($msgdata[0]['m_title']);
if ($param_type=='' || $param_type=='text') { 
	$msgdetail = stripslashes($msgdata[0]['m_message']);
	$msgdetail = eregi_replace("&nbsp;","",$msgdetail);
}else{
    $msgdetail = $msgdata[0]['m_message'];
}

$dataarray = array("messagetopic"=>$String->tis2utf8($msgtitle),"messagedata"=>$String->tis2utf8($msgdetail));

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>