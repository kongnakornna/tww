<?php
require '../leone.php';
require '../class.phpmailer.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_passchn = (!empty($_REQUEST["passchn"])) ? $_REQUEST["passchn"] : "";
$param_sdate = (!empty($_REQUEST["sdate"])) ? $_REQUEST["sdate"] : "";

$SqlCheck = "select * from tbl_partner where p_id='".trim(strtolower($param_id))."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
	     $db_email = stripslashes($RowCheck['p_email']);	 
		 $db_title = stripslashes($RowCheck['p_title']);
	     $db_fullname = stripslashes($RowCheck['p_fullname']);	 
	     $db_code = $RowCheck['p_code'];

		 if ($param_passchn=='Y') {
			 $newpasswd = $String->GenPassword(9);
			 $SqlUpdatePass = "update tbl_partner set p_password=MD5('".$newpasswd."') where p_id='".$param_id."'";
			 $ResultUpdatePass = $DatabaseClass->DataExecute($SqlUpdatePass);
		 }else{
			 $newpasswd = "*** Not Change ***";		  
		 }

		 $Subject = "TIMEPLAN (EasyCard Test) " . $db_title;
		 $mailbody = "Dear Partner<br/>";
		 $mailbody .= "&nbsp;&nbsp;Please be informed time plan and account information for integration test as below:<br/><br/>";

         $mailbody .= "Engineer test :  ".$param_sdate."<br/>";
		 $mailbody .= "Merchant ID : ".$db_code."<br/>";
		 $mailbody .= "Merchant Name : ".$db_title."<br/>";
		 $mailbody .= "Username : ".$db_email."<br/>";
		 $mailbody .= "Password : ".$newpasswd."<br/>";
		 $mailbody .= "URL Page : https://www.easycard.club/dev_loginform.php<br/><br/>";

		 $mailbody .= "<strong>EasyCard Member for testing</strong><br/>";
		 $mailbody .= "Email : jgodsonline@gmail.com<br/>";
		 $mailbody .= "Imei : 359906053118845<br/>";
		 $mailbody .= "Implement date will be informed by e-mail after testing completed.<br/><br/>";
		 $mailbody .= "Best Regards,<br/>";

		 $mail = new phpmailer();
		 $mail->IsHTML(true);
		 $mail->Priority = 1;
		 $mail->From = "service-developer@easycard.club";
		 $mail->FromName = "ฝ่ายดูแลผู้ร่วมค้า Easy Card";
		 $mail->Username = "service-developer@easycard.club";
		 $mail->Password = "service2";
		 $mail->Mailer = "smtp";
		 $mail->SMTPDebug = false;
		 $mail->Subject = $Subject;
		 $mail->Body = $mailbody;
		 $mail->AddAttachment("../files/specification_v1.pdf","specification_v1.pdf");
		 $mail->CharSet = "tis-620";
		 $mail->AddAddress("$db_email", $db_fullname);
	   	// $mail->AddAddress("jgodsonline@gmail.com", "Preeda S.");
		 $mail->AddCc("kritsanucha@hotmail.com", "Kritsanucha S.");
		 $mail->AddCc("preeda_s@msn.com", "Preeda S.");
		 if(!$mail->Send()) {
			print "<PRE><!--Can't send mail to $db_email $db_fullname--></PRE>";
		 }
		 $mail->ClearAddresses();
	}
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ส่งอีเมล์เรียบร้อย","partneredit_form.php?id=" . $param_id);
die();
?>