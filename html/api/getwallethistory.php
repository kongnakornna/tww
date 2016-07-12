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
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"walletdata"=>"");
}else{
    $havemember = $member->havemember($param_email);
    if ($havemember) {
		$membercode = $member->getcodebyemail($param_email);
        $apphistorydata = $payment->getwalletdata($param_email,$membercode);
		$apphistorydatarows = count($apphistorydata);
		if ($apphistorydatarows>0) {
			for ($b=0;$b<$apphistorydatarows;$b++) {   
				 $db_id = $apphistorydata[$b]['p_id'];
				 $db_ref1 = stripslashes($apphistorydata[$b]['p_ref1']);
				 $db_price = stripslashes($apphistorydata[$b]['p_price']);
				 $db_station = stripslashes($apphistorydata[$b]['p_station']);
				 $db_adddate = $DT->ShowDateDelivery($apphistorydata[$b]['p_adddate']);

				 $stationTitle = $member->getpaymentname($db_station);

				 $dbarray[$b] = array ("station"=>$String->tis2utf8($stationTitle),"ref_code"=>$String->tis2utf8($db_ref1),"price"=>$String->tis2utf8($db_price),"adddate"=>$String->tis2utf8($db_adddate));
			}
			$filearray = array("result"=>"OK","result_desc"=>"","walletdata"=>$dbarray);
		}else{
			$msg = "ไม่พบข้อมูลค่ะ";
		    $filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"walletdata"=>"");
		}
	}else{
		$msg = "สมาชิกท่านนี้ ไม่ได้รับอนุญาติให้ใช้งานระบบค่ะ";
		$filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"walletdata"=>"");
	}
}

$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

print $resultxml;
?>