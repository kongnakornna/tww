<?php
include '../leone.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$member = new member();
$param_cpass = (!empty($_REQUEST["cpass"])) ? $_REQUEST["cpass"] : "";
$param_npass = (!empty($_REQUEST["npass"])) ? $_REQUEST["npass"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

if($param_email!=''){
	$haveemail = $member->checkcurrentpass($param_email,$param_cpass);
	if ($haveemail) {
		$result = $member->changepassword($param_email,$param_npass);
		if ($result) {
			$dataarray = array("result"=>"OK","result_desc"=>"");
		}else{
		    $msg = "�������ö����¹���ʼ�ҹ����� ��سҵԴ��ͼ������к����";
			$dataarray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg));
		}
	}else{
		$msg = "���������������к����";
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