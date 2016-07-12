<?php
require '../leone.php';
require './controller/payment.php';
require './controller/member.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$payment = new payment();
$member = new member();
$SqlCheck = "select * from tbl_payment where p_id='".$param_id."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_detail = stripslashes($RowCheck['p_detail']);
		 $db_email = stripslashes($RowCheck['p_email']);
		 $db_ref = stripslashes($RowCheck['p_ref']);
		 $db_ref1 = stripslashes($RowCheck['p_ref1']);
		 $db_ref2 = stripslashes($RowCheck['p_ref2']);
		 $db_price = stripslashes($RowCheck['p_price']);
		 $db_station = stripslashes($RowCheck['p_station']);
	}

	$membercode = $payment->getmembercodefromcardno($db_detail);
	$memberemail = $member->getemailfromcode($membercode);

    $payment->insert ('','','ปรับปรุงรายการ','R',$db_price,'',$db_price,$db_ref,$db_ref1.'-1',$db_ref2,'N',$db_email,$_SESSION['TWZUsername'],$db_station,'','1');
	$payment->updaterefund ($db_ref1);
	$payment->usedcardno ($membercode, $db_price); // ลบจำนวนเงิน
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ปรับปรุงข้อมูลเรียบร้อย","payment_view.php");
die();
?>