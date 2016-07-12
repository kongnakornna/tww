<?php
include '../leone.php';
include '../admin/controller/eservice.php.tmp';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$eservice = new eservice();
$payment = new payment();
$modulename='withdraw_wallet_confirm.php';
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$param_txnid = (!empty($_REQUEST["txnid"])) ? $_REQUEST["txnid"] : "";
$param_otp = (!empty($_REQUEST["otp"])) ? $_REQUEST["otp"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$MYURL1 = "https://test.payforu.com/WebService/payforuservice.svc/APIDirectWithDrawConfirmRequest";
#$MYURL1 = "https://www.payforu.com/WebService/payforuservice.svc/APIDirectWithDrawConfirmRequest";


$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_otp=='' || $param_email=='' || $param_txnid=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
	$havemember = $member->havemember($param_email);
	if ($havemember) {
        $mprice = $member->getprice($param_email);
		if ($mprice<$param_price) {
			$msg = "ยอดเงินของท่าน มีจำนวนไม่พอกับราคาสินค้า หรือบริการที่ท่านต้องการ กรุณาเติมเงินเพิ่มด้วยค่ะ";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}else{
                     $ch = curl_init();
                      $merchantid = "200000001777";
                      #$merchantid = "200000006523";
                      $ref_date = date("Y-m-d H:i:s");
                      $secretcode = "twz123456";
                      #$secretcode = "WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq";
                      $membercode = $member->getcodefromemail($param_email);
                      $myreq = "merchantid=".$merchantid."&membercode=".$membercode."&ref_id=".$param_refid."&txnid=".$param_txnid."&confirmcode=".$param_otp."&requestdate=".$ref_date;                       
                      //error_log("withdraw confirm wallet IPPS => ".$myreq."\n",3,"/tmp/mylog.txt"); 
                      $hashstring = $merchantid.$membercode.$param_refid.$param_txnid.$param_otp.$ref_date.$secretcode;
                      $mdhashstring = md5($hashstring);
                      $myreq = $myreq."&hash=".$mdhashstring;
                      curl_setopt($ch,CURLOPT_URL,$MYURL1);
                      curl_setopt($ch,CURLOPT_POST,1);
                      curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq);
                      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                      #curl_setopt($ch,CURLOPT_POST,1);
                      //error_log("withdraw confirm wallet IPPS hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt");
                      //error_log("withdraw confirm wallet IPPS mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt");
                      $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$modulename,$String->utf82tis($myreq)); 
                      $server_output = curl_exec ($ch);
                      curl_close($ch); 
                      //error_log("withdraw confirm wallet IPPS server_output => ".$server_output."\n",3,"/tmp/mylog.txt");
                      $new_array = $payment->extractresult(trim($server_output));
                      //error_log("withdraw wallet IPPS array output => ".$new_array['status']."\n",3,"/tmp/mylog.txt");
                      $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$modulename,$String->utf82tis(json_encode($new_array)));  
                      if ($new_array['status'] == '01')
                      {
                           $payment->usedcardnobyemail($param_email,$param_price); 
                           $payment->updatepaymentstatus($param_refid);  
                           $dataarray = array("result"=>"OK","result_desc"=>"");
	                   $memberid=$member->getcodebyemail($param_email);
                           $discount=$eservice->getediscount_withdraw($memberid,$param_price);
                           $module_name_detail=$modulename.":discount_revenue_req";
                           $urlstr = "https://test.payforu.com/webservice/payforuservice.svc/discountRevenue";
                           $mycode = '04';
                           $reqstr = $ipps->discount_revenue_req_msg($param_refid,$memberid,$discount['discount_result_own'],$discount['memberid_other'],$discount['discount_result_other'],$discount['rev_share_ipps'],$discount['rev_share'],$mycode);
                           $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                           $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Discount Revenue API
                           $resultlogging = $payment->insertlog($param_refid,$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging 
                           $result_array = $ipps->extractresult($resstr);
                           if ($result_array['status'] == '01')  {
         			$mytext = "ส่วนลดจากการทำรายการเอง";
        		        $payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_own'],'0',$discount['discount_result_own'],$param_refid,$tt_total,$tt_charge,'N',$tt_email,'','TWZ','','1');
         			if ($discount['memberid_other'] != '') {
            			 $mytext = "ส่วนลดจากผู้อื่นทำรายการ";
           		         $other_email = $member->getemailbycode($discount['memberid_other']);
             			$payment->insert ($memberid,$tt_productid,$String->sqlEscape($mytext),'D',$discount['discount_result_other'],'0',$discount['discount_result_other'],$param_refid,$tt_total,$tt_charge,'N',$other_email,'','TWZ','','1');
         			}
      		        	}
                      }	
	              else{
                           $payment->updatepaymentstatusfail($param_refid);  
                           $error_mesg=$payment->geterrormesg($modulename,'IPPS',$new_array['status']);
		           $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($error_mesg));
	              }
                }
        else{
		$msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}
$resultlogging = $payment->insertlog($param_refid,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

