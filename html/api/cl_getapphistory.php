<?php
include '../leone.php';
include '../admin/controller/app.php';
include '../admin/controller/payment.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$member = new member();
$payment = new payment();
$param_pcode = (!empty($_REQUEST["pcode"])) ? $_REQUEST["pcode"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

if ($param_pcode=='' || $param_email=='') {
	$msg = 'ส่ง parameter มาไม่ครบค่ะ';
	$returnData = getJSonData("FAIL",$msg,'','',''); 
}else{
    $havemember = $member->havemember($param_email);
    if ($havemember) {
        $apphistorydata = $payment->getbuyhistorydata_cl($param_email,$param_pcode,0,100);
		$apphistorydatarows = count($apphistorydata);
		for ($b=0;$b<$apphistorydatarows;$b++) {   
			 $db_id[$b] = $apphistorydata[$b]['p_id'];
			 $db_detail = stripslashes($apphistorydata[$b]['p_detail']);
			 $db_type = stripslashes($apphistorydata[$b]['p_type']);
			 $db_productid = stripslashes($apphistorydata[$b]['p_productid']);

			 $db_date[$b] = $DT->ShowDateDelivery($payment->getsetupdate($db_productid,$param_email));

             if ($db_type=='B') {
                $apptitle[$b] = $app->gettitle($db_productid);
			 }else{
                $apptitle[$b] = $db_detail;
			 }
		}

	    $msg = 'ระบบได้ดำเนินการเรียบร้อยค่ะ';
		$returnData = getJSonData('OK',$msg,$db_id,$apptitle,$db_date);
	}else{
		$msg = "สมาชิกท่านนี้ ไม่ได้รับอนุญาติให้ใช้งานระบบค่ะ";
		$returnData = getJSonData ("FAIL",$msg,'','','');
	}
}
print $returnData;

function getJSonData ($status='',$status_detail='',$appid='',$apptitle='',$datesetup='') {
  $data = "{";
  $data .= "\"resultdata\": {";
  $data .= "\"result\": \"".$status."\",";
  $data .= "\"result_desc\": \"".$status_detail."\",";
  $data .= "\"applist\": [";
  $msgdb = count($appid);
  for ($i=0;$i<$msgdb;$i++) {
	  if ($i==($msgdb-1)) {
         $data .= "{\"app_id\":\"".$appid[$i]."\",\"app_title\":\"".$apptitle[$i]."\",\"app_setupdate\":\"".$datesetup[$i]."\"}";
	  }else{
         $data .= "{\"app_id\":\"".$appid[$i]."\",\"app_title\":\"".$apptitle[$i]."\",\"app_setupdate\":\"".$datesetup[$i]."\"},";
	  }
  }
  $data .= "]";
  $data .= "}}";
  return $data;
}
?>