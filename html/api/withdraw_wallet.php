<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$modulename = 'withdraw_wallet.php';
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
#$MYURL1 = "https://test.payforu.com/WebService/payforuservice.svc/APIDirectWithDrawRequest";
$MYURL1 = "https://www.payforu.com/WebService/payforuservice.svc/APIDirectWithDrawRequest";
$refcode = $String->Genkey("12");

$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_price=='' || $param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$havemember = $member->havemember($param_email);
	if ($havemember) {
        $mprice = $member->getprice($param_email);
        $sercharge = $eservice->getecharge('ES9999');
        $totalprice = $param_price + $sercharge;
		if ($mprice<$total_price) {
			$msg = "ยอดเงินของท่าน มีจำนวนไม่พอกับราคาสินค้า หรือบริการที่ท่านต้องการ กรุณาเติมเงินเพิ่มด้วยค่ะ";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}else{
                     $ch = curl_init();
                      $merchantid = "200000006523";
                      #$merchantid = "200000001777";
                      $ref_date = date("Y-m-d H:i:s");
                      $secretcode = "WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq";
                      #$secretcode = "twz123456";
                      #$refcode = $String->Genkey("12");
                      $amount = $param_price;
                      $membercode = $member->getcodefromemail($param_email);
                      $myreq = "merchantid=".$merchantid."&membercode=".$membercode."&ref_id=".$refcode."&amount=".$totalprice."&requestdate=".$ref_date;                       
                      //error_log("withdraw wallet IPPS => ".$myreq."\n",3,"/tmp/mylog.txt"); 
                      $hashstring = $merchantid.$membercode.$refcode.$totalprice.$ref_date.$secretcode;
                      $mdhashstring = md5($hashstring);
                      $myreq = $myreq."&hash=".$mdhashstring;
                      curl_setopt($ch,CURLOPT_URL,$MYURL1);
                      curl_setopt($ch,CURLOPT_POST,1);
                      curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq);
                      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                      #curl_setopt($ch,CURLOPT_POST,1);
                      //error_log("withdraw wallet IPPS hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt");
                      //error_log("withdraw wallet IPPS mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt");
                      $resultlogging = $payment->insertlog($refcode,$param_email,'BE:REQ',$modulename,$String->utf82tis($myreq));
                      $server_output = curl_exec ($ch);
                      curl_close($ch); 
                      //error_log("withdraw wallet IPPS server_output => ".$server_output."\n",3,"/tmp/mylog.txt");
                      if (!is_null($server_output)) {
                          $arrays = explode('&',$server_output);
                          $new_array = array();
                          foreach($arrays as $value)
                          {
                               list($k,$v)=explode('=',$value);
                               $arr_name = substr($k,0,8);
                               $new_array[$arr_name]=$v;
                          } 
                      }
                      $resultlogging = $payment->insertlog($refcode,$param_email,'BE:RES',$modulename,$String->utf82tis(json_encode($new_array)));
                      if ($new_array['status'] == '01')
                      {
                             $memberarray = $member->getdatabyemail($param_email);
                             if (count($memberarray) >0) {
                                 $bankcode = $memberarray[0]['m_bankcode'];   
                                 $bankname = $String->tis2utf8($memberarray[0]['m_bankname']);   
                             } 
                             #$dataarray = array("result"=>"OK","result_desc"=>"","bankcode"=>$bankcode,"bankname"=>$bankname,"price"=>$param_price,"refid"=>$refcode,"txnid"=>$new_array['txnid'],"fee"=>$new_array['fee'],"totalamount"=>$new_array['total_am'],"confirmcode"=>$new_array['comfirmc']);
                             $dataarray = array("result"=>"OK","result_desc"=>"","bankcode"=>$bankcode,"bankname"=>$bankname,"price"=>$param_price,"refid"=>$refcode,"txnid"=>$new_array['txnid'],"fee"=>$sercharge,"totalamount"=>$totalprice,"confirmcode"=>$new_array['comfirmc'],"discount"=>"0");
                             $param_code = 'ES9999'; 
                             $servicename = $eservice->gettitle ($param_code);
                             $partnercode = $eservice->getpaymentmap ($param_code);
                             $resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,$sercharge,$totalprice,$refcode,"",$bankcode,'N',$param_email,$param_email,'','','0'); 
	              }	
	              else{
		           $dataarray = array("result"=>"FAIL","result_desc"=>"Error Code ".$new_array['status']);
	              }
                }
	}else{
		$msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

