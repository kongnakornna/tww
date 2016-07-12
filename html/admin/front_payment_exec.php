<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/bill.php';
require './controller/member.php';
require './controller/payment.php';
header('Content-Type: text/html; charset=tis620');
$bill = new bill();
$member = new member();
$payment = new payment();
$param_cardcode = (!empty($_REQUEST["cardcode"])) ? $_REQUEST["cardcode"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";

$membercode = $payment->getmembercodefromcardno($param_cardcode);
$memberemail = $member->getemailfromcode($membercode);
$memberresult = $payment->checkfirstpaymentandupdate($memberemail);

$ordernumber = $bill->runid();

$payment->insert ('TWZ','',strtoupper($param_cardcode),'A',$param_price,'0',$param_price,$param_ref,$ordernumber,$param_ref2,'N',$memberemail,$_SESSION['TWZUsername'],'TWZ','','1');
$payment->updatecardno ($membercode,$param_price);



$DatabaseClass->DBClose();
?>
<script type="text/javascript">
<!--
	document.location.replace('front_paymentview_form.php?keyword=<?php echo $membercode;?>');
//-->
</script>
