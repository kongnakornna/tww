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

		 $mailbody = "���¹ �س $db_fullname<br/>";
		 $mailbody .= "&nbsp;&nbsp;�ͺ�س������͡���ԡ�� Easy Card ������͡����ҹ Easy Card �ͧ��ҹ<br/> ���ӡ�ä�ԡ��� �Դ��ҹ Easy Card ���ͷ���� Easy Card �ͧ��ҹ����ö��ҹ ��<br/><br/> <a href=\"https://www.easycard.club/activate.php?i=".$db_key."\" target=\"_blank\">�Դ��ҹ Easy Card</a><br/><br/>(��ѧ�ҡ�ӡ���Դ��ҹ Easy Card ���� ��ҹ����ö Log in �������ԡ����)<br/>�ͺ�س������ԡ�� Easy Card<br/><br/>";
		 $mailbody .= "���ʴ������Ѻ���<br/>";

		 $headers  = 'MIME-Version: 1.0' . "\r\n";
		 $headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
		 $headers .= 'From: EasyCard Customer Service <service-member@easycard.club>' . "\r\n";
		 mail($db_email, $Subject, $mailbody, $headers);
	}
}

$DatabaseClass->DBClose();
$Web->AlertWinGo("�����������º����","memberedit_form.php?id=" . $param_id);
die();
?>