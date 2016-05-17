<?php
require '../leone.php';
require './controller/app.php';
require './controller/member.php';
require './controller/payment.php';
require './controller/partner.php';
require './controller/eservice.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "report_all_" . date("jmYHs") . ".csv";
$member = new member();
$payment = new payment();
$partner = new partner();
$eservice = new eservice();
$user = new user();
$app = new app();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;
$period = $param_sdate . " ¶Ö§ " . $param_edate;

$dataList = "ÃÒÂ§Ò¹¼ÅµÍºá·¹¢Í§µÑÇá·¹\n\n";
$dataList .= "ÇÑ¹·Õè : ".$period."\n";
$dataList .= "ÅÓ´Ñº·Õè,ÇÑ¹·Õè·ÓÃÒÂ¡ÒÃ,àÇÅÒ,ÃËÑÊÊÁÒªÔ¡,ª×èÍÊÁÒªÔ¡,ÃÒÂ¡ÒÃ,àºÍÃì·Õè·ÓÃÒÂ¡ÒÃ,ÂÍ´ÃÇÁ,àºÍÃì·ÕèàµÔÁ,ÂÍ´ÃÇÁ,¤èÒºÃÔ¡ÒÃ,ÂÍ´ÃÇÁ·Ñé§ÊÔé¹,¼ÅµÍºá·¹\n";
$RowCheck = array();
$memberid = $user->getmemberid($_SESSION['TWZUsername']);
$email = $member->getemailbycode($memberid);
if ($param_type == '' || $param_type == '01') {
$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid not in ('ES9999') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ÊèÇ¹Å´¨Ò¡¡ÒÃ·ÓÃÒÂ¡ÒÃàÍ§'  and p_email = '".$email."' order by p_adddate desc,p_partnercode";
}
else {
      if ($param_type == '02') {
       $SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid in ('ES9996','ES1001','ES1002') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ÊèÇ¹Å´¨Ò¡¡ÒÃ·ÓÃÒÂ¡ÒÃàÍ§' and p_email = '".$email."' order by p_adddate desc,p_partnercode"; 
      }
      if ($param_type == '03') {
         $SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid not in ('ES9996','ES1001','ES1002','ES9999','ES9997') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y')  and p_detail = 'ÊèÇ¹Å´¨Ò¡¡ÒÃ·ÓÃÒÂ¡ÒÃàÍ§' and p_email = '".$email."' order by p_adddate desc,p_partnercode"; 
      }
      if ($param_type == '04') {
          $SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid in ('ES9999','ES9997') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ÊèÇ¹Å´¨Ò¡¡ÒÃ·ÓÃÒÂ¡ÒÃàÍ§' and p_email = '".$email."' order by p_adddate desc,p_partnercode"; 
      }
}     
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$grandtotal = "0";
	for ($t=0;$t<$RowsCheck;$t++) {
		  $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_code = $RowCheck['p_productid'];
		 $db_pncode = $RowCheck['p_partnercode'];
		 $db_email = $RowCheck['p_email'];
		 $db_detail = $RowCheck['p_detail'];
		 $db_date = $DT->ShowDate($RowCheck['p_adddate'],'th');
		 $db_time = $DT->ShowTime($RowCheck['p_adddate']);
		 $db_discount = $RowCheck['p_price'];
		 $db_total = $RowCheck['p_ref1'];
		 $db_charge = $RowCheck['p_ref2'];
		 $db_price = $db_total - $db_charge;
                 $db_msisdn = $RowCheck['p_msisdn']; 
		  
		 $custname = $member->getnamefromemail($db_email);
		 $custmobile = $member->getmobilefromemail($db_email);
		 $custcode = $member->getcodefromemail($db_email);
		 $codename = $eservice->gettitle($db_code);
		 $partnername = $partner->getnamebycode($db_pncode);

		 $grandprice = $grandprice + $db_price;
		 $grandcharge = $grandcharge + $db_charge;
		 $grandtotal = $grandtotal + $db_total;
		 $granddiscount = $granddiscount + $db_discount;
                 $dataList .= $iNum.",".$db_date.",".$db_time.",".$custcode.",".$custname.",".$codename.",".$db_msisdn.",".$db_price.",".$db_charge.",".$db_total.",".$db_discount."\n";
	}
        $dataList .= ",,,,,,,,ÂÍ´ÃÇÁ : ,".number_format($grandprice,2,'.',',').",".number_format($grandcharge,2,'.',',').",".number_format($grandtotal,2,'.',',')."\n";
}

unset($RowCheck);
$DatabaseClass->DBClose();


header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>
