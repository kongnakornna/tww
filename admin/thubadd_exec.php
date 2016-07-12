<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$startnum = (!empty($_REQUEST["startnum"])) ? $_REQUEST["startnum"] : "";
$endnum = (!empty($_REQUEST["endnum"])) ? $_REQUEST["endnum"] : "";

for ($i=$startnum;$i<=$endnum;$i++) {
    $code = $mainkey . str_pad($i,11,'0',STR_PAD_LEFT) . $marchantid;

	$SqlAdd = "insert into tbl_member_payment (p_cardpayment,p_cardname) values ('".trim($code)."','TWZpay Card')";
	$ResultAdd = $DatabaseClass->DataExecute($SqlAdd);
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("เพิ่มข้อมูลเรียบร้อย","thub_view.php?page=1");
die();
?>