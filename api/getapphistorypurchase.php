<?php
include '../leone.php';
include '../admin/controller/app.php';
include '../admin/controller/payment.php';
include '../admin/controller/partner.php';
include '../admin/controller/member.php';
header('Content-Type: application/json; charset=utf-8');
$app = new app();
$member = new member();
$payment = new payment();
$partner = new partner();
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";

if ($param_email=='') {
	$msg = '�� parameter �����ú���';
	$filearray = array("result"=>"FAIL","result_desc"=>$String->tis2utf8($msg),"applist"=>"");
}else{
    $havemember = $member->havemember($param_email);
    if ($havemember) {
        $apphistorydata = $payment->getbuyhistorydataforapp($param_email);
		$apphistorydatarows = count($apphistorydata);
		for ($b=0;$b<$apphistorydatarows;$b++) {   
			 $db_id = $apphistorydata[$b]['p_id'];
			 $db_detail = stripslashes($apphistorydata[$b]['p_detail']);
			 $db_type = stripslashes($apphistorydata[$b]['p_type']);
			 $db_price = stripslashes($apphistorydata[$b]['p_total']);
	                 $db_partner = stripslashes($apphistorydata[$b]['p_partnercode']);	  
	                 $db_msisdn = stripslashes($apphistorydata[$b]['p_msisdn']);	  
			 $db_productid = stripslashes($apphistorydata[$b]['p_productid']);
			 $db_date = stripslashes($apphistorydata[$b]['p_adddate']);
			 $db_ref1 = stripslashes($apphistorydata[$b]['p_ref2']);

             if ($db_type=='B') {
                $apptitle = $app->gettitle($db_productid);
			 }else{
                $apptitle = $db_detail;
			 }

			 $partnertitle = $partner->getnamebycode($db_partner);

			 #$dbarray[$b] = array ("app_id"=>$db_id,"app_title"=>$String->tis2utf8($apptitle),"app_setupdate"=>$String->tis2utf8($db_date),"app_owner"=>$String->tis2utf8($partnertitle),"app_price"=>$db_price);
                         if ($db_productid == 'ES9999' || $db_productid == 'ES9997') {
                         $dbarray[$b] = array ("app_id"=>$db_id,"app_title"=>$String->tis2utf8($apptitle),"app_setupdate"=>$String->tis2utf8($db_date),"app_owner"=>$db_ref1,"app_price"=>$db_price);
			 }
                         else { 
                         $dbarray[$b] = array ("app_id"=>$db_id,"app_title"=>$String->tis2utf8($apptitle),"app_setupdate"=>$String->tis2utf8($db_date),"app_owner"=>$db_msisdn,"app_price"=>$db_price);
	                 }	
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