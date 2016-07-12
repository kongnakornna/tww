<?php
       include '../../leone.php';
       include '../../admin/controller/payment_mpay.php';
       include './mpay.config.php';
       include 'lib/nusoap.php';
       header('Content-Type: application/json; charset=utf-8');
       $paymentmpay = new paymentmpay();
       $param_req = $_REQUEST['req'];
       $param_refid = $_REQUEST['refid'];
       $param_email = $_REQUEST['email'];
       $param_msisdn = $_REQUEST['msisdn'];
       $param_price = $_REQUEST['price']; 
 

       if ($param_req=='' || $param_refid=='' || $param_msisdn=='') {
	    $msg = '?? parameter ?????ú???';
	    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
        }
       else{
            $ans = $paymentmpay->checkPaymentRecord($param_refid,$param_email);
            error_log("Lemon One2Call check payment Record => ".$ans."\n",3,"/tmp/mylog.txt");
      
           if ($ans) {
         	//session_start();
	        //get key from ThaiLemon
	        //Test key is "111E72E07656B30FE09FE321D056891C"
	        //Production key will auto generate every 5 minute
	        //$ch = curl_init();
	        //UAT
	        //curl_setopt($ch, CURLOPT_URL, "http://ipayuat.thailemonpay.com/services/getkey.php");
	        //Production
         	//curl_setopt($ch, CURLOPT_URL, "https://www.thailemonpay.com/services/getkey.php");
	        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        //$tlp_key = curl_exec($ch);
	        //curl_close($ch);
	
		//$pwd = "ipayuat123";
		//Encrypt_password by 3 steps
		//1.Use MD5
		//2.Use base64_encode
		//3.Combine with thailemon key
		//$password = base64_encode(md5($pwd)) . $tlp_key;
	
		//Check email and password
		//$email = 'mepayuat@thailemonpay.com';
		//$pay_code = "12CALL"; //12CALL, HAPPY, TMVH, MY
		$tran_id = $param_refid; //Running no.
		//$amount of 12CALL: 10,20,30,40,50,60,70,80,90,100,150,200,300,350,400,500,800
		//$amount of HAPPY: 10,20,30,40,50,60,100,200,300,500,800
		$amount = $param_price;
		$mobile = $param_msisdn; 
	
		//Call Web Services
		//UAT : Test by SoapUI.
		//$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
		//Production
		//$client = new nusoap_client("https://www.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
	
	        /*	
                $params = array(
		'email' => $email,
		'password' => $password,
		'pay_code' => $pay_code,
		'tran_id' => $tran_id,
		'amount' => $amount,
		'mobile' => $mobile
		);
		$return_arr = $client->call("payment", $params); //Topup

                $status = $return_arr[9];
                $tranId = $return_arr[2];
                $price = $return_arr[3];
                $resultdesc = $return_arr[10]; 
                */
                //$tranId = $tran_id; 
                $price = $amount; 
                $sercharge = 0;
                $totalprice = $price;  
                $dataarray = array("result"=>"OK","result_desc"=>"","refcode"=>$tran_id,"price"=>$price,"sercharge"=>$sercharge,"totalprice"=>$totalprice);  
	        $myret = print_r ($return_arr,true);
                error_log("return soap => ".$myret."\n",3,"/tmp/mylog.txt");
        	//echo "<hr>";
                //$paymentmpay->updateRecord ($param_msisdn,$param_price,$param_refid,$param_email,$tranId,$status);	
                $bookdata = array ("resultdata"=>$dataarray); 
                print json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                }
        }
?>
