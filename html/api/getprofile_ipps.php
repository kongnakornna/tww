<?php
include '../leone.php';
include '../admin/controller/member.php';
include '../admin/controller/payment.php';
include './IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$member = new member();
$payment = new payment();
$ipps = new ipps();
$modulename = 'getprofile.php[IPPS]';

if($param_email!=''){
	$haveemail = $member->havemember($param_email);
	if ($haveemail) {
              // Sync E-wallet Pay for U
        	$mdata = $member->getcodebyemail($param_email);
                $reqstr = $ipps->direct_customer_info($mdata);
                $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/Customerinfo";
                $module_name_detail=$modulename.":direct_customer_info";
                $resultlogging = $payment->insertlog('',$param_email,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);  //Customer Info API
                $resultlogging = $payment->insertlog('',$param_email,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                $result_array = $ipps->extractresult($resstr);
                if ($result_array['result'] == '01') {
                     $balance_new = $result_array['account_balance'];
                     $payment->adjustcardnobyemail($param_email,$balance_new);
                 }	
        	$mdata = $member->getdatabyemail($param_email);
		if (count($mdata)>0) {
			$m_id = $mdata[0]['m_id'];
			$m_type = $mdata[0]['m_type'];
			$m_imei = $mdata[0]['m_imei'];
			$m_email = $mdata[0]['m_email'];
			$m_fullname = $mdata[0]['m_fullname'];
			$m_address = $mdata[0]['m_address'];
			$m_province = $mdata[0]['m_province'];
			$m_mobile = $mdata[0]['m_mobile'];
			$m_bankid = $mdata[0]['m_bankid'];
			$m_bankcode = $mdata[0]['m_bankcode'];
			$m_price = $mdata[0]['m_price'];
			$m_price_sync = $mdata[0]['m_price_sync'];
			$m_point = $mdata[0]['m_point'];
			$m_code = $mdata[0]['m_code'];
			$m_mcode = $mdata[0]['m_mcode'];
			$m_saleid = $mdata[0]['m_saleid'];
			$m_adddate = $DT->ShowDate($mdata[0]['m_adddate'],'th');


	        $dataarray = array("result"=>"OK","result_desc"=>"","membercode"=>$String->tis2utf8($m_code),"fullname"=>$String->tis2utf8($m_fullname),"email"=>$String->tis2utf8($m_email),"address"=>$String->tis2utf8($m_address),"province"=>$String->tis2utf8($m_province),"registerdate"=>$String->tis2utf8($m_adddate),"mobile"=>$String->tis2utf8($m_mobile),"imei"=>$m_imei,"mcode"=>$String->tis2utf8($m_mcode),"scode"=>$String->tis2utf8($m_saleid),"money"=>$String->tis2utf8($m_price_sync),"point"=>$String->tis2utf8($m_point),"cardpayment"=>$String->tis2utf8($paymentcode),"bankid"=>$String->tis2utf8($m_bankid),"bankcode"=>$String->tis2utf8($m_bankcode));
		}
	}else{
		$msg = "อีเมล์นี้ไม่มีในระบบค่ะ กรุณาใช้อีเมล์อื่น";
	    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"membercode"=>"","fullname"=>"","email"=>"","address"=>"","province"=>"","registerdate"=>"","mobile"=>"","imei"=>"","mcode"=>"","scode"=>"","money"=>"","point"=>"","cardpayment"=>"","bankid"=>"","bankcode"=>"");
	}
}else{
	$msg = "กรุณากรอกอีเมล์ด้วยค่ะ";
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"membercode"=>"","fullname"=>"","email"=>"","address"=>"","province"=>"","registerdate"=>"","mobile"=>"","imei"=>"","mcode"=>"","scode"=>"","money"=>"","point"=>"","cardpayment"=>"","bankid"=>"","bankcode"=>"");
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>
