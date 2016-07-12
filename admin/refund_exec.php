<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');

$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_txnid = (!empty($_REQUEST["txnid"])) ? $_REQUEST["txnid"] : "";

$ch = curl_init();
$my_url = "https://easycard.club/api/IPPS/ewalletpaycancel.php?";
$my_parameter = "refid=".$param_refid."&email=".$param_email."&txnid=".$param_txnid;
$my_url = $my_url.$my_parameter;

curl_setopt($ch, CURLOPT_URL,$my_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);
curl_close ($ch);
if (strpos ($server_output,'OK') !== false)
$Web->AlertWinGo("ยกเลิกรายการสำเร็จ.","refund_view.php");
else
$Web->AlertWinGo("ยกเลิกรายการไม่สำเร็จ.","refund_view.php");
die();
?>
