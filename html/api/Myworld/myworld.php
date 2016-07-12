<?php
Class Myworld extends String{
    function login_request_msg() {
                        $data_post = array(); 
                        $data_post['user']="eazycard";
                        $data_post['password']="EazyCard!!"; 
                        return $data_post; 
     }
    
   function prepaid_request_msg($sessionId='',$refid='',$username='',$msisdn='',$price='') {
                        $data_post = array(); 
                        $data_post['sessionId']=$sessionId;
                        $data_post['transactionId']=$refid; 
                        $data_post['agentRef']=$username; 
                        $data_post['msisdn']=$msisdn; 
                        $data_post['topupType']='CASH'; 
                        $data_post['cashAmount']=$price; 
                        return $data_post; 
     }
   
   function listbill_request_msg($sessionId='',$refid='',$msisdn='') {
                        $data_post = array(); 
                        $data_post['sessionId']=$sessionId;
                        $data_post['transactionId']=$refid; 
                        $data_post['msisdn']=$msisdn; 
                        return $data_post; 
   }

   function paybill_request_msg($sessionId='',$refid='',$msisdn='',$billRef='',$amount='',$agentRef='') {
                        $data_post = array(); 
                        $bill_array = array(); 
                        $bill_array[0] = $billRef; 
                        $data_post['sessionId']=$sessionId;
                        $data_post['transactionId']=$refid; 
                        $data_post['msisdn']=$msisdn; 
                        $data_post['billIds']=$bill_array; 
                        $data_post['agentRef']=$agentRef; 
                        $data_post['cashAmount']=$amount; 
                        return $data_post; 
   }
 
   function myworld_submit_req($MYURL='',$myreq='') {
                        $ch = curl_init();
                        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
                        curl_setopt($ch,CURLOPT_URL,$MYURL);
                        curl_setopt($ch,CURLOPT_POST,TRUE);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq);
                        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0); 
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
                        $server_output = curl_exec ($ch);
                        curl_close($ch);
                        return $server_output; 
     }
}
?>
