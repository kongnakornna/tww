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
        <form action="report_all_exec_discount_other_admin.php" method="post" name="frmreport" id="frmreport">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">��§ҹ�ŵͺ᷹�ͧ��Ҫԡ�������᷹</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="right" valign="middle" class="barG">�ѹ�������� :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_sdate" id="s_sdate" style="width:300px;" readonly=readonly />*</td>
               </tr>
			   <tr>
                <td align="right" valign="middle" class="barG">�ѹ�������ش :&nbsp;</td>
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
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="��ŧ" />
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
