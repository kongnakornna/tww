<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/payment.php';
include "./controller/app.php";
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_email = (!empty($_REQUEST["email"])) ? $_REQUEST["email"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);

if ($param_sdate=='') {
  $SQLSearch .= "";
}else{
  if (strlen ($SQLSearch) > 10) {
     $SQLSearch .= " and (m_registerdate>='".$startdate." 00:00:00' and m_registerdate<='".$enddate." 59:59:59')";
  }else{
     $SQLSearch .= " (m_registerdate>='".$startdate." 00:00:00' and m_registerdate<='".$enddate." 59:59:59')";
  }
}

$payment = new payment();
$app = new app();
$iNum = 0;

$totalrecords = $payment->getbookcount($param_email);
$totalpage = ceil ($totalrecords/$maxrec);
if ($param_page=='' || $param_page=='0' || $param_page=='1') {
   $param_page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($param_page-1));
   $max = $maxrec * $param_page;
}
if ($max > $totalrecords) $max = $totalrecords;
$iNum=$maxrec*($param_page-1);

$DataList = "";
$iColor = "#eeeeee";
$totalpay = 0;

$memberdata = $payment->getbook($param_email,$min,$maxrec);
for ($p=0;$p<$max;$p++) {
	  $iNum++;
	  $db_id = stripslashes($memberdata[$p]['p_id']);
	  $db_type = stripslashes($memberdata[$p]['p_type']);
	  $db_detail = stripslashes($memberdata[$p]['p_detail']);
	  $db_price = stripslashes($memberdata[$p]['p_price']);
	  $db_productid = stripslashes($memberdata[$p]['p_productid']);
	  $db_ref1 = stripslashes($memberdata[$p]['p_ref1']);
	  $db_ref2 = stripslashes($memberdata[$p]['p_ref2']);
	  $db_email = stripslashes($memberdata[$p]['p_email']);	  
	  $db_station = $memberdata[$p]['p_station'];
	  $db_paydate = $DT->ShowDateTime($memberdata[$p]['p_adddate'],'en');

	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

	  if ($db_type=='A') {
		  $moneyin = $db_price;
		  $moneyout = "";
		  $remark = "<a href=\"#\" onclick=\"datarun('".$db_ref2."');\">" . $db_ref2 . "</a>";
		  $totalpay = $totalpay + $db_price;
	  }else if ($db_type=='R') {
		  $moneyin = "";
		  $moneyout = $db_price;
		  $remark = "ยกเลิกการเติมเงิน";
		  $totalpay = $totalpay - $db_price;
	  }else if ($db_type=='B') {
          $moneyin = "";
          $moneyout = $db_price;
		  $apptitle = $app->gettitle($db_productid);
          $remark = "ซื้อสินค้า" . $apptitle;
		  $totalpay = $totalpay - $db_price;
	  }else if ($db_type=='I') {
          $moneyin = "";
          $moneyout = $db_price;
          $remark = "ซื้อสินค้า" . $db_detail;
		  $totalpay = $totalpay - $db_price;
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_paydate."</td><td align=\"right\" class=\"tblist\">".number_format($moneyin,2,'.',',')."</td><td align=\"right\" class=\"tblist\">".number_format($moneyout,2,'.',',')."</td><td align=\"right\" class=\"tblist\">".number_format($totalpay,2,'.',',')."</td><td align=\"left\" class=\"tblist\">".$remark."</a></td></tr>";
}


$pagelist = $Web->paging($totalrecords,$maxrec,$param_page,'');
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_function.inc.php');?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#s_sdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
	$('#s_edate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
});

function datarun(e) {
   window.open ("front_payment_print.php?orid=" + e,'_blank','width=800,height=600');
}
//-->
</script>
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
            <td class="txttopicpage">จัดการการเงิน-รายการเดินบัญชีสมาชิก</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                   <tr>
					  <form action="member_book_show.php" method="post" name="frmreport1" id="frmreport1">
					  <input type="hidden" id="email" name="email" value="<?php echo $param_email;?>" />
                    <td colspan="6" align="right" valign="top">ช่วงวันที่ <input type="text" name="s_sdate" id="s_sdate" style="width:120px;" value="<?php echo $param_sdate;?>" readonly=readonly />&nbsp;ถึง&nbsp;<input type="text" name="s_edate" id="s_edate" style="width:120px;" value="<?php echo $param_edate;?>" readonly=readonly />&nbsp;<input type="submit" name="btnSubmit2" id="btnSubmit2" value="ตกลง" /></td>
                  </tr></form>

                    <tr>
                      <td width="3%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>#</strong></td>
                      <td width="18%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>วันที่</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>เงินเข้า</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>เงินออก</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>คงเหลือ</strong></td>
                      <td bgcolor="#99cccc" class="tablehead tblist txt1"><strong>หมายเหตุ</strong></td>
                    </tr>
                    <?php echo $DataList;?>
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
