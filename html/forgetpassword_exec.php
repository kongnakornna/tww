<?php
include "./leone.php";
include "./admin/controller/member.php";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_chkcode = (!empty($_REQUEST["chkcode"])) ? $_REQUEST["chkcode"] : "";
if ($param_chkcode=='' || $param_chkcode!=$_SESSION['TWZSessCode']) {
    $Web->AlertWinGo("�����Ѻ����ҹ��͡���ç�Ѻ��к� ú�ǹ�ͧ�����ա���駤��.","forgetpassword.php");
	die();
}else{
	$member = new member();
	$newPass = $String->GenKey(5);
	$result = $member->changepassword($param_email,$newPass);
	if ($result) {
		$subject = "������ʼ�ҹ";
		$mailBody = "���¹ ��ҹ��Ҫԡ<br/><br/>";
		$mailBody .= "    �к�����Թ�������¹���ʼ�ҹ��������ҹ���Ǥ����� '$newPass' �ҡ��ҹ��Ҫԡ����ö�������к������� ��س�����¹���ʼ�ҹ���¤��<br/><br/>���ʴ������Ѻ���";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
		$headers .= 'From: TWZpay Web Site <service-developer@easycard.club>' . "\r\n";
		mail($param_email, $subject, $mailBody, $headers);

		$Web->AlertWinGo("�к�����Թ�������¹���ʼ�ҹ����ҹ���Ǥ��ǡ�س� �����ʼ�ҹ��������������","mainpage.php");
	}else{
		$Web->AlertWinGo("�к��������ö���Թ����� ��س��ͧ�����ա���駤��","mainpage.php");
	}
	die();
}
?>