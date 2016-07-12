<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_service = (!empty($_REQUEST["service"])) ? $_REQUEST["service"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$servicename = "";
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

$SqlComCheck = "select * from tbl_mpayreport where m_service='".$param_service."' and (m_paydate>='".$startdate." 00:00:00' and m_paydate<='".$enddate." 59:59:59') and m_refund_amount='' order by m_paydate desc";
$ResultComCheck = $DatabaseClass->DataExecute($SqlComCheck);
$RowsComCheck = $DatabaseClass->DBNumRows($ResultComCheck);
if ($param_page=="") $param_page=1;
if ($param_page=="1") {
   $min = 0;
}else{
   $min = (($param_page-1)*$maxrec);
}
$numPage = ceil ($RowsComCheck/$maxrec);
if ($numPage==0) $numPage=1;
$iNum=$maxrec*($param_page-1);

$SqlCheck = "select * from tbl_mpayreport where m_service='".$param_service."' and (m_paydate>='".$startdate." 00:00:00' and m_paydate<='".$enddate." 59:59:59') and m_refund_amount='' order by m_paydate desc limit $min,$maxrec";
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

		 if ($iColor=='#eeeeee') {
			 $iColor = '#ffffff';
		 }else{
			 $iColor = '#eeeeee';
		 }

		 $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_date."</td><td align=\"center\" class=\"tblist\">".$db_refid."</td><td align=\"center\" class=\"tblist\">".$db_customerid."</td><td align=\"center\" class=\"tblist\">".$db_taxid."</td><td align=\"center\" class=\"tblist\">".$db_product_amount."</td><td align=\"center\" class=\"tblist\">".$db_fee_amount."</td><td align=\"center\" class=\"tblist\">".$db_total_amount."</td></tr>";

	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'service=' . $param_service . '&s_sdate=' . $param_sdate . '&s_edate='.$param_edate);

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
            <td class="txttopicpage">แสดงรายงานยอดการใช้บริการ mPay ในบริการ <?php echo $servicename;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:30px;"><b>วันที่ </b><?php echo $period;?></td></tr>
                    <tr>
                      <td width="2%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>วันเวลาที่ดำเนินการ</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>หมายเลขอ้างอิง</strong></td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>CustomerId</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>TaxId</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ราคาสินค้า</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ค่าธรรมเนียม</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ราคารวม</strong></td>
                    </tr>
                    <?php echo $UserList;?>
                </table>
				</td>
              </tr>
				              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr><td><?php echo $pagelist; ?></td></tr>
												              <tr>
                <td>&nbsp;</td>
              </tr>
			  <tr><td>
				<br/><br/>      
				<form method="post" action="reportmpay_exec_csv.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />
				<input type="hidden" name="service" value="<?php echo $param_service;?>" />		
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="นำออก CSV" /></td></tr>
				</table> 
				</form>
										</td>
              </tr>	              <tr>
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
