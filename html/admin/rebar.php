<?php
require '../leone.php';
header('Content-Type: application/json; charset=utf-8');

$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";

if ($param_type=='') $param_type = "BIGC";

$SqlPaymentDelete = "delete from tbl_member_payment where p_cardtype='".$param_type."'";
$ResultPaymentDelete = $DatabaseClass->DataExecute($SqlPaymentDelete);

$SqlCheck = "select * from tbl_member order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_code = $RowCheck['m_code'];
		 $db_email = $RowCheck['m_email'];

         if ($param_type=='71101') {
			 $ptitle = "7-11 รหัส 01";
			 $newnumber = '36001' . $db_code .  '210010'; 
             $resultbarcode = $barcode->genfor71101($newnumber);
		 }else if ($param_type=='71103') {
			 $ptitle = "7-11 รหัส 03";
			 $newnumber = '36003' . $db_code .  '210010'; 
             $resultbarcode = $barcode->genfor71103($newnumber);
		 }else if ($param_type=='TWZ') {
			 $ptitle = "TWZ";
			 $newnumber = $db_code; 
             $resultbarcode = $barcode->genfor($newnumber);
		 }else if ($param_type=='BIGC') {
			 $ptitle = "BIGC";
			 $newnumber = $db_code; 
             $resultbarcode = $barcode->genforbigc($newnumber);
		 }else if ($param_type=='LOTUS') {
			 $ptitle = "LOTUS";
			 $newnumber = $db_code; 
             $resultbarcode = $barcode->genforlotus($newnumber);
		 }

		 $SqlPayment = "insert into tbl_member_payment (p_title,p_membercode,p_memberemail,p_cardtype,p_cardnumber) values ('".$ptitle."','".$db_code."','".$db_email."','".$param_type."','".$newnumber."')";
		 $ResultPayment = $DatabaseClass->DataExecute($SqlPayment);
	}
}
?>