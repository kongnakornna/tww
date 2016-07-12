<?php
require '../leone.php';
require './controller/payment.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "sdcode_rpt_" . date("jmYHs") . ".csv";
$payment = new payment();
$user = new user();
$param_user = $_REQUEST["user"];
$param_sdate = $_REQUEST["s_sdate"];
$param_edate = $_REQUEST["s_edate"];
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

$period = $param_sdate . " ¶Ö§ " . $param_edate;

$dataList = "¨Ñ´¡ÒÃÃÒÂ§Ò¹-ÂÍ´ÊÁÑ¤ÃÊÁÒªÔ¡ â´Â SD-Code\n\n";
$dataList .= "ÇÑ¹·Õè : ".$period."\n";
$dataList .= "#,ÃËÑÊ SD-Code,ª×èÍ SD-Code,¨Ó¹Ç¹ÊÁÒªÔ¡,àµÔÁà§Ô¹áÅéÇ\n";

if ($param_user=='') {
    $SqlCheck = "select m_saleid,count(*) as mtotal from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_saleid not in ('') group by m_saleid order by m_saleid";
}else{
    $SqlCheck = "select m_saleid,count(*) as mtotal from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_saleid='".$param_user."' group by m_saleid order by m_saleid";
}
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_saleid = $RowCheck['m_saleid'];
		 $db_total = $RowCheck['mtotal'];

		 $num = 0;

		 $SqlCheck1 = "select * from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_saleid='".$db_saleid."' order by m_saleid";	
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

		 $vars_name = $user->getsalename($db_saleid);

		 $dataList .= "$iNum,$db_saleid,$vars_name,$db_total,$num\n";
	}
}
unset($RowCheck);

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