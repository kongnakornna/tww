<?php
require '../leone.php';
require './controller/province.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$province = new province();
$provincelist = $province->getgroupdd();
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
		document.location.href="partner_view.php?page=1";
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
        <form action="partneradd_exec.php" method="post" name="frmAddPartner" id="frmAddPartner">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">�Ѵ��ü��������� - ��������������</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="15%" align="right" valign="middle" class="barG">���ͼ��������� :&nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="fname" id="fname" maxlength="100" style="width:300px;" /></td>
                <td width="15%" align="right" valign="middle" class="barG">������ҹ��� : &nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="title" id="title" maxlength="100" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">������ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="email" id="email" maxlength="85" style="width:300px;" />*</td>
                <td align="right" valign="middle" class="barG">���ʼ�ҹ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="pname" id="pname" maxlength="15" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">������� :&nbsp;</td>
                <td class="linemenu" valign="middle"><input type="text" name="addr1" id="addr1" maxlength="100" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">�ѧ��Ѵ :&nbsp;</td>
                <td class="linemenu"><select name="province" id="province" style="width:300px;"><?php echo $provincelist;?></select></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">������ɳ���</td>
                <td class="linemenu"><input type="text" name="postcode" id="postcode" maxlength="5" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">�����Ţ���Ѿ�� :&nbsp;</td>
                <td class="linemenu" valign="middle"><input type="text" name="mobile" id="mobile" maxlength="35" style="width:300px;" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu">&nbsp;</td>
                <td align="right" valign="middle" class="barG">��ǹ�� % :&nbsp;</td>
                <td class="linemenu" valign="middle"><input type="text" name="share_app" id="share_app" maxlength="3" style="width:300px;" /></td>
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
