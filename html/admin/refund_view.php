<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/payment.php';
require './controller/eservice.php';

if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_refid = (!empty($_REQUEST["refid"])) ? $_REQUEST["refid"] : "";
$payment = new payment();
$eservice = new eservice();

if ($param_refid != '') {
$paymentdata = $payment->getpaymentdatabyrefcode_nodiscount($param_refid);
}
$totalrecords = count($paymentdata);
$totalpage = ceil ($totalrecords/$maxrec);
if ($page=='' || $page=='0' || $page=='1') {
   $page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($page-1));
   $max = $maxrec * $page;
}
if ($max > $totalrecords) $max = $totalrecords;

$iNum = 0;
$DataList = "";
$iColor = "#eeeeee";
for ($p=$min;$p<$max;$p++) {
	  $iNum++;
	  $db_productid = stripslashes($paymentdata[$p]['p_productid']);
	  $db_email = stripslashes($paymentdata[$p]['p_email']);
	  $db_price = stripslashes($paymentdata[$p]['p_price']);
	  $db_charge = stripslashes($paymentdata[$p]['p_charge']);
	  $db_total= stripslashes($paymentdata[$p]['p_total']);
	  $db_ref = stripslashes($paymentdata[$p]['p_ref']);	  
	  $db_txnid = stripslashes($paymentdata[$p]['p_txnid_wallet']);
      $db_adddate =  stripslashes($paymentdata[$p]['p_adddate']);	  
      $db_title = $eservice->gettitle($db_productid);


      if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"txt1 tblist\">".$db_adddate."</td><td align=\"center\" class=\"tblist\">".$db_title."</td><td align=\"center\" class=\"tblist\">".$db_email."</td><td align=\"center\" class=\"tblist\">".$db_ref."</td><td align=\"center\" class=\"tblist\">".$db_price."</td><td align=\"center\" class=\"tblist\">".$db_total."</td><td align=\"center\" class=\"tblist\">".$db_txnid."</td><td class=\"txt1 tblist\"><a href=\"refund_exec.php?email=$db_email&refid=$db_ref&txnid=$db_txnid\" onclick=\"return confirmLink(this, 'Refund Transaction?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"refund transaction\"/></a></td></tr>";
}


$pagelist = $Web->paging($totalrecords,$maxrec,$page,'');
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
	$('#s_sdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
	$('#s_edate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
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
            <td class="txttopicpage">แสดงรายการการชำระสินค้า</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top" class="txtsg">ค้นหา Reference ID:</td>
                      <td align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="refund_view.php" method="post" name="frmsearchref" id="frmsearchref">
                    <td width="400" height="37" align="left" valign="top"><input type="text" name="refid" id="refid" value="<?php echo $param_refid;?>" style="width:80%;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" /></td></form>
					  
                    <td align="right" valign="top">&nbsp;</td>
                  </tr></form>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
					  <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ลำดับที่</strong></td>
                      <td width="20%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>วันเวลาที่บันทึก</strong></td>
                      <td bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ชื่อรายการสินค้า</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>Email ผู้ทำรายการ</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>เลข Refid</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>ราคา</strong></td>
		  	          <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>ราคารวม</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>เลข txnid</strong></td>
                      <td width="5%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>Refund</strong></td>
                 
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
