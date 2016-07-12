<?php
include "leone.php";
if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
include "./admin/controller/payment.php";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
$payment = new payment();
$filename = "rpt_" . date("jmYHs") . ".csv";
$paymentdata = $payment->getbuyhistorydataall($_SESSION['TWEmail']);

$dataList = "����¡�ë����Թ���\n\n";
$dataList .= "#,�ѹ������ҷ�����,�����Թ���,�Ҥҷ�����,��ҹ������\n";

for ($p=0;$p<count($paymentdata);$p++) {
	  $iNum++;
	  $db_id = stripslashes($paymentdata[$p]['p_id']);
	  $db_type = stripslashes($paymentdata[$p]['p_type']);
	  $db_product = stripslashes($paymentdata[$p]['p_productid']);
	  $db_price = stripslashes($paymentdata[$p]['p_price']);
	  $db_partner = stripslashes($paymentdata[$p]['p_partnercode']);	  
	  $db_ref1 = stripslashes($paymentdata[$p]['p_ref1']);	  
	  $db_detail = stripslashes($paymentdata[$p]['p_detail']);
	  $db_date = $DT->ShowDateTime($paymentdata[$p]['p_adddate'],'en');
	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

	  $partnertitle = $partner->getnamebycode($db_partner);
      
	  if ($db_type=='B') {
	      $apptitle = $app->gettitle($db_product);
	  }else{
	      $apptitle = $db_ref1;
	  }

      $dataList .= "$iNum,$db_date,$apptitle,$db_price �.,$partnertitle\n";
}

$DatabaseClass->DBClose();
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>