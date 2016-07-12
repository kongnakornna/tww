<?php
require '../leone.php';
require './controller/bank.php';
require './controller/product.php';
require './controller/province.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$filename = "member_rpt_" . date("jmYHs") . ".csv";
$bank = new bank();
$product = new product();
$province = new province();
$user = new user();
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

$period = $param_sdate . " ¶Ö§ " . $param_edate;

$SqlCheck = "select * from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') order by m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);

$dataList = "¨Ñ´¡ÒÃÃÒÂ§Ò¹-ÂÍ´¼ÙéÅ§·ĞàºÕÂ¹ÊÁÒªÔ¡\n\n";
$dataList .= "ÇÑ¹·Õè : ".$period."\n";
$dataList .= "ÂÍ´ÊÁÒªÔ¡·Ñé§ËÁ´ : ".$RowsCheck." ¤¹\n";
$dataList .= "#,ÇÑ¹·ÕèÅ§·ĞàºÕÂ¹	,ÃËÑÊ EasyCard,ª×èÍÊÁÒªÔ¡,Ç/´/» à¡Ô´,àÅ¢·ÕèºÑµÃ»ÃĞªÒª¹,·ÕèÍÂÙè,¨Ñ§ËÇÑ´,àºÍÃìâ·Ã,ÍÕàÁÅì,IMEI,ÃËÑÊ¼ÙéÅ§·ĞàºÕÂ¹,ª×èÍ¼ÙéÅ§·ĞàºÕÂ¹,ÂÍ´à§Ô¹¤§àËÅ×Í,¸¹Ò¤ÒÃ,àÅ¢ºÑ­ªÕ¸¹Ò¤ÒÃ\n";


if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_fullname = $RowCheck['m_fullname'];
		 $db_email = $RowCheck['m_email'];
		 $db_province = $RowCheck['m_province'];
		 $db_mobile = $RowCheck['m_mobile'];
		 $db_code = $RowCheck['m_code'];
		 $db_registerdate = $DT->ShowDate($RowCheck['m_registerdate'],'th');
		 $db_bdate = $DT->ShowDate($RowCheck['m_bdate'],'th');
		 $db_saleid = $RowCheck['m_saleid'];
		 $db_dcode = $RowCheck['m_dcode'];
		 $db_imei = $RowCheck['m_imei'];
		 $db_price = $RowCheck['m_price'];

		 $db_cardid = $RowCheck['m_cardid'];
		 $db_address = $RowCheck['m_address'];
		 $db_bankid = $RowCheck['m_bankid'];
		 $db_bankcode = $RowCheck['m_bankcode'];

		 $banktitle = $bank->gettitle($db_bankid);
		 $provincetitle = $province->getname($db_province);
		 $dname = "";
		 $By = "";
		 if ($db_dcode=='') {
			$By = $db_saleid;
			$dname = $user->getsalename($db_saleid);
		 }else{
			$By = $db_dcode;
			$dname = $user->getdealername($db_dcode);
		 }

         $dataList .= "$iNum,$db_registerdate,$db_code,$db_fullname,$db_bdate,$db_cardid,$db_address,$provincetitle,$db_mobile,$db_email,$db_imei,$By,$dname,$db_price,$banktitle,$db_bankcode\n";
	}
}
unset($RowCheck);
$DatabaseClass->DBClose();
header('Content-Disposition: attachment; filename="' . $filename . '"');
header("Content-type: application/x-msexcel"); 
header('Pragma: no-cache');
print $dataList;
?>
