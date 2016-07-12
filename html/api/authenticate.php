<?php
include '../leone.php';
include '../admin/controller/authenticate.php';
header('Content-Type: application/json; charset=utf-8');

$param_imei = trim($_REQUEST["imei"]);
$param_uname =trim($_REQUEST["user"]);
$param_pname =trim($_REQUEST["pass"]);
$authen = new authenticate();

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
	
				 $dataarray = array("result"=>"OK","result_desc"=>"","username"=>$String->tis2utf8($param_uname),"fullname"=>$String->tis2utf8($dbfullname),"email"=>$String->tis2utf8($dbemail),"code"=>$String->tis2utf8($dbcode));
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
print $resultxml;
?>
