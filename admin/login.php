<?php
require '../leone.php';
require './controller/authenticate.php';
header('Content-Type: text/html; charset=utf-8');
$param_uname = trim($_REQUEST["uname"]);
$param_pname = trim($_REQUEST["pname"]);

if($param_uname!='' && $param_pname!=''){
	$authen = new authenticate();
	$login_data = $authen->login($param_uname,$param_pname);
	if ($login_data[0]!='') {
		 $_SESSION['TWZUsername'] = $login_data[0];
		 $_SESSION['TWZFullname'] = $login_data[1];
		 $_SESSION['TWZEmail'] = $login_data[2];
		 $_SESSION['TWZID'] = $login_data[3];
		 $_SESSION['TWZPermission'] = $login_data[4];
		 $_SESSION['TWZGroup'] = $login_data[5];
		 $_SESSION['TWZFront'] = $login_data[6];
		 $_SESSION['islogin'] = true;

	     if (($_SESSION['TWZGroup']=='U' || $_SESSION['TWZGroup'] == 'M') && $_SESSION['TWZFront']=='N') {
	    	$Web->Redirect("mainpage.php");
		 }else{
	    	$Web->Redirect("front_menu.php");
		 }
		 die();
	}else{
		 $Web->AlertWinGo("Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง","index.php");
		 die();
	}
}else{
	$Web->AlertWinGo("Username หรือ Password ไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง","index.php");
    die();
}
?>
