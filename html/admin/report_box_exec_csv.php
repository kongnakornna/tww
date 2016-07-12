<?php
require '../leone.php';
require './controller/member.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "box_rpt_" . date("jmYHs") . ".csv";
$member = new member();
$payment = new payment();
$partner = new partner();
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_mtype = (!empty($_REQUEST["mtype"])) ? $_REQUEST["mtype"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$dataList = "";
$num = 0;

if ($param_mtype=='1') {
	$mstation = "ดูผลรวม";
}else{
    $mstation = "แสดงเป็นรายการ";
}

$period = $param_sdate . " ถึง " . $param_edate;

$dataList = "จัดการรายงาน-ยอดการเติมเงินแต่ละ Topup จาก ".$param_type." - ".$mstation."\n\n";
$dataList .= "วันที่ : ".$period."\n";
$start_explode = explode("/", $param_sdate);
$start_day = $start_explode[0];
$start_month = $start_explode[1];
$start_year = $start_explode[2];

$end_explode = explode("/", $param_edate);
$end_day = $end_explode[0];
$end_month = $end_explode[1];
$end_year = $end_explode[2];

$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

if ($param_mtype=='1') {
    $dataList .= "ยอดรวม\n";
	$SqlCheck = "select * from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_station='".$param_type."' and p_type='A' and p_detail!='' order by p_id";
	$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
	$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
	if ($RowsCheck>0) {
		$mtotal = "0";
		for ($t=0;$t<$RowsCheck;$t++) {
			 $iNum++;
			 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
			 $db_billdate = $RowCheck['p_adddate'];
			 $db_ref2 = $RowCheck['p_ref2'];
			 $db_detail = $RowCheck['p_detail'];
			 $db_total = $RowCheck['p_price'];

			 $mtotal = $mtotal + $db_total;			 
		}
	}
	unset($RowCheck);
    $dataList .= "$mtotal\n";
}else{
	$dataList .= "#,วันที่/เวลาที่รับเงิน,เลขที่อ้างอิง,EasyCard,ชื่อสมาชิก,จำนวนเงิน\n";
	$SqlCheck = "select * from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_station='".$param_type."' and p_type='A' and p_detail!='' order by p_id";
	$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
	$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
	if ($RowsCheck>0) {
		for ($t=0;$t<$RowsCheck;$t++) {
			 $iNum++;
			 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
			 $db_billdate = $RowCheck['p_adddate'];
			 $db_station = $RowCheck['p_station'];
			 $db_ref1 = $RowCheck['p_ref1'];
			 $db_ref2 = $RowCheck['p_ref2'];
			 $db_detail = $RowCheck['p_detail'];
			 $db_email = $RowCheck['p_email'];
			 $db_total = $RowCheck['p_price'];

			 if ($db_station=='TWZ') {
				 $refcode = $db_ref1;
			 }else{
				 $refcode = $db_ref2;
			 }

			 $datebill = $DT->ShowDateTime($db_billdate,'en');
			 $custname = $member->getnamefromemail($db_email);
			 $dataList .= "$iNum,$datebill,$refcode,$db_detail,$custname,$db_total\n";
		}
	}
	unset($RowCheck);
}
$DatabaseClass->DBClose();

header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>

