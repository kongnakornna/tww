<?php
include '../leone.php';
include '../admin/controller/app.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$member = new member();
$payment = new payment();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

if ($param_email=='') {
	$msg = '�� parameter �����ú���';
	$filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"applist"=>"");
}else{
    $havemember = $member->havemember($param_email);
    if ($havemember) {
        $apphistorydata = $payment->getbuyhistorydata($param_email,0,100);
		$apphistorydatarows = count($apphistorydata);
		for ($b=0;$b<$apphistorydatarows;$b++) {   
			 $db_id = $apphistorydata[$b]['p_id'];
			 $db_detail = stripslashes($apphistorydata[$b]['p_detail']);
			 $db_type = stripslashes($apphistorydata[$b]['p_type']);
			 $db_productid = stripslashes($apphistorydata[$b]['p_productid']);

			 $db_date = $DT->ShowDateDelivery($payment->getsetupdate($db_productid,$param_email));

             if ($db_type=='B') {
                $apptitle = $app->gettitle($db_productid);
			 }else{
                $apptitle = $db_detail;
			 }

             $dbarray = array ("app_id"=>$db_id,"app_title"=>$String->tis2utf8($apptitle),"app_setupdate"=>$String->tis2utf8($db_date));
		}

	    $filearray = array("result"=>"OK","result_desc"=>"","applist"=>$dbarray);
	}else{
		$msg = "��Ҫԡ��ҹ��� ������Ѻ͹حҵ������ҹ�к����";
		$filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"applist"=>"");
	}
}

$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>