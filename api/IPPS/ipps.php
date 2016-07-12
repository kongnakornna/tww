<?php
Class IPPS extends String{
    function ewallet_deduct_request_msg($memberid='',$refid='',$productlist='',$amount='') {
                        $refdate = date("Y-m-d");
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq'; 
                        $amount = $amount * 100;
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&refid=".$refid."&refdate=".$refdate."&productlist=".$productlist."&amount=".$amount;
                        $hashstring = $merchantid.$memberid.$refid.$refdate.$productlist.$amount.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
     }
    function ewallet_deduct_request_confirm_msg($memberid='',$txnid='',$otp='') {
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&txnid=".$txnid."&confirmcode=".$otp;
                        $hashstring = $merchantid.$memberid.$txnid.$otp.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
    } 
    function ewallet_deduct_refund_msg($memberid='',$refid='',$txnid='') {
                        $refdate = date("Y-m-d");
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&refid=".$refid."&refdate=".$refdate."&txn_id=".$txnid;
                        $hashstring = $merchantid.$memberid.$refid.$refdate.$txnid.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
    }
    function ewallet_deduct_refund_confirm_msg($memberid='',$txnid='') {
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&txn_id=".$txnid;
                        $hashstring = $merchantid.$memberid.$txnid.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
    } 
    function direct_customer_info($memberid='') {
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $refdate = date("Y-m-d H:i:s");  
                        $myreq =  "merchantid=".$merchantid."&customer_id=".$memberid."&requestdate=".$refdate;
                        $hashstring = $merchantid.$memberid.$refdate.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
    } 
   
    function direct_customer_register_prepare($email='',$memberid='',$msisdn='') {
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&email=".$email."&mobileno=".$msisdn."&membercode=".$memberid;
                        $hashstring = $merchantid.$email.$msisdn.$memberid.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
    }

    function direct_customer_register_confirm($email='',$memberid='',$msisdn='',$firstname='',$lastname='',$personalid='') {
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&email=".$email."&mobileno=".$msisdn."&firstname=".$firstname."&lastname=".$lastname."&personalid=".$personalid."&optional_email=&membercode=".$memberid;
                        $hashstring = $merchantid.$email.$msisdn.$firstname.$lastname.$personalid.$optional_email.$memberid.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
    }

    function mobile_topup_request_msg($memberid='',$service_id='',$refid='',$amount='',$msisdn='') {
                        $refdate = date("YmdHis");
                        //$memberid = 'TWZ';
                        //$memberid_secret = 'TWZ1234'; 
                        $memberid = 'TheBoxes(TWZ)';
                        $memberid_secret = 'SCVBMK'; 
                        $channel_type = '01'; 
                        $myreq =  "member_id=".$memberid."&service_id=".$service_id."&ref_date=".$refdate."&member_ref=".$refid."&channel_type=".$channel_type."&invoice=".$refid."&amount=".$amount."&mobile_no=".$msisdn;
                        $hashstring = $memberid.$service_id.$refdate.$refid.$channel_type.$refid.$amount.$msisdn.$memberid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
     }
   function bill_payment_request_msg($serviceid='',$refid='',$email='',$paymenttype='',$ref1='',$ref2='',$ref3='',$ref4='',$ref5='',$ref6='',$ref7='',$ref8='',$amount='') {
                        $refdate = date("YmdHis");
                        $mode='01';
                        //$memberid = 'TWZ';
                        //$memberid_secret = 'TWZ1234'; 
                        $memberid = 'TheBoxes(TWZ)';
                        $memberid_secret = 'SCVBMK'; 
                        $channeltype = '02'; 
                        $myreq =  "member_id=".$memberid."&service_id=".$serviceid."&ref_date=".$refdate."&member_ref=".$refid."&customer_contact=".$email."&channel_type=".$channeltype."&payment_type=".$paymenttype."&ref1=".$ref1."&ref2=".$ref2."&ref3=".$ref3."&ref4=".$ref4."&ref5=".$ref5."&ref6=".$ref6."&ref7=".$ref7."&ref8=".$ref8."&amount=".$amount."&mode=".$mode;
                        $hashstring = $memberid.$serviceid.$refdate.$refid.$email.$channeltype.$paymenttype.$ref1.$ref2.$ref3.$ref4.$ref5.$ref6.$ref7.$ref8.$amount.$memberid_secret;
                        error_log("myhashq => ".$hashstring."\n",3,"/tmp/mylog.txt");
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       
     
   function bill_payment_verify_msg($serviceid='',$refid='',$email='',$paymenttype='',$ref1='',$ref2='',$ref3='',$ref4='',$ref5='',$ref6='',$ref7='',$ref8='',$txnid='',$amount='') {
                        $refdate = date("YmdHis");
                        $mode='02';
                        //$memberid = 'TWZ';
                       // $memberid_secret = 'TWZ1234'; 
                        $memberid = 'TheBoxes(TWZ)';
                        $memberid_secret = 'SCVBMK'; 
                        $channeltype = '02'; 
                       $myreq =  "member_id=".$memberid."&service_id=".$serviceid."&ref_date=".$refdate."&member_ref=".$refid."&customer_contact=".$email."&channel_type=".$channeltype."&payment_type=".$paymenttype."&ref1=".$ref1."&ref2=".$ref2."&ref3=".$ref3."&ref4=".$ref4."&ref5=".$ref5."&ref6=".$ref6."&ref7=".$ref7."&ref8=".$ref8."&txn_id=".$txnid."&amount=".$amount."&mode=".$mode;
                        $hashstring = $memberid.$serviceid.$refdate.$refid.$email.$channeltype.$paymenttype.$ref1.$ref2.$ref3.$ref4.$ref5.$ref6.$ref7.$ref8.$txnid.$amount.$memberid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       
    
   function bill_payment_confirm_msg($memberid='',$serviceid='',$refid='',$txnid='') {
                        $refdate = date("YmdHis");
                        $mode='03';
                        //$memberid = 'TWZ';
                        //$memberid_secret = 'TWZ1234'; 
                        $memberid = 'TheBoxes(TWZ)';
                        $memberid_secret = 'SCVBMK'; 
                        $myreq =  "member_id=".$memberid."&service_id=".$serviceid."&ref_date=".$refdate."&member_ref=".$refid."&txn_id=".$txnid."&mode=".$mode;
                        $hashstring = $memberid.$serviceid.$refdate.$refid.$txnid.$memberid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       

   function getwallet_request_msg($channelid='',$refdate='') {
                        //$memberid = 'TWZ';
                        //$memberid_secret = 'TWZ1234';
                        $memberid = 'TheBoxes(TWZ)';
                        $memberid_secret = 'SCVBMK';  
                        $myreq =  "member_id=".$memberid."&channel_provider=".$channelid."&ref_date=".$refdate;
                        $hashstring = $memberid.$channelid.$refdate.$memberid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq;
   }

   function direct_topup_request_msg($memberid='',$refid='',$type='',$channel='',$requestdata='') {
                        $reqdate = date("Y-m-d H:i:s");
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&ref_id=".$refid."&type=".$type."&channel=".$channel."&requestdata=".$requestdata."&requestdate=".$reqdate;
                        $hashstring = $merchantid.$memberid.$refid.$type.$channel.$requestdata.$reqdate.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       

   function twz_topup_request_msg($memberid='',$method='',$refid1='',$refid2='',$amount='') {
                        $refdate = date("Y-m-d H:i:s");
                        $partnerid = '000000000007';
                        $secretcode = 'iSMBf/+440DVBWVDHIjM96UvPB9lZr8+uUTdV3uiRIXk2lQ3It';
                        $myreq =  "partner_id=".$partnerid."&customer_id=".$memberid."&method=".$method."&payforu_refid=".$refid1."&refid=".$refid2."&refdate=".$refdate."&amount=".$amount;
                        $hashstring = $partnerid.$memberid.$method.$refid1.$refid2.$refdate.$amount.$secretcode;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       
   
   function direct_update_bank_msg($memberid='',$bankcode='',$bankaccname='',$bankaccno='') {
                        $reqdate = date("Y-m-d H:i:s");
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $myreq =  "merchantid=".$merchantid."&customer_id=".$memberid."&requestdate=".$reqdate."&bank_code=".$bankcode."&bank_account_name=".$bankaccname."&bank_account_no=".$bankaccno;
                        $hashstring = $merchantid.$memberid.$reqdate.$bankcode.$bankaccname.$bankaccno.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       
   
   function direct_transfer_member_req_msg($memberid='',$customerid='',$refid='',$amount='') {
                        $reqdate = date("Y-m-d H:i:s");
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $method='Check';
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&customer_id=".$customerid."&ref_id=".$refid."&method=".$method."&amount=".$amount."&requestdate=".$reqdate;

                        #$hashstring = $merchantid.$memberid.$customerid.$refid.$method.$amount.$reqdate.$merchantid_secret;
                        $hashstring = $merchantid.$memberid.$customerid.$refid.$amount.$reqdate.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       
   
   function direct_transfer_member_commit_msg($memberid='',$customerid='',$refid='',$txnid='',$otp='') {
                        $reqdate = date("Y-m-d H:i:s");
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $method='Request';
                        $myreq =  "merchantid=".$merchantid."&memberid=".$memberid."&customer_id=".$customerid."&ref_id=".$refid."&method=".$method."&txnid=".$txnid."&confirmcode=".$otp."&requestdate=".$reqdate;

                        $hashstring = $merchantid.$memberid.$customerid.$refid.$txnid.$otp.$reqdate.$merchantid_secret;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq; 
   }                       
   
  
   function discount_revenue_req_msg($refid='',$memberid='',$discount='',$memberid_oth='',$discount_oth='',$revenueipps='',$revenue='',$payment='') {
                        $merchantid = '200000006523';
                        $merchantid_secret = 'WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq';
                        $discount = $discount * 100;
                        $discount_oth = $discount_oth * 100;
                        $revenueipps = $revenueipps * 100;
                        $revenue = $revenue * 100;
                        $discount_txt= "[".$memberid.";".$discount."]";
                        if ($memberid_oth != '') { 
                        $discount_txt1= "[".$memberid_oth.";".$discount_oth."]";
                        }
                        else {
                        $discount_txt1= "";
                        }
                        $discount_txt = $discount_txt.$discount_txt1;
                        $myreq =  "merchant_id=".$merchantid."&ref_id=".$refid."&discount=".$discount_txt."&revenue_ipps=".$revenueipps."&revenue_sharing=".$revenue."&payment_type=".$payment;
                        $hashstring = $merchantid.$refid.$discount_txt.$revenueipps.$revenue.$payment.$merchantid_secret;
                        error_log("myhash => ".$hashstring."\n",3,"/tmp/mylog.txt");
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        return $myreq;
   }  

 
   function ipps_submit_req($MYURL='',$myreq='') {
                        header('Content-type: text/html; charset=UTF-8'); 
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL,$MYURL);
                        curl_setopt($ch,CURLOPT_POST,1);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $server_output = curl_exec ($ch);
                        curl_close($ch);
                        return $server_output; 
     }


  function extractresult($result='') {
               static $new_array; 
               if (!is_null($result)) {
               $arrays = explode('&',$result);
               $new_array = array();
               foreach($arrays as $value)
               {
                     list($k,$v)=explode('=',$value);
                     $new_array[$k]=$v;
               }
                   return $new_array; 
               }
               else {
                   return null;
               } 
    }
}
?>
