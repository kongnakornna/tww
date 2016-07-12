<?php
include '../leone.php';
include '../admin/controller/payment.php';
$payment = new payment();
$t=time();
#echo $t."\n";
#date("U",$t)."\n";
#echo (int)($t/600)."\n";
$divtime=(int)($t/600);
echo ($divtime*600)."\n";
$newtime=$divtime*600;
$begintime=$newtime-2400;
$endtime=$newtime-1200;
#date('Y-m-d H:i:s',$newtime)."\n";
$sdate=date('Y-m-d H:i:s',$begintime);
$edate=date('Y-m-d H:i:s',$endtime);
$result=$payment->getpaymentwait_cancel($sdate,$edate);
print_r($result);
$mysize=sizeof($result);
$i=0;
$ch = curl_init();
if ($mysize >= 1) {
while ($i < $mysize) {
$myurl="https://easycard.club/api/IPPS/ewalletpaycancel.php?";
$myurl=$myurl."email=".$result[$i]['p_email'];
$myrefid=$result[$i]['p_ref'];
$myurl=$myurl."&refid=".$myrefid;
if ($result[$i]['p_txnid_wallet'] != '' )
{
   $myurl=$myurl."&txnid=".$result[$i]['p_txnid_wallet'];
   $mytxnid=$result[$i]['p_txnid_wallet'];
}
else  {
   $myurl=$myurl."&txnid=".$result[$i]['p_ref1'];
   $mytxnid=$result[$i]['p_ref1'];
}
echo $myurl."\n";
curl_setopt($ch,CURLOPT_URL,$myurl);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_HEADER, 0);
$response = curl_exec($ch);
$response_array = json_decode($response,true);
print_r($response_array);
$myresult=$response_array['resultdata']['result'];
if ($myresult != 'OK') {
    $myresult = $myresult.":".$response_array['resultdata']['result'];
}
$payment->insertrefundlog($myrefid,$mytxnid,$myresult);
$i=$i+1;
}
}
curl_close($ch);
?>
