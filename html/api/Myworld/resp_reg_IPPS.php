<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
include 'ipps.php';
header('Content-Type: text/html; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$ipps = new ipps();
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";
$param_refid = (!empty($_REQUEST["trancode"])) ? $_REQUEST["trancode"] : "";
$param_secret = (!empty($_REQUEST["secretcode"])) ? $_REQUEST["secretcode"] : "";
$param_amount = (!empty($_REQUEST["amount"])) ? $_REQUEST["amount"] : "";
$param_datereg = (!empty($_REQUEST["dateregister"])) ? $_REQUEST["dateregister"] : "";
$param_dateact = (!empty($_REQUEST["dateactive"])) ? $_REQUEST["dateactive"] : "";
$param_memberid = (!empty($_REQUEST["membercode"])) ? $_REQUEST["membercode"] : "";
$modulename='resp_reg_IPPS.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,'IPPS','FE:REQ',$modulename,$String->utf82tis($request));
if ($param_status == '' || $param_refid == '' || $param_secret== '' || $param_memberid == '') {
    $respstr = "membercode=".$param_memberid."&trancode=".$param_refid."&status=06&remark=Some key data missing";
}
else {
    foundmember = $member->havememberbycodeIPPS($param_memberid);
    if ($foundmember) {
        if ($param_status == '01') {
            $result = $member->updatememberstatus_success($param_memberid);
        } 
        else {
            $result = $member->updatememberstatus_fail($param_memberid);
        }
     $respstr = "membercode=".$param_memberid."&trancode=".$param_refid."&status=01&remark=Updated member status succesfully";
    }
    else { 
     $respstr = "membercode=".$param_memberid."&trancode=".$param_refid."&status=03&remark=No member found in Easy Card system";
    }
}

$resultlogging = $payment->insertlog($param_refid,'IPPS','FE:RES',$modulename,$String->utf82tis($respstr));
print $respstr;
?>
