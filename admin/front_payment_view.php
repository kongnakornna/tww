<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/member.php';
require './controller/payment.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_cardcode = (!empty($_REQUEST["cardcode"])) ? $_REQUEST["cardcode"] : "";
$param_price = (!empty($_REQUEST["price"])) ? $_REQUEST["price"] : "";
$param_ref1 = (!empty($_REQUEST["ref1"])) ? $_REQUEST["ref1"] : "";
$member = new member();
$payment = new payment();
$membercode = $payment->getmembercodefromcardno($param_cardcode);
$membername = $member->getnamefromcode($membercode);
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
	$('.add0').button({ icons: { primary: 'ui-icon-search' } });
	$("#btnBack").click(function(){
		history.back();
    }); 
	$("#btnCancel").click(function() {     
	    document.location.href="front_menu.php";
	}); 
    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
	$('.add2').button({ icons: { primary: 'ui-icon-circle-close' } });
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
        <td height="580" align="center" valign="top" >
		
		
		 <form action="front_payment_exec.php" method="post" name="frmPaymentView" id="frmPaymentView">
		 <input type="hidden" name="cardcode" id="cardcode" value="<?php echo $param_cardcode;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">����Թ �ѵ� EasyCard</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="20%" align="right" valign="middle" class="barG">�����Ţ�ѵ� :&nbsp;</td>
                <td width="80%" class="linemenu"><?php echo $param_cardcode;?></td>
			  </tr>
              <tr>
                <td width="20%" align="right" valign="middle" class="barG">������Ҫԡ :&nbsp;</td>
                <td width="80%" class="linemenu"><?php echo $membername;?></td>
			  </tr>
			  <tr>
                <td align="right" valign="middle" class="barG">�ӹǹ�Թ :&nbsp;</td>
                <td class="linemenu"><?php echo $param_price;?><input type="hidden" name="price" id="price" maxlength="35" style="width:300px;" value="<?php echo $param_price;?>" /></td>
              </tr>
			  <tr>
                <td align="right" valign="middle" class="barG">�����˵� :&nbsp;</td>
                <td class="linemenu"><?php echo $param_ref1;?><input type="hidden" name="ref1" id="ref1" maxlength="55" style="width:300px;" value="<?php echo $param_ref1;?>" /></td>
              </tr>
			  <tr><td colspan="2">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">��Ѻ�</button>&nbsp;&nbsp;<button name="btnCancel" id="btnCancel" type="button" class="add2">¡��ԡ</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="�׹�ѹ" />
					</td>
                  </tr>
                </table>
				
				</td></tr>
              </table>		
		 </form>
		</td></tr>
              </table>	
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
