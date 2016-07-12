<?php
Class mpay extends String{
    function calfee_request_msg($mobileno='',$refid='',$serviceid='') {
                        $channelName = 'MERCHANT';
                        $command = 'CALFEE';
                        $shoppingChannel = 'MERCHANT';
                        $myreq =  "channelName=".$channelName."&command=".$command."&shoppingChannel=".$shoppingChannel."&mobileNo=".$mobileno."&serviceId=".$serviceid."&merchantRef=".$refid;
                        return $myreq; 
     }

    function check_barcode_request_msg($mobileno='',$refid='',$serviceid='',$barcode1='',$barcode2='') {
                        $channelName = 'MERCHANT';
                        $command = 'CheckBarcode';
                        $shoppingChannel = 'MERCHANT';
                        $myreq =  "channelName=".$channelName."&command=".$command."&shoppingChannel=".$shoppingChannel."&mobileNo=".$mobileno."&serviceId=".$serviceid."&barcode1=".$barcode1."&barcode2=".$barcode2."&merchantRef=".$refid;
                        return $myreq; 
     }
    function general_bill_request_msg($mobileno='',$serviceid='',$ref1='',$ref2='',$ref3='',$ref4='',$ref5='',$ref6='',$duedate='',$amount='',$payeemobile='') {
                        $channelName = 'MERCHANT';
                        $command = 'GENERALBILLN';
                        $shoppingChannel = 'MERCHANT';
                        $appName = 'GENERALBILL';
                        $parameter = 'GENERALBILL';
                        $barcodeFlag = 'Y';
                        $pin = '0405';
                        $myreq =  "channelName=".$channelName."&command=".$command."&shoppingChannel=".$shoppingChannel."&mobileNo=".$mobileno."&serviceId=".$serviceid."&ref1=".$ref1."&ref2=".$ref2."&ref3=".$ref3."&ref4=".$ref4."&ref5=".$ref5."&ref6=".$ref6."&appName=".$appName."&parameter=".$parameter."&dueDate=".$duedate."&barcodeFlag=".$barcodeFlag."&amount=".$amount."&pin=".$pin."&payeeMobile=".$payeemobile;
                        return $myreq; 
     }
    function general_bill2_request_msg($mobileno='',$serviceid='',$sessionId='') {
                        $channelName = 'MERCHANT';
                        $command = 'GENERALBILLN2';
                        $shoppingChannel = 'MERCHANT';
                        $appName = 'GENERALBILL';
                        $parameter = 'GENERALBILL';
                        $piSeq = '1';
                        $billSeq = '1';
                        $myreq =  "channelName=".$channelName."&command=".$command."&shoppingChannel=".$shoppingChannel."&mobileNo=".$mobileno."&serviceId=".$serviceid."&billSeq=".$billSeq."&sessionId=".$sessionId."&piSeq=".$piSeq."&appName=".$appName."&parameter=".$parameter;
                        return $myreq; 
     }

    function sbn_request_msg($mobileno='',$serviceid='',$sessionId='',$ref1='',$payeemobile='') {
                        $channelName = 'MERCHANT';
                        $command = 'SBN1';
                        $shoppingChannel = 'MERCHANT';
                        $appName = 'AIRNET';
                        $parameter = 'AIRNET_AGENT';
                        $pin = '0405';
                        $myreq =  "channelName=".$channelName."&command=".$command."&shoppingChannel=".$shoppingChannel."&mobileNo=".$mobileno."&serviceId=".$serviceid."&ref1=".$ref1."&merchantref=".$sessionId."&pin=".$pin."&appName=".$appName."&parameter=".$parameter."&payeeMobile=".$payeemobile;
                        return $myreq; 
     }
    
    function sbn2_request_msg($mobileno='',$refid='',$sessionId='') {
                        $channelName = 'MERCHANT';
                        $command = 'SBN2';
                        $shoppingChannel = 'MERCHANT';
                        $appName = 'AIRNET';
                        $parameter = 'AIRNET_AGENT';
                        $pin = '0405';
                        $billSeq = '1';
                        $piSeq  = '0';
                        $myreq =  "channelName=".$channelName."&command=".$command."&shoppingChannel=".$shoppingChannel."&mobileNo=".$mobileno."&merchantref=".$refId."&sessionId=".$sessionId."&appName=".$appName."&parameter=".$parameter."&billSeq=".$billSeq."&piSeq=".$piSeq;
                        return $myreq; 
     }

   function mpay_submit_req($MYURL='',$myreq='') {
                        header('Content-type: text/html; charset=UTF-8'); 
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_URL,$MYURL);
                        curl_setopt($ch,CURLOPT_POST,1);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSLKEY, "mpayweb.keystore"); 
                        curl_setopt($ch, CURLOPT_SSLKEYPASSWD, "changit");
                        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, "changit");
                        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
                        #curl_setopt($ch, CURLOPT_CAPATH, '/etc/ssl/certs');
                        #curl_setopt($ch, CURLOPT_CAINFO, 'buffet-seafood.ais.co.th.cer');
                        curl_setopt($ch, CURLOPT_VERBOSE, true);
                        curl_setopt($ch, CURLOPT_STDERR, fopen('/tmp/stderr', 'w+')); 
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                        curl_setopt($ch, CURLOPT_HEADER, false);
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
