<?php
require './leone.php';
require './admin/controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
$param_uname = (!empty($_REQUEST["uname"])) ? $_REQUEST["uname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";

$valid = $String->validpassword($param_pname);
if($param_uname && $param_pname && $valid){
	$partner = new partner();
	$login_data = $partner->login($param_uname,$param_pname);
	if ($login_data[0]!='') {
		if (sizeof($login_data) > 0) {
			 $_SESSION['DVTitle'] = $login_data[0];
			 $_SESSION['DVFullname'] = $login_data[1];
			 $_SESSION['DVEmail'] = $login_data[2];
			 $_SESSION['DVID'] = $login_data[3];
			 $_SESSION['DVCode'] = $login_data[4];
			 $_SESSION['DVLastlogin'] = $login_data[5];
			 $_SESSION['isdevlogin'] = true;
		}
    	$Web->Redirect("dev_mainpage.php");
		die();
	}else{
		$Web->AlertWinGo("Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง","dev_loginform.php");
		die();
	}
}else{
	$Web->AlertWinGo("Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง","dev_loginform.php");
    die();
}
?>