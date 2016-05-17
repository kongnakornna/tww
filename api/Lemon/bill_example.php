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
	$pay_code = "PWA";
	$tran_id = 1915; //Running no.
	$due_date = "04/08/2557";
	$amount = "101.95";
	$service_fee = 10;
	$mobile = "0824603321";
	$remark = "remark:name";
	$barcode = "barcodedata";
	$is_free = 'N';
	$ref1 = "11";
	$ref2 = "22";
	$ref3 = "33";
	$ref4 = "";
	$ref5 = "";
	$ref6 = "";
	$ref7 = "";
	$ref8 = "";
	$ref9 = "";
	$ref10 = "";

	//Call Web Services
	//UAT : Test by SoapUI.
	$client = new nusoap_client("http://ipayuat.thailemonpay.com/services/plsp_bill.php?wsdl", true);
	//Production
	//$client = new nusoap_client("https://www.thailemonpay.com/services/plsp_bill.php?wsdl", true);
	
	$params = array(
		'email' => $email,
		'password' => $password,
		'pay_code' => $pay_code,
		'tran_id' => $tran_id,
		'due_date' => $due_date,
		'amount' => $amount,
		'service_fee' => $service_fee,
		'mobile' => $mobile,
		'remark' => $remark,
		'barcode' => $barcode,
		'is_free' => $is_free,
		'ref1' => $ref1,
		'ref2' => $ref2,
		'ref3' => $ref3,
		'ref4' => "",
		'ref5' => "",
		'ref6' => "",
		'ref7' => "",
		'ref8' => "",
		'ref9' => "",
		'ref10' => ""
	);
	$return_arr = $client->call("payment", $params); //Topup
	//$return_arr = $client->call("inquiry", $params); //Inquiry
	//$return_arr = $client->call("update", $params); //Update
	
	print_r ($return_arr);

	echo "<hr>";
	echo json_encode($return_arr);
?>