<?php
include '../../leone.php';
include '../../admin/controller/eservice.php';
include '../../admin/controller/payment.php';
include '../../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$MYURL = "http://202.6.20.61/gc_mobile_topup_test.php";
$member = new member();
$eservice = new eservice();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_msisdn = (!empty($_REQUEST["msisdn"])) ? $_REQUEST["msisdn"] : "";
#$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
#$param_ref2 = (!empty($_REQUEST["ref2"])) ? $_REQUEST["ref2"] : "";


if ($param_code=='' || $param_price=='' || $param_ref1=='' || $param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
                $sercharge = "0";
		$totalprice = $param_price + $sercharge;
                $mprice = $member->getprice($param_email);
		if ($mprice<$totalprice) {
			$msg = "ยอดเงินของท่าน มีจำนวนไม่พอกับราคาสินค้า หรือบริการที่ท่านต้องการ กรุณาเติมเงินเพิ่มด้วยค่ะ";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}
                else{
		        $ch = curl_init();	
                        $refcode = $String->GenKey("12");
			$servicename = $eservice->gettitle ($param_code);
                        $partnercode = $eservice->getpaymentmap ($param_code);
                        if ($param_code == 'ES0001')
                        {
                           $service_id = '2';
                        }
                        if ($param_code == 'ES0002') 
                        {
                           $servie_id = '1'; 
                        }
                        $ref_date = date("YmdHis");
                        $channel_type = '01'; 
                        $myreq =  "member_id=TWZ&service_id=".$service_id."&ref_date=".$ref_date."&member_ref=".$refcode."&channel_type=01&invoice=".$refcode."&amount=".$param_price."&mobile_no=".$param_msisdn;
                        error_log("checkepayservice TRUE request URL => ".$myreq."\n",3,"/tmp/mylog.txt"); 
                        $hashstring = "TWZ".$service_id.$ref_date.$refcode."01".$refcode.$param_price.$param_msisdn."TWZ1234";
                        $mdhashstring = md5($hashstring);
                        #$mdhashstring = md5("TWZTMVH6620151221185128484752293162miwappdev@gmail.com010285702876310TWZ1234"); 
                        $myreq = $myreq."&hash=".$mdhashstring;
                        curl_setopt($ch,CURLOPT_URL,$MYURL); 
                        curl_setopt($ch,CURLOPT_POST,1); 
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq); 
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
                        #error_log("checkepayservice TRUE $hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt"); 
                        #error_log("checkepayservice TRUE $mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt"); 
                        $server_output = curl_exec ($ch);    
                        #error_log("checkepayservice TRUE $mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt"); 
                        curl_close($ch);
                        $arrays = explode('&', $server_output);
                        $new_array = array();
                        foreach($arrays as $value)
                      	{
    				list($k,$v)=explode("=",$value);
    				$new_array[$k]=$v;
 			} 
                        #error_log("checkepayservice TRUE array => ".$new_array['status']."\n",3,"/tmp/mylog.txt"); 
                        error_log("checkepayservice TRUE $server output => ".$server_output."\n",3,"/tmp/mylog.txt"); 
 		        if ($new_array['status'] == '0101' || $new_array['status'] == '0102')
                        { 
                         if ($new_array['status'] == '0101') 
                          { 
                             $resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,0,$param_price,$refcode,$new_array['txn_id'],"",'N',$param_email,$param_email,'',$param_ref1,'1');
			     $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refcode,"price"=>$param_price,"sercharge"=>$sercharge,"totalprice"=>$totalprice);
                          }
                         if ($new_array['status'] == '0102') 
                          { 
                             $resultpayment = $payment->insert($partnercode,$param_code,$servicename,'I',$param_price,0,$param_price,$refcode,$new_array['txn_id'],"",'N',$param_email,$param_email,'',$param_ref1,'0');
			     $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$refcode,"price"=>$param_price,"sercharge"=>$sercharge,"totalprice"=>$totalprice);
                          }
                        }
                        else
                        {
		          $dataarray = array("result"=>"FAIL","result_desc"=>$new_array['message']);
                        }	
        	}
	}else{
		$msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

