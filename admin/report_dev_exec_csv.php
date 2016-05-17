<?php
require '../leone.php';
require './controller/app.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "dev_rpt_" . date("jmYHs") . ".csv";
$app = new app();
$payment = new payment();
$partner = new partner();
$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_appid = (!empty($_REQUEST["appid"])) ? $_REQUEST["appid"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

$iNum = 0;

if ($param_type=='F') {
  $SqlCriteria1 = " and p_price='0'";
}else if ($param_type=='B') {
  $SqlCriteria1 = " and p_price>0";
}else{
  $SqlCriteria1 = " and p_price>0";
}
$partnercode = $partner->getcode($param_partner);
$partnertitle = $partner->getnamebycode($partnercode);

$period = $param_sdate . " ¶Ö§ " . $param_edate;

$dataList = "¨Ñ´¡ÒÃÃÒÂ§Ò¹-ÂÍ´¢ÒÂáµèÅĞÃéÒ¹¤éÒ\n\n";

if ($param_appid=='') {
    $dataList .= "#,ª×èÍÃéÒ¹¤éÒ,ª×èÍ¼ÙéÃèÇÁ¤éÒ,ÂÍ´¢ÒÂÊÔ¹¤éÒ·Ø¡ÃÒÂ¡ÒÃ,ÇÑ¹·Õè,ÊèÇ¹áºè§\n";
}else{
	$dataList .= "ª×èÍÃéÒ¹¤éÒ : ".$partnertitle."\n";
	$dataList .= "ÇÑ¹·Õè : ".$period."\n";
	$dataList .= "#,ÃËÑÊáÍ»,ª×èÍáÍ»,ÃÒ¤Ò·Ñé§ËÁ´,ÊèÇ¹áºè§\n";
}

if ($param_type=='F') {
	if ($param_appid=='') {
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='B' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') $SqlCriteria1 group by p_productid order by p_productid";
	}else{
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where p_productid='".$param_appid."' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_productid order by p_productid";
	}
}else if ($param_type=='B') {
	if ($param_appid=='') {
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='I' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') $SqlCriteria1 group by p_productid order by p_productid";
	}else{
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and p_detail='".$param_appid."' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='I' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_productid order by p_productid";
	}
}else{
	if ($param_appid=='') {
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='".$param_type."' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') $SqlCriteria1 group by p_productid order by p_productid";
	}else{
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where p_detail='".$param_appid."' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_productid order by p_productid";
	}
}
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_productid'];
		 $db_detail = cvf($RowCheck['p_detail']);
		 $db_code = $RowCheck['p_partnercode'];
		 $db_total = $RowCheck['Total'];

         $share = $partner->getshareapp($db_code,"B");
		 $sharetotal = $db_total * ($share/100);

	     if ($param_type=='B' || $param_type=='F') {
		    $appcode = $app->getcode($db_id);
			$apptitle = $app->gettitle($db_id);
			if ($apptitle=='') $apptitle = $db_detail;
		 }else{
		    $appcode = "-";
			$apptitle = $db_detail;
		 }

		 if ($param_appid=='') {
            $dataList .= "$iNum,$partnertitle,$apptitle,".number_format($db_total,2,'.',',').",$period,".number_format($sharetotal,2,'.',',')."\n";
		 }else{
		    $dataList .= "$iNum,$appcode,$apptitle,".number_format($db_total,2,'.',',').",".number_format($sharetotal,2,'.',',')."\n";
		 }
	}
}

unset($RowCheck);
$DatabaseClass->DBClose();


header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>
<?php 
function cvf ($value) {
 
   $value1 = str_replace (","," ",$value);
   $value2 = str_replace (array("\n", "\r")," ",$value1);

   return $value2;
}
?>