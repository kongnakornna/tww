<?php
require '../leone.php';
require './controller/app.php';
require './controller/member.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "report_all_" . date("jmYHs") . ".csv";
$member = new member();
$payment = new payment();
$partner = new partner();
$app = new app();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;
$period = $param_sdate . " ถึง " . $param_edate;

$dataList = "ยอดการรายงาน-ยอดขายทั้งหมด\n\n";
$dataList .= "วันที่ : ".$period."\n";
$dataList .= "#,รหัสสมาชิก,ชื่อสมาชิก,อีเมล์สมาชิก,เบอร์โทรศัพท์,วันที่ทำรายการ,ชื่อร้านค้า,รายการสินค้า,ยอดรวม,ค่าบริการ,ยอดรวมทั้งสิ้น\n";

$RowCheck = array();
$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('I') and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') order by p_partnercode";
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
		 $db_date = $DT->ShowDateTime($RowCheck['p_adddate'],'th');
		 $db_price = $RowCheck['p_price'];
		 $db_charge = $RowCheck['p_charge'];
		 $db_total = $RowCheck['p_total'];

		 $custname = $member->getnamefromemail($db_email);
		 $custmobile = $member->getmobilefromemail($db_email);
		 $custcode = $member->getcodefromemail($db_email);
		 $partnername = $partner->getnamebycode($db_pncode);

		 $grandprice = $grandprice + $db_price;
		 $grandcharge = $grandcharge + $db_charge;
		 $grandtotal = $grandtotal + $db_total;
         $dataList .= $iNum.".,".$custcode.",".$custname.",".$db_email.",".$custmobile.",".$db_date.",".$partnername.",".$db_detail.",".number_format($db_price,2,'.',',').",".number_format($db_charge,2,'.',',').",".number_format($db_total,2,'.',',')."\n";
	}
}
$dataList .= ",,,,,,,,ยอดรวม : ,".number_format($grandprice,2,'.',',').",".number_format($grandcharge,2,'.',',').",".number_format($grandtotal,2,'.',',')."\n";

unset($RowCheck);
$DatabaseClass->DBClose();


header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>