<?php
require '../leone.php';
require './controller/payment.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "dcode_rpt_" . date("jmYHs") . ".csv";
$payment = new payment();
$user = new user();
$param_user = (!empty($_REQUEST["user"])) ? $_REQUEST["user"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$num = 0;

$period = $param_sdate . " ¶Ö§ " . $param_edate;

$dataList = "ÃÒÂ§Ò¹ÂÍ´ÊÁÑ¤ÃÊÁÒªÔ¡ â´Â D-Code\n\n";
$dataList .= "ÇÑ¹·Õè : ".$period."\n";
$dataList .= "#,ÃËÑÊ D-Code,ª×èÍ D-Code,¨Ó¹Ç¹ÊÁÒªÔ¡,àµÔÁà§Ô¹áÅéÇ\n";

if ($param_user=='') {
    $SqlCheck = "select m_dcode,count(*) as mtotal from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_dcode not in ('') group by m_dcode order by m_dcode";
}else{
    $SqlCheck = "select m_dcode,count(*) as mtotal from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_dcode='".$param_user."' group by m_dcode order by m_dcode";
}
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_code = $RowCheck['m_dcode'];
		 $db_total = $RowCheck['mtotal'];
		 $num = 0;

		 $SqlCheck1 = "select * from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_dcode='".$db_code."' order by m_dcode";
		 $ResultCheck1 = $DatabaseClass->DataExecute($SqlCheck1);
		 $RowsCheck1 = $DatabaseClass->DBNumRows($ResultCheck1);
		 if ($RowsCheck1>0) {
			 for ($r=0;$r<$RowsCheck1;$r++) {
				 $RowCheck1 = $DatabaseClass->DBfetch_array($ResultCheck1,$r);
				 $dbs_email = $RowCheck1['m_email'];
				 $dbs_price = $RowCheck1['m_price'];

				 if ($dbs_price==0) {
				     $firstbuy = $payment->getfirstbuy($dbs_email);
					 if ($firstbuy) {
					   $num++;
					 }
				 }else{
                     $num++;
				 }
			 }
		 }


		 $vars_name = $user->getdealername($db_code);

		 $dataList .= "$iNum,$db_code,$vars_name,$db_total,$num\n";

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