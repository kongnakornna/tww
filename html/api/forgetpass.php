<?php
include '../leone.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$member = new member();

if($param_email!=''){
	$haveemail = $member->havemember($param_email);
	if ($haveemail) {
		$newPass = $String->GenKey(5);
		$result = $member->changepassword($param_email,$newPass);
		if ($result) {
			$subject = "����¹���ʼ�ҹ Easy Card";
			$mailBody = "���¹ ��ҹ��Ҫԡ<br/><br/>";
			$mailBody .= "       ��ԡ�� Easy Card ��ӡ������¹���ʼ�ҹ����ҹ������ '$newPass'<br/><br/>��ҹ����ö Log in �����ҹ��ԡ�� Easy Card ��������ʼ�ҹ������ ������ͤ����дǡ㹡�������ʼ�ҹ �ҡ��ҹ����дǡ��ҹ���ʼ�ҹ��� ����� Log in �������ԡ�������� ��ҹ����ö����¹���ʼ�ҹ������ ������� ����¹���ʼ�ҹ ����� �ѭ�ռ����ҹ�ͧ�ѹ<br/><br/>�ͺ�س������ԡ�� Easy Card<br/><br/>���´�����Ҫԡ Easy Card";

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
			$headers .= 'From: ���´�����Ҫԡ Easy Card <noreply@easycard.club>' . "\r\n";
			mail($param_email, $subject, $mailBody, $headers);

			$msg = "�к�����Թ�������¹���ʼ�ҹ����ҹ���Ǥ��ǡ�س� �����ʼ�ҹ���������������ҹŧ����¹���";
			$dataarray = array("result"=>"OK","result_desc"=>$String->tis2utf8($msg));
		}
	}else{
		$msg = "���������������к���� ��س������������";
        $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}else{
	$msg = "��سҡ�͡��������¤��";
    $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}
$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>