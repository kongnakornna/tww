<?php
require '../leone.php';
require './controller/member.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
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
$UserList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;

if ($param_mtype=='1') {
	$mstation = "ดูยอดรวม";
}else{
    $mstation = "แสดงเป็นรายการ";
}

$start_explode = explode("/", $param_sdate);
$start_day = $start_explode[0];
$start_month = $start_explode[1];
$start_year = $start_explode[2];

$end_explode = explode("/", $param_edate);
$end_day = $end_explode[0];
$end_month = $end_explode[1];
$end_year = $end_explode[2];

//$startdate = gregoriantojd($start_month,$start_day,$start_year);
//$enddate = gregoriantojd($end_month,$end_day,$end_year);

//$date_total = $enddate-$startdate;
//if ($date_total=='0') $date_total = "1";


$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

if ($param_mtype=='1') {
	$mtotal = "0";
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
			 $db_total = $RowCheck['p_price'];

			 $mtotal = $mtotal + $db_total;
		}
	}
	unset($RowCheck);

	$UserList .= "<tr bgcolor=\"".$iColor."\"><td align=\"center\" class=\"tblist\">".number_format($mtotal,2,'.',',')."</td></tr>";
}else{
	$SqlCheck = "select * from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_station='".$param_type."' and p_type='A' and p_detail!='' order by p_id";
	$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
	$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
	if ($RowsCheck>0) {
		for ($t=0;$t<$RowsCheck;$t++) {
			 $iNum++;
			 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
			 $db_billdate = $RowCheck['p_adddate'];
			 $db_station = $RowCheck['p_station'];
			 $db_email = $RowCheck['p_email'];
			 $db_ref1 = $RowCheck['p_ref1'];
			 $db_ref2 = $RowCheck['p_ref2'];
			 $db_detail = $RowCheck['p_detail'];
			 $db_total = $RowCheck['p_price'];

			 if ($db_station=='TWZ') {
				 $refcode = $db_ref1;
			 }else{
				 $refcode = $db_ref2;
			 }

			 $custname = $member->getnamefromemail($db_email);

			 $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$DT->ShowDateTime($db_billdate,'en')."</td><td align=\"center\" class=\"tblist\">".$refcode."</td><td align=\"center\" class=\"tblist\">".$db_detail."</td><td align=\"center\" class=\"tblist\">".$custname."</td><td align=\"center\" class=\"tblist\">".number_format($db_total,2,'.',',')."</td></tr>";
		}
	}
	unset($RowCheck);
}
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_function.inc.php');?>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {
    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-print' } });
});
//-->
</SCRIPT>
</head>

<body class="bgbd">
<?php
	include ("_header.inc.php");
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18" align="left" valign="top" background="images/obj_06.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
    <td class="warea frameoutside"><table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td width="200" class="sidearea">
        <?php
			include ("_sidebar.inc.php");
		?>        </td>
        <td height="480" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการรายงาน-ยอดการเติมเงินแต่ละ Topup จาก <?php echo $param_type;?> - <?php echo $mstation;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:30px;"><b>วันที่ </b><?php echo $period;?></td></tr>
<?php
if ($param_mtype=='1') {
?>
                    <tr>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดรวม</strong></td>
                    </tr>
                    <?php echo $UserList;?>

<?php
}else{
?>
                    <tr>
                      <td width="5%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>วันที่/เวลาที่รับเงิน</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เลขที่อ้างอิง</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>EasyCard</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อสมาชิก</strong></td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>จำนวนเงินรวมทั้งหมด</strong></td>
                    </tr>
                    <?php echo $UserList;?>
<?php
}
?>
                </table>               
				
					<br/><br/>      
				<form method="post" action="report_box_exec_csv.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />	
				<input type="hidden" name="type" value="<?php echo $param_type;?>" />	
				<input type="hidden" name="mtype" value="<?php echo $param_mtype;?>" />	
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="นำออก CSV" /></td></tr>
				</table> 
				</form>			
				
				</td>
              </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="sidearea"><img src="images/spacer.gif" width="200" height="1" /></td>
        <td align="left" valign="top"><img src="images/spacer.gif" width="772" height="1" /></td>
      </tr>
	<?php
		include ("_footer.inc.php");
	?>
    </table></td>
    <td width="18" align="left" valign="top" background="images/obj_08.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
  </tr>
</table>


</body>
</html>
