<?php
include '../../leone.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/member.php';
include './mpay.config.php';

$member = new member();
$eservice = new eservice();
$payment = new payment();
header('Content-Type: application/json; charset=utf-8');
$param_req = $_REQUEST['req'];
$param_email = $_REQUEST['email'];
$param_price = $_REQUEST['price'];
error_log("Check balance process\n",3,"/tmp/mylog.txt");  
if ($param_req=='' || $param_email=='') {
	$msg = 'Êè§ parameter ÁÒäÁè¤Ãº¤èÐ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"refid"=>"");
}else{
        $memberData = $member->getdatabyemail($param_email); 
        error_log("Member balance=>".$memberData.price."\n",3,"/tmp/mylog.txt");  
	if ($memberData.price >= $param_price) {
		$refkey = $String->GenKey('16');
		//$payment->insertCheckBalance ($param_email,$actualbalance,$param_req,$refkey,MASTERMOBILE,$data);
		$dataarray = array("result"=>"OK","result_desc"=>"","refid"=>$refkey);
	}else{
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($detail),"refid"=>"");
	}
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>
