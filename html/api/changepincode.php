<?php
include '../leone.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$member = new member();
if ($param_email=='') {
	$msg = '�� parameter �����ú���';
	$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
}else{
    $havemember = $member->havemember($param_email);
	if ($havemember) {
		$newpin = $String->GenKey("4");

		$result = $member->changepincode($param_email,$newpin);
		$subject = "����¹ PIN Code Easy Card";

		$mailBody = "���¹ ��ҹ������ԡ��<br/><br/>";
		$mailBody .= "&nbsp;&nbsp;��ԡ�� Easy Card ��ӡ������¹ PIN Code ����ҹ������ ".$newpin."<br/><br/>��ҹ����ö�� PIN Code ������ ���ӡ���׹�ѹ����ͫ����Թ��� ���� ��ԡ�� �ͧ Easy Card ��������ҹ��ͧ���<br/><br/>";
		$mailBody .= "�ͺ�س������ԡ�� Easy Card<br/>���´�����Ҫԡ Easy Card";

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=tis-620' . "\r\n";
		$headers .= 'From: ���´�����Ҫԡ Easy Card <service-member@easycard.club>' . "\r\n";
		mail($param_email, $subject, $mailBody, $headers);

		if ($result) {
			$dataarray = array("result"=>"OK","result_desc"=>"");
		}else{
		    $msg = "�������ö����¹ Pincode ����� ��سҵԴ��ͼ������к����";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}
	}else{
		$msg = "���������������к����";
        $dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
	}
}

$bookdata = array ("resultdata"=>$dataarray);
$resultxml = json_encode($bookdata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>