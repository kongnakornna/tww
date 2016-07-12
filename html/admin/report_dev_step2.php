<?php
require '../leone.php';
require './controller/app.php';
require './controller/partner.php';
require './controller/payment.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$app = new app();
$partner = new partner();
$payment = new payment();
$partnercode = $partner->getcode($param_partner);
$param_type = "B";
if ($param_type=='B') {
   $sharetitle = "ชื่อสินค้าหรือบริการ";
   $applist = $payment->getapplist($partnercode);
}else if ($param_type=='F') {
   $sharetitle = "ชื่อสินค้าหรือบริการ";
   $applist = $app->getapplist($param_partner,"F");
}else{
   $sharetitle = "ชื่อสินค้าหรือบริการ";
   $applist = $payment->getapplist($partnercode);
}
$DateNow = date ("j M Y");
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
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

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
        <td height="480" align="left" valign="top">
        <form action="report_dev_exec.php" method="post" name="frmreport" id="frmreport">
		<input type="hidden" name="partner" id="partner" value="<?php echo $param_partner;?>" />
		<input type="hidden" name="type" id="type" value="<?php echo $param_type;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการรายงาน-ยอดขายแต่ละร้านค้า</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="20%" align="right" valign="middle" class="barG"><?php echo $sharetitle;?> :&nbsp;</td>
                <td width="80%" class="linemenu"><select name="appid" id="appid" style="width:300px;"><?php echo $applist;?></select></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">วันที่เริ่ม :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_sdate" id="s_sdate" style="width:300px;" readonly=readonly />*</td>
               </tr>
			   <tr>
                <td align="right" valign="middle" class="barG">วันที่สิ้นสุด :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_edate" id="s_edate" style="width:300px;" readonly=readonly />*</td>
              </tr>
              </table></td></tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td bgcolor="#9B9B9B"><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left">&nbsp;</td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="ตกลง" />
					</td>
                  </tr>
                </table>                
				</td>
              </tr>
        </table>
        </form>
        </td>
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
