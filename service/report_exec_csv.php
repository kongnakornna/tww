<?php
require '../leone.php';
require './controller/payment.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['klogin'])) $Web->Redirect("index.php");
$filename = "sdcode_rpt_" . date("jmYHs") . ".csv";
$payment = new payment();
$user = new user();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$num = 0;

$period = $param_sdate . " ¶Ö§ " . $param_edate;

$dataList = "ÃÒÂª×èÍ·Õè·Ó¡ÒÃÊÁÑ¤ÃÊÁÒªÔ¡ â´Â SD-Code\n\n";
$dataList .= "ÇÑ¹·Õè : ".$period."\n";
$dataList .= "#,ª×èÍÊÁÒªÔ¡,ÍÕàÁÅìÊÁÒªÔ¡,Ê¶Ò¹ĞàµÔÁà§Ô¹\n";

$SqlCheck = "select * from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_saleid='".$_SESSION['TWZUsername']."' order by m_adddate";
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
            $eAnswer = "àµÔÁáÅéÇ";
		 }else{
            $eAnswer = "ÂÑ§äÁèàµÔÁ";
		 }

		 $dataList .= "$iNum,$dbs_fullname,$dbs_email,$eAnswer\n";
	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'');

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