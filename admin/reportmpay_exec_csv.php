<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "mpay_rpt_" . date("jmYHs") . ".csv";

$param_service = (!empty($_REQUEST["service"])) ? $_REQUEST["service"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;

$SqlCheck = "select * from tbl_mpayreport where m_service='".$param_service."' order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $servicename = stripslashes(trim($RowCheck['m_service']));
	}
}


$period = $param_sdate . " ถึง " . $param_edate;
$dataList = "รายงานยอดการใช้บริการ mPay ในบริการ ".$servicename."\n\n";
$dataList .= "วันที่ : ".$period."\n";
$dataList .= "#,วันเวลาที่ดำเนินการ,หมายเลขอ้างอิง,CustomerId,TaxId,ราคาสินค้า,ค่าธรรมเนียม,ราคารวม\n";

$SqlCheck = "select * from tbl_mpayreport where m_service='".$param_service."' and (m_paydate>='".$startdate." 00:00:00' and m_paydate<='".$enddate." 59:59:59') and m_refund_amount='' order by m_paydate desc";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_customerid = $RowCheck['m_customerid'];
		 $db_refid = $RowCheck['m_ref1'];
		 $db_taxid = $RowCheck['m_taxid'];
		 $db_product_amount = $RowCheck['m_product_amount'];
		 $db_fee_amount = $RowCheck['m_fee_amount'];
		 $db_date = $DT->ShowDateTime($RowCheck['m_paydate'],'th');
		 $db_total_amount = $RowCheck['m_total_amount'];

		 $dataList .= "$iNum,$db_date,$db_refid,$db_customerid,$db_taxid,$db_product_amount,$db_fee_amount,$db_total_amount\n";

	}
}
unset($RowCheck);
$DatabaseClass->DBClose();
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>