<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlCheck = "select * from tbl_member where m_id='".trim(strtolower($param_id))."' order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
	     $db_email = stripslashes($RowCheck['m_email']);	 
	     $db_fullname = stripslashes($RowCheck['m_fullname']);	 
	     $db_key = stripslashes($RowCheck['m_key']);	
		 $Subject = "EasyCard Register Online";

		 $mailbody = "เรียน คุณ $db_fullname<br/>";
		 $mailbody .= "&nbsp;&nbsp;ขอบคุณที่เลือกใช้บริการ Easy Card และเพื่อการใช้งาน Easy Card ของท่าน<br/> ให้ทำการคลิกที่ เปิดใช้งาน Easy Card เพื่อทำให้ Easy Card ของท่านสามารถใช้งาน ได้<br/><br/> <a href=\"https://www.easycard.club/activate.php?i=".$db_key."\" target=\"_blank\">เปิดใช้งาน Easy Card</a><br/><br/>(หลังจากทำการเปิดใช้งาน Easy Card แล้ว ท่านสามารถ Log in เข้าสู่บริการได้)<br/>ขอบคุณที่ใช้บริการ Easy Card<br/><br/>";
		 $mailbody .= "ขอแสดงความนับถือ<br/>";

		 $headers  = 'MIME-Version: 1.0' . "\r\n";
		 $headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
		 $headers .= 'From: EasyCard Customer Service <service-member@easycard.club>' . "\r\n";
		 mail($db_email, $Subject, $mailbody, $headers);
	}
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("ส่งอีเมล์เรียบร้อย","memberedit_form.php?id=" . $param_id);
die();
?>