<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
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
	$("#btnBack").click(function(){
		document.location.href="commissionconfig_view.php";
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
        <form action="commissionadd_exec.php" method="post" enctype="multipart/form-data" name="frmAddCommission" id="frmAddCommission">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">�Ѵ��üѧ��ҵͺ᷹ - �����ѧ��¡�ä�ҵͺ᷹</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">Commission Postpaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="com_1" id="com_1" maxlength="15" style="width:250px;" /></td>
                <td width="20%" align="right" valign="middle" class="barG">Commission Prepaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="com_2" id="com_2" maxlength="15" style="width:250px;" /></td>
              </tr>
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">TP Postpaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tp_1" id="tp_1" maxlength="15" style="width:250px;" /></td>
                <td width="20%" align="right" valign="middle" class="barG">TP Prepaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tp_2" id="tp_2" maxlength="15" style="width:250px;" /></td>
              </tr>
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">TPF Postpaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tpf_1" id="tpf_1" maxlength="15" style="width:250px;" /></td>
                <td width="20%" align="right" valign="middle" class="barG">TPF Prepaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tpf_2" id="tpf_2" maxlength="15" style="width:250px;" /></td>
              </tr>
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">TPA Postpaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tpa_1" id="tpa_1" maxlength="15" style="width:250px;" /></td>
                <td width="20%" align="right" valign="middle" class="barG">TPA Prepaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tpa_2" id="tpa_2" maxlength="15" style="width:250px;" /></td>
              </tr>
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">TPFA Postpaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tpfa_1" id="tpfa_1" maxlength="15" style="width:250px;" /></td>
                <td width="20%" align="right" valign="middle" class="barG">TPFA Prepaid :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="tpfa_2" id="tpfa_2" maxlength="15" style="width:250px;" /></td>
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