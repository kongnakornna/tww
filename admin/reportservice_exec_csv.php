<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "service_rpt_" . date("jmYHs") . ".csv";
$param_service = (!empty($_REQUEST["service"])) ? $_REQUEST["service"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

$SqlTopic = "select * from tbl_subcategorie where s_serviceid='".$param_service."' order by s_id";
$ResultTopic = $DatabaseClass->DataExecute($SqlTopic);
$RowsTopic = $DatabaseClass->DBNumRows($ResultTopic);
if ($RowsTopic>0) {
	for ($t=0;$t<$RowsTopic;$t++) {
		 $RowTopic = $DatabaseClass->DBfetch_array($ResultTopic,$t);
		 $dbs_title = stripslashes($RowTopic['s_title']);
	}
}

$period = $param_sdate . " ถึง " . $param_edate;
$dataList = "รายงานยอดการใช้บริการ".$dbs_title."\n\n";
$dataList .= "วันที่ : ".$period."\n";
$dataList .= "#,วันที่ดำเนินการ,หมายเลขอ้างอิ,SessionId,เบอร์โทร,เบอร์โทรที่รับการโอน,สถานะ\n";

if ($param_service=='') {
   $ServSQL = "";
}else{
   $ServSQL = " and m_servicecode='".$param_service."'";
}
$SqlCheck = "select * from tbl_mpaytrans where (m_date>='".$startdate." 00:00:00' and m_date<='".$enddate." 59:59:59') and m_confirmstatus='Y' $ServSQL order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_mobileno = $RowCheck['m_mobileno'];
		 $db_refid = $RowCheck['m_refid'];
		 $db_tranid = $RowCheck['m_tranid'];
		 $db_sessionid = $RowCheck['m_sessionid'];
		 $db_email = $RowCheck['m_email'];
		 $db_date = $DT->ShowDateTime($RowCheck['m_date'],'th');
		 $db_payeemobileno = $RowCheck['m_payeemobileno'];
		 $db_serviceid = $RowCheck['m_serviceid'];
		 $db_status = $RowCheck['m_status'];
		 $db_mpaycode = $RowCheck['m_mpaycode'];
		 $db_respcode = $RowCheck['m_respcode'];
		 $db_confirmstatus = $RowCheck['db_confirmstatus'];

		 if (trim($db_confirmstatus)=='Y') {
			 $status = 'OK';
		 }else{
			 $status = 'FAIL';
		 }

         $dataList .= "$iNum,$db_date,$db_refid,$db_sessionid,$db_mobileno,$db_payeemobileno,$db_status\n";
	}
}
unset($RowCheck);
$DatabaseClass->DBClose();
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>
