<?php
include '../leone.php';
include '../admin/controller/eservice.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
include '../admin/controller/bank.php';
header('Content-Type: application/json; charset=utf-8');
#header('Content-Type: text/plain; charset=utf-8');
$modulename='payforureg.php';
$MYURL1 = "https://www.payforu.com/WebService/payforuservice.svc/RegisterCheck";
$MYURL2 = "https://www.payforu.com/WebService/payforuservice.svc/APIDirectRegisterURequest";
#$MYURL1 = "https://test.payforu.com/WebService/payforuservice.svc/RegisterCheck";
#$MYURL2 = "https://test.payforu.com/WebService/payforuservice.svc/APIDirectRegisterURequest";
$member = new member();
$eservice = new eservice();
$payment = new payment();
$bank = new bank();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_bankid = (!empty($_REQUEST["bankid"])) ? $_REQUEST["bankid"] : "";
$param_bankname= (!empty($_REQUEST["bankname"])) ? $_REQUEST["bankname"] : "";
$param_name= (!empty($_REQUEST["name"])) ? $_REQUEST["name"] : "";
//error_log("create account IPPS name => ".$param_name."\n",3,"/tmp/mylog.txt"); 

$refcode = $String->GenKey("12");
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:REQ',$modulename,$String->utf82tis($request));

if ($param_email=='' || $param_bankid == "" || $param_bankname == "") {
        //error_log("create account IPPS email => ".$param_email."\n",3,"/tmp/mylog.txt"); 
        //error_log("create account IPPS bankid => ".$param_bankid."\n",3,"/tmp/mylog.txt"); 
        //error_log("create account IPPS bankname => ".$param_bankname."\n",3,"/tmp/mylog.txt"); 
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
else{
	$havemember = $member->havemember($param_email);
	if ($havemember) {
                        
                        $member->changebankbyemail($param_email,$param_bankname,$param_bankid,$String->sqlEscape($String->utf82tis($param_name)));
                        $membercode = $member->getcodefromemail($param_email);	
         	        $mobileno = $member->getmobilefromemail($param_email); 
                        $ch = curl_init();	
                        $merchantid = "200000006523"; 
                        #$merchantid = "200000001777"; 
                        $ref_date = date("YmdHis");
                        $secretcode = "WLIKPYIlzDKMlx3Em0S9R3YK1nXqtt38qT8GomsHsrB73FA4xq";
                        #$secretcode = "twz123456";
                        $myreq =  "merchantid=".$merchantid."&email=".$param_email."&mobileno=".$mobileno."&membercode=".$membercode;
                        //error_log("create account IPPS => ".$myreq."\n",3,"/tmp/mylog.txt"); 
                        $hashstring = $merchantid.$param_email.$mobileno.$membercode.$secretcode;
                        $mdhashstring = md5($hashstring);
                        $myreq = $myreq."&hash=".$mdhashstring;
                        curl_setopt($ch,CURLOPT_URL,$MYURL1); 
                        curl_setopt($ch,CURLOPT_POST,1); 
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq); 
                        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                        #curl_setopt($ch,CURLOPT_POST,1); 
                        //error_log("create account IPPS hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt"); 
                        //error_log("create account IPPS mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt"); 
                        $resultlogging = $payment->insertlog($refcode,$param_email,'BE:REQ1',$modulename,$myreq);
                        $server_output = curl_exec ($ch);    
                        curl_close($ch);
                        //error_log("create account IPPS server_output => ".$server_output."\n",3,"/tmp/mylog.txt"); 
 		        $new_array = $payment->extractresult(trim($server_output)); 
                        $resultlogging = $payment->insertlog($refcode,$param_email,'BE:RES1',$modulename,json_encode($new_array));
                        //error_log("create account IPPS array output => ".$new_array['status']."\n",3,"/tmp/mylog.txt"); 
                        if ($new_array['status'] == '01')
                        { 
                           $membername = $member->getnamefromemail($param_email);	
                           $cardid = $member->getcardidfromemail($param_email);	
                           //Split the firstname and lastname from fullname.
                           $numspace = substr_count($membername,' ');
                           if ($numspace == 1) {
                               $mynamearray = preg_split('/\s+/', $membername);
                               $fname = $mynamearray[0];
                               $lname = $mynamearray[1];   
                           }
                           else {
                                $fname = $membername;
                                $lname = " ";
                           }
                           $myreq = "merchantid=".$merchantid."&email=".$param_email."&mobileno=".$mobileno."&firstname=".$fname."&lastname=".$lname."&personalid=".$cardid."&membercode=".$membercode;
                           $myreq=$String->tis2utf8($myreq);
                           //error_log("create account step 2 IPPS => ".$myreq."\n",3,"/tmp/mylog.txt"); 
                           $hashstring = $String->tis2utf8($merchantid.$param_email.$mobileno.$fname.$lname.$cardid.$membercode.$secretcode);
                           $mdhashstring = md5($hashstring);
                           $myreq = $myreq."&hash=".$mdhashstring;
                           $ch = curl_init();	
                           curl_setopt($ch,CURLOPT_URL,$MYURL2); 
                           curl_setopt($ch,CURLOPT_POST,1); 
                           curl_setopt($ch,CURLOPT_POSTFIELDS,$myreq); 
                           curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
                           //error_log("create account step 2 IPPS hashstring => ".$hashstring."\n",3,"/tmp/mylog.txt"); 
                           //error_log("create account step 2 IPPS mdhashstring => ".$mdhashstring."\n",3,"/tmp/mylog.txt"); 
                           $resultlogging = $payment->insertlog($refcode,$param_email,'BE:REQ2',$modulename,$myreq);
                           $server_output = curl_exec ($ch);    
                           curl_close($ch);
                           //error_log("create account IPPS server_output => ".$server_output."\n",3,"/tmp/mylog.txt"); 
 		           $new_array = $payment->extractresult(trim($server_output)); 
                           $resultlogging = $payment->insertlog($refcode,$param_email,'BE:RES2',$modulename,json_encode($new_array));
                           //error_log("create account IPPS array output => ".$new_array['status']."\n",3,"/tmp/mylog.txt"); 
                           if ($new_array['status'] == '01') {
			         $dataarray = array("result"=>"OK","result_desc"=>"","url"=>$new_array['url']);
                           }
                           else {
		                 $dataarray = array("result"=>"FAIL","result_desc"=>$new_array['status']);
                          } 
                        }
                        else
                        {
		          $dataarray = array("result"=>"FAIL","result_desc"=>$new_array['status']);
                        }	
        	}
	else{
		$msg = "สมาชิก ไม่ได้รับอนุญาติให้บริการค่ะ";
		$dataarray = array("result"=>"FAIL","result_desc"=>"The member doesn't exist");
	}
}
$resultlogging = $payment->insertlog($refcode,$param_email,'FE:RES',$modulename,$String->utf82tis(json_encode($dataarray)));
$carddata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

