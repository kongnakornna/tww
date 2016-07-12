<?php
require '../leone.php';
require './controller/content.php';
require './controller/partner.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$content = new content();
$partner = new partner();
$partnerlist = $partner->getlistdd();
$catlist = $content->getlistdd();
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
		document.location.href="banner_view.php?page=1";
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
        <form action="banneradd_exec.php" enctype="multipart/form-data" method="post" name="frmAddBanner" id="frmAddBanner">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการข้อมูลกลาง-เพิ่มป้ายโฆษณาหน้าแรก (Web/App)</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อป้ายโฆษณา :&nbsp;</td>
                <td class="linemenu"><input type="text" name="title" id="title" maxlength="100" style="width:300px;" />*</td>
                <td align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td class="linemenu"><?php echo $DateNow;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">วันที่เริ่ม :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_sdate" id="s_sdate" style="width:300px;" />*</td>
                <td align="right" valign="middle" class="barG">วันที่สิ้นสุด :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_edate" id="s_edate" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">URL :&nbsp;</td>
                <td class="linemenu"><input type="text" name="url" id="url" maxlength="100" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu"></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ไฟล์ป้ายโฆษณา (สำหรับ Web) :&nbsp;<font color="#ff0000">Size : 560x90</font></td>
                <td class="linemenu"><input type="file" name="image1" id="image1" style="width:400px;" />*</td>
                <td align="right" valign="middle" class="barG">ไฟล์ป้ายโฆษณา (สำหรับ App) :&nbsp;<font color="#ff0000">Size : 600x100</font></td>
                <td class="linemenu"><input type="file" name="image2" id="image2" style="width:400px;" />*</td>
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
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">กลับไป</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="ตกลง" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="ล้างข้อมูล" />
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
