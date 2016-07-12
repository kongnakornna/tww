<?php
require '../leone.php';
require './controller/partner.php';
require '../class.phpmailer.php';
$partner = new partner();
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_title = (!empty($_REQUEST["title"])) ? $_REQUEST["title"] : "";
$param_fname = (!empty($_REQUEST["fname"])) ? $_REQUEST["fname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";
$param_province = (!empty($_REQUEST["province"])) ? $_REQUEST["province"] : "";
$param_addr1 = (!empty($_REQUEST["addr1"])) ? $_REQUEST["addr1"] : "";
$param_addr2 = (!empty($_REQUEST["addr2"])) ? $_REQUEST["addr2"] : "";
$param_postcode = (!empty($_REQUEST["postcode"])) ? $_REQUEST["postcode"] : "";
$param_mobile = (!empty($_REQUEST["mobile"])) ? $_REQUEST["mobile"] : "";
$param_oldstatus = (!empty($_REQUEST["oldstatus"])) ? $_REQUEST["oldstatus"] : "";
$param_share_app = $_REQUEST["share_app"];
$param_status = (!empty($_REQUEST["status"])) ? $_REQUEST["status"] : "";

if ($param_status=='1') {
    $pncode = $partner->runid();
    $appSql = ",p_code='".$pncode."',p_approve_by='".$_SESSION['TWZUsername']."'";


	$Subject = "EasyCard Partner Approval Alert [" . $param_title . "]";
	$mailbody = "Dear Support Team<br/>";
	$mailbody .= "&nbsp;&nbsp;Now TWZ has already approved new partner as below:<br/><br/>";			  
	$mailbody .= "Merchant ID : ".$pncode."<br/>";
	$mailbody .= "Merchant Name : ".$param_title."<br/><br/>";
	$mailbody .= "Best Regards,<br/>";

	$mail = new phpmailer();
	$mail->IsHTML(true);
	$mail->Priority = 1;
	$mail->From = "service-developer@easycard.club";
	$mail->FromName = "ฝ่ายดูแลผู้ร่วมค้า Easy Card";
	$mail->Username = "service-developer@easycard.club";
	$mail->Password = "service2";
	$mail->Mailer = "smtp";
	$mail->SMTPDebug = false;
	$mail->Subject = $Subject;
	$mail->Body = $mailbody;
	$mail->CharSet = "tis-620";
	$mail->Send();
	$mail->ClearAddresses();			
}else{
   $appSql = "";
}

if ($param_pname=='') {
   $passSql = "";
}else{
   $passSql = ",p_password=MD5('".$param_pname."')";
}

$SqlUpdate = "update tbl_partner set p_title='".addslashes($param_title)."',p_fullname='".addslashes($param_fname)."',p_address1='".addslashes($param_addr1)."',p_address2='".addslashes($param_addr2)."',p_province='".addslashes($param_province)."',p_postcode='".addslashes($param_postcode)."',p_mobile='".addslashes($param_mobile)."',p_share_app='".$param_share_app."',p_status='".$param_status."' $appSql $passSql where p_id='".$param_id."'";
$ResultUpdate = $DatabaseClass->DataExecute($SqlUpdate);
$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","partner_view.php");
die();
?>