<?php
require '../leone.php';
require './controller/app.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "summary_" . date("jmYHs") . ".csv";
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

$dataList = "ยอดการรายงาน-ยอดขายรวมทุกร้านค้า\n\n";
$dataList .= "วันที่ : ".$period."\n";
$dataList .= "#,รหัสร้านค้า,ชื่อร้านค้า,ยอดรวม,ค่าบริการ,ยอดรวมทั้งสิ้น\n";

$RowCheck = array();
$SqlCheck = "select p_id,p_partnercode,p_productid,sum(p_price) as price,sum(p_charge) as charge,sum(p_total) as total from tbl_payment,tbl_confirmpin where  (p_ref=cp_ref) and cp_respurl_rec='OK' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('I') and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_partnercode order by p_partnercode";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$grandtotal = "0";
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_code = $RowCheck['p_productid'];
		 $db_pncode = $RowCheck['p_partnercode'];
		 $db_price = $RowCheck['price'];
		 $db_charge = $RowCheck['charge'];
		 $db_total = $RowCheck['total'];

		 $partnername = $partner->getnamebycode($db_pncode);

		 $grandprice = $grandprice + $db_price;
		 $grandcharge = $grandcharge + $db_charge;
		 $grandtotal = $grandtotal + $db_total;
         $dataList .= $iNum.".,".$db_pncode.",".$partnername.",".number_format($db_price,2,'.',',').",".number_format($db_charge,2,'.',',').",".number_format($db_total,2,'.',',')."\n";
	}
}
$dataList .= ",,ยอดรวม : ,".number_format($grandprice,2,'.',',').",".number_format($grandcharge,2,'.',',').",".number_format($grandtotal,2,'.',',')."\n";

unset($RowCheck);
$DatabaseClass->DBClose();


header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>