<?php
	session_start();

	include 'lib/nusoap.php';
	
	//get key from ThaiLemon
	//Test key is "111E72E07656B30FE09FE321D056891C"
	//Production key will auto generate every 5 minute
	$ch = curl_init();
	//UAT
	curl_setopt($ch, CURLOPT_URL, "http://ipayuat.thailemonpay.com/services/getkey.php");
	//Production
	//curl_setopt($ch, CURLOPT_URL, "https://www.thailemonpay.com/services/getkey.php");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$tlp_key = curl_exec($ch);
	curl_close($ch);
	
	$pwd = "ipayuat123";
	//Encrypt_password by 3 steps
	//1.Use MD5
	//2.Use base64_encode
	//3.Combine with thailemon key
	$password = base64_encode(md5($pwd)) . $tlp_key;
	
	//Check email and password
	$email = 'mepayuat@thailemonpay.com';
	$pay_code = "12C";
	$tran_id = 1915; //Running no.
	$amount = "50";
	$mobile = "0824603321";
	
	//Call Web Services
	//UAT : Test by SoapUI.
	$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
	//Production
	//$client = new nusoap_client("https://www.thailemonpay.com/services/plsp_mtopup.php?wsdl", true);
	
	$params = array(
		'email' => $email,
		'password' => $password,
		'pay_code' => $pay_code,
		'tran_id' => $tran_id,
		'amount' => $amount,
		'mobile' => $mobile
	);
	$return_arr = $client->call("payment", $params); //Topup
	//$return_arr = $client->call("inquiry", $params); //Inquiry
	//$return_arr = $client->call("update", $params); //Update
	
	print_r ($return_arr);

	echo "<hr>";
	echo json_encode($return_arr);
?>