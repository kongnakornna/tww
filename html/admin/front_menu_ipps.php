<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis620');
require './controller/partner.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$pagelist = "";
$DataList = "";
$pagelist = "";
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_functionfront.inc.php');?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('.add').button();
	$("#btnSavePaymentTwz").click(function(){
		document.location.href="front_paymentview_form.php";
    });

	$("#btnPaymentTwz").click(function(){
		document.location.href="front_payment_form.php";
    });

	$("#btnPaymentTwz_ipps").click(function(){
		document.location.href="front_payment_form_ipps.php";
    });

	$("#btnOnlineTwz").click(function(){
		document.location.href="front_online_form.php";
    });

	$("#btnLogout").click(function(){
		document.location.href="logout.php";
    });
});
//-->
</script>
</head>

<body class="bgbd">
<div style="width:100%;">
<?php
	include ("_header_in.inc.php");
?>

<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18" align="left" valign="top" background="images/obj_06.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
    <td class="warea frameoutside"><table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td height="580" align="center" valign="top" ><br /><br />
        <button name="btnPaymentTwz" id="btnPaymentTwz" type="button" class="add" style="width:550px;font-size:36px; padding:22px; font-style:italic;">เติมเงิน บัตร EasyCard</button><br /><br /><br />
        <button name="btnPaymentTwz_ipps" id="btnPaymentTwz_ipps" type="button" class="add" style="width:550px;font-size:36px; padding:22px; font-style:italic;">เติมเงิน บัตร EasyCard Test</button><br /><br /><br />
        <button name="btnSavePaymentTwz" id="btnSavePaymentTwz" type="button" class="add" style="width:550px;font-size:36px; padding:22px; font-style:italic;">บันทึกการเติมเงิน</button><br /><br /><br />
        <button name="btnLogout" id="btnLogout" type="button" class="add" style="width:550px;font-size:36px; padding:22px; font-style:italic;">ออกจากระบบ</button>

        </td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
	<?php
		include ("_footer.inc.php");
	?>
    </table></td>
    <td width="18" align="left" valign="top" background="images/obj_08.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
  </tr>
</table>
</div>
</body>
</html>
