<?php
require '../leone.php';
require './controller/broadcast.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
//$param_date = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_message = (!empty($_REQUEST["message"])) ? $_REQUEST["message"] : "";
//$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$param_username = $_SESSION['TWZUsername'];
$broadcast = new broadcast();


if ($param_type == '' || $param_message == '' || ( $param_type == '02' && $param_email == '')) {
    $Web->AlertWinGo("บันทึกข้อมูลไม่ครับ","broadcast_view.php");
}
else{
if ($param_type == '01') {
        $to = 'ALL';
}
else {
        $to = $param_email; 
}
$myret = $broadcast->insertbroadcast($param_type,$param_email,$param_username,$param_message);	
$ch = curl_init();
$mytitle = "Eazy Card";
$mysubtitle = "แจ้งข่าว";
$my_url = "https://easycard.club/api/submitgcm.php?";
$my_parameter = "id=".urlencode($to)."&message=".urlencode($param_message)."&title=".urlencode($mytitle)."&subtitle=".urlencode($mysubtitle);
$my_url = $my_url.$my_parameter;

curl_setopt($ch, CURLOPT_URL,$my_url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec ($ch);
curl_close ($ch);
if (strpos ($server_output,'message_id') !== false)
{
	$Web->AlertWinGo("แจ้งข่าวสำเร็จ","broadcast_view.php");
}
else
{
	$Web->AlertWinGo("เแจ้งข่าวไม่สำเร็จ","broadcast_view.php");
}
}
die();
?>
