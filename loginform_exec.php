<?php
require './leone.php';
require './admin/controller/authenticate.php';
header('Content-Type: text/html; charset=tis-620');
$param_uname = (!empty($_REQUEST["uname"])) ? $_REQUEST["uname"] : "";
$param_pname = (!empty($_REQUEST["pname"])) ? $_REQUEST["pname"] : "";

$valid = $String->validpassword($param_pname);
if($param_uname && $param_pname && $valid){
	$authen = new authenticate();
	$login_data = $authen->memberloginforweb($param_uname,$param_pname."1");
	if ($login_data[0]!='') {
		if (sizeof($login_data) > 0) {
			 $_SESSION['TWCode'] = $login_data[0];
			 $_SESSION['TWFullname'] = $login_data[1];
			 $_SESSION['TWEmail'] = $login_data[2];
			 $_SESSION['TWID'] = $login_data[3];
			 $_SESSION['ismemberlogin'] = true;
		}
    	$Web->Redirect("member_mainpage.php");
		die();
	}else{
		$Web->AlertWinGo("Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง","loginform.php");
		die();
	}
}else{
	$Web->AlertWinGo("Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง","loginform.php");
    die();
}
?>