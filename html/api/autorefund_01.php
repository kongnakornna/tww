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
$begintime1=$newtime-2700;
$endtime=$newtime-1200;
#date('Y-m-d H:i:s',$newtime)."\n";
$sdate=date('Y-m-d H:i:s',$begintime);
$sdate1=date('Y-m-d H:i:s',$begintime1);
$edate=date('Y-m-d H:i:s',$endtime);
$result_payment=$payment->getpayment_all($sdate1,$edate);
$result=$payment->gettranlog_cancel($sdate,$edate);
print_r($result);
print_r($result_payment);
$mysize=sizeof($result);
$i=0;
$ch = curl_init();
if ($mysize >= 1) {
while ($i < $mysize) {
if (!array_key_exists($result[$i]['refcode'],$result_payment)) {
    //echo $result[$i]['refcode']."\n"; 
    $myarray = $payment->extractresult($result[$i]['detail']);
    //echo $myarray['txnid']." ".$result[$i]['email']." ".$result[$i]['refcode']."\n"; 
    $myurl="https://easycard.club/api/IPPS/ewalletpaycancel.php?";
    $myurl=$myurl."email=".$result[$i]['email'];
    $myrefid=$result[$i]['refcode'];
    $myurl=$myurl."&refid=".$myrefid;
    if ($myarray['txnid'] != '' )
    {
        $myurl=$myurl."&txnid=".$myarray['txnid'];
        $mytxnid=$myarray['txnid'];
        echo $myurl."\n";
        curl_setopt($ch,CURLOPT_URL,$myurl);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        $response_array = json_decode($response,true);
        //print_r($response_array);
        $myresult=$response_array['resultdata']['result'];
        if ($myresult != 'OK') {
            $myresult = $myresult.":".$response_array['resultdata']['result'];
         }
         $payment->insertrefundlog($myrefid,$mytxnid,$myresult);
     }
}
$i=$i+1;
}
}
curl_close($ch);
?>
