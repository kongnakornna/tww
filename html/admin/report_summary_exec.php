<?php
require '../leone.php';
require './controller/app.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$payment = new payment();
$partner = new partner();
$app = new app();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$DataList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;
$RowCheck = array();
$SqlCheck = "select p_id,p_partnercode,p_productid,sum(p_price) as price,sum(p_charge) as charge,sum(p_total) as total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('I') and p_reinstall NOT IN ('Y') and p_partnercode not in ('P07201500000') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_partnercode order by p_partnercode";
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

		 if ($iColor=='#ffffff') {
			 $iColor = "#eeeeee";
		 }else{
			 $iColor = "#ffffff";
		 }

         $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$iNum.".</td><td align=\"center\" class=\"tblist\">".$db_pncode."</td><td align=\"left\" class=\"tblist\">".$partnername."</td><td align=\"center\" class=\"tblist\">".number_format($db_price,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($db_charge,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($db_total,2,'.',',')."</strong></td></tr>";
	}
}
$DataList .= "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"right\" class=\"tblist\">ยอดรวม : </td><td align=\"center\" class=\"tblist\">".number_format($grandprice,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandcharge,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($grandtotal,2,'.',',')."</strong></td></tr>";

unset($RowCheck);
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
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });
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
            <td class="txttopicpage">ยอดการรายงาน-ยอดขายรวมทุกร้านค้า</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="5" valign="middle" style="height:30px;"><b>วันที่ </b><?php echo $period;?></td></tr>
                    <tr>
                      <td width="5%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รหัสร้านค้า</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อร้านค้า</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดรวม</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ค่าบริการ</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดรวมทั้งสิ้น</strong></td>
                    </tr>
                    <?php echo $DataList;?>
                </table>       <br/><br/>

						<form method="post" action="report_summary_exec_csv.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />	
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
