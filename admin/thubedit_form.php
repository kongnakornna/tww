<?php
require '../leone.php';
require './controller/payment.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$payment = new payment();
$data = $payment->getcardcodedatafromid($param_id);

for ($p=0;$p<count($data);$p++) {
	  $db_id = stripslashes($data[$p]['p_id']);
	  $db_cardpayment = stripslashes($data[$p]['p_cardpayment']);
	  $db_membercode = stripslashes($data[$p]['p_membercode']);
}
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
	$("#btnBack").click(function(){
		document.location.href="thub_view.php?page=1";
    }); 

    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$('#btnCancel').each(function(){
	   $(this).replaceWith('<button class="add2" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add2').button({ icons: { primary: 'ui-icon-circle-close' } });
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
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
        <form action="thubedit_exec.php" method="post" name="frmthubupdate" id="frmthubupdate">
		  <input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">�Ѵ��â����š�ҧ - �����¡�� TWZpay Code</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="15%" align="right" valign="middle" class="barG">������Ҫԡ :&nbsp;</td>
                <td width="85%" class="linemenu"><input type="text" name="memberid" id="memberid" maxlength="35" style="width:300px;" value="<?php echo $db_membercode;?>" /></td>
              </tr>
              <tr>
                <td width="15%" align="right" valign="middle" class="barG">���� TWZpay :&nbsp;</td>
                <td width="85%" class="linemenu"><input type="text" name="mcode" id="mcode" maxlength="35" style="width:300px;" value="<?php echo $db_cardpayment;?>" readonly=readonly /></td>
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
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">��Ѻ�</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="��ŧ" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="��ҧ������" />
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
