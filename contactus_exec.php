<?php
include "./leone.php";
include "./admin/controller/config.php";
$param_contactname = (!empty($_REQUEST["contactname"])) ? $_REQUEST["contactname"] : "";
$param_contactemail = (!empty($_REQUEST["contactemail"])) ? $_REQUEST["contactemail"] : "";
$param_contactphone = (!empty($_REQUEST["contactphone"])) ? $_REQUEST["contactphone"] : "";
$param_contacttopic = (!empty($_REQUEST["contacttopic"])) ? $_REQUEST["contacttopic"] : "";
$param_contactdetail = (!empty($_REQUEST["contactdetail"])) ? $_REQUEST["contactdetail"] : "";
$param_chkcode = (!empty($_REQUEST["chkcode"])) ? $_REQUEST["chkcode"] : "";
if ($param_chkcode=='' || $param_chkcode!=$_SESSION['TWZSessCode']) {
    $Web->AlertWinGo("�����Ѻ����ҹ��͡���ç�Ѻ��к� ú�ǹ�ͧ�����ա���駤��.","contactus.php");
	die();
}else{
	$config = new config();
	$toemail = $config->getbycode('01');
	$mailBody = "Customer Name : $param_contactname<br/>";
	$mailBody .= "Customer Email : $param_contactemail<br/>";
	$mailBody .= "Customer Phone : $param_contactphone<br/>";
	$mailBody .= "Topic : $param_contacttopic<br/>";
	$mailBody .= "Message : $param_contactdetail<br/>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
	$headers .= 'From: ���´�����Ҫԡ Easy Card <service-member@easycard.club>\r\nReply-to: '.$param_contactemail;

	$headers .= 'From: ���´�����Ҫԡ Easy Card <service-member@easycard.club>' . "\r\n" .
    'Reply-To: ' . $param_contactemail . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

	mail($toemail, $param_contacttopic, $mailBody, $headers);

	$Web->AlertWinGo("���ѧ�觢�ͤ����ͧ��ҹ��ѧ���� �ҡ���Ѻ��ͤ������� �ҧ��ԡ�èеԴ��� ��еͺ��Ѻ� �ͺ�س���","mainpage.php");
	die();
}
?>