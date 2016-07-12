<?php
include '../leone.php';
include '../admin/controller/authenticate.php';
include '../admin/controller/payment.php';
include './IPPS/ipps.php';
header('Content-Type: application/json; charset=utf-8');

$param_imei = trim($_REQUEST["imei"]);
$param_uname =trim($_REQUEST["user"]);
$param_pname =trim($_REQUEST["pass"]);
$authen = new authenticate();
$ipps = new ipps();
$payment = new payment();
$modulename='authenticate.php[IPPS]';
$request=$payment->loggingandroid($_REQUEST);
$resultlogging = $payment->insertlog('',$param_uname,'FE:REQ',$modulename,$String->utf82tis($request));

$param_uname = strtolower($param_uname);
$valid = $String->validpassword($param_pname);
$dataarray = '';
$bookdata = '';
$resultxml = '';
if($param_uname && $param_pname && $valid){	
	$chkimei = $authen->checkimeilogin($param_uname,$param_imei);
        #error_log("authen member chkimei => ".$chkimei."\n",3,"/tmp/mylog.txt"); 	
	if ($chkimei) {	
		$login_data = $authen->memberlogin($param_uname,$param_pname,$param_imei);
                if ($login_data[0]!='') {
			if (sizeof($login_data) > 0) {
				 $dbcode = $login_data[0];
				 $dbfullname = $login_data[1];
				 $dbemail = $login_data[2];
				 $dbid = $login_data[3];

                                 // Check IPPS customer info
                                 $reqstr = $ipps->direct_customer_info($dbcode);
                                 $urlstr = "https://www.payforu.com/WebService/payforuservice.svc/Customerinfo"; 
                                 $module_name_detail=$modulename.":direct_customer_info";
                                 $resultlogging = $payment->insertlog('',$dbemail,'BE:REQ',$module_name_detail,$String->utf82tis($reqstr)); //Logging
                                 $resstr = $ipps->ipps_submit_req($urlstr,$reqstr);
                                 $resultlogging = $payment->insertlog('',$dbemail,'BE:RES',$module_name_detail,$String->utf82tis($resstr)); //Logging
                                 $result_array = $ipps->extractresult($resstr);                                 

                                 if ($result_array['account_status'] == 'Active') { 
				 $dataarray = array("result"=>"OK","result_desc"=>"","username"=>$String->tis2utf8($param_uname),"fullname"=>$String->tis2utf8($dbfullname),"email"=>$String->tis2utf8($dbemail),"code"=>$String->tis2utf8($dbcode));
                                 }
                                 else {
			         $status_detail = "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้งค่ะ";
	                         $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($status_detail),"username"=>"","fullname"=>"","email"=>"","code"=>"");
                                 }
			}
		}else{
			$status_detail = "ชื่อผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้งค่ะ";
	        $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($status_detail),"username"=>"","fullname"=>"","email"=>"","code"=>"");
		}
	}else{
		$status_detail = "ชื่อ และ รหัสผ่าน ไม่สามารถใช้งานกับ IMEI เครื่องนี้ได้ ยังไม่ได้ลงทะเบียน";
	    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($status_detail),"username"=>"","fullname"=>"","email"=>"","code"=>"");
	}
}else{
        #error_log("authen member valid1=> ".$valid."\n",3,"/tmp/mylog.txt"); 	
	$status_detail = "กรุณากรอกข้อมูลให้ครบด้วยค่ะ";
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($status_detail),"username"=>"","fullname"=>"","email"=>"","code"=>"");
}
$bookdata = array("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
#error_log("authen member result=> ".print_r($resultxml,2)."\n",3,"/tmp/mylog.txt"); 	
$resultlogging = $payment->insertlog('',$param_uname,'FE:RES',$modulename,$String->utf82tis($resultxml));
print $resultxml;
?>
