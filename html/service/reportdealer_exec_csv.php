<?php
require '../leone.php';
require './controller/payment.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['klogin'])) $Web->Redirect("index.php");
$filename = "dcode_rpt_" . date("jmYHs") . ".csv";
$payment = new payment();
$user = new user();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;

$dataList = "รายชื่อที่ทำการสมัครสมาชิก โดย D-Code\n\n";
$dataList .= "วันที่ : ".$period."\n";
$dataList .= "#,ชื่อสมาชิก,จำนวนเงิน\n";

$SqlCheck = "select * from tbl_member,tbl_payment where (m_email=p_email) and (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_dcode='".$_SESSION['TWZUsername']."' and p_type='A' and p_status='1' order by m_adddate";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $dbs_email = $RowCheck['m_email'];
		 $dbs_code = $RowCheck['m_code'];
		 $dbs_rdate = $DT->ShowDate($RowCheck['m_registerdate']);
		 $dbs_fullname = $RowCheck['m_fullname'];
		 $dbs_price = $RowCheck['m_price'];
		 if ($payment->getfirstwalletdata($dbs_email,$dbs_code)) {
            $eAnswer = "เติมแล้ว";
		 }else{
            $eAnswer = "ยังไม่เติม";
		 }
		 $dataList .= "$iNum,$dbs_fullname,$eAnswer\n";
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