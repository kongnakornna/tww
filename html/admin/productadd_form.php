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
		document.location.href="product_view.php?page=1";
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
        <form action="productadd_exec.php" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">แนะนำร้านที่ใช้ EasyCard ได้ - สร้างข้อมูลร้านค้า</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="15%" align="right" valign="middle" class="barG">ชื่อร้านค้า :&nbsp;</td>
                <td width="35%" class="linemenu"><select name="partnerid" id="partnerid" style="width:300px;"><?php echo $partnerlist;?></select>*</td>
                <td width="15%" align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $DateNow;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อบริการ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="title" id="title" maxlength="75" style="width:300px;" />*</td>
                <td align="right" valign="middle" class="barG">ประเภทร้านค้า :&nbsp;</td>
                <td class="linemenu"><select name="categorie" id="categorie" style="width:300px;"><?php echo $catlist;?></select>*</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="barG">รายละเอียด :&nbsp;</td>
                <td class="linemenu" valign="top"><textarea name="detail" id="detail" rows="15" style="width:300px;"></textarea>*</td>
                <td align="right" valign="top" class="barG">อะไรใหม่ :&nbsp;</td>
                <td class="linemenu"><textarea name="whatnew" id="whatnew" rows="15" style="width:300px;"></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ประเภทการแสดงผล :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="showtype" name="showtype" value="1" checked />&nbsp;Apk&nbsp;&nbsp;<input type="radio" id="showtype" name="showtype" value="2" />&nbsp;Web Site</td>
                <td align="right" valign="middle" class="barG">URL App : <br/><font color="#ff0000" style="font-size:8px;">(กรณีที่ฝากไว้ที่ Play Store)</font>&nbsp;</td>
                <td class="linemenu"><input type="text" name="url" id="url" style="width:300px;" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ไฟล์ Apk :&nbsp;</td>
                <td class="linemenu"><input type="file" name="image1" id="image1" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu">&nbsp;</td>
              </tr>
              <tr>
			    <td align="right" valign="middle" class="barG">URL Clip ตัวอย่าง (YouTube) :&nbsp;</td>
                <td class="linemenu"><input type="text" name="clipurl" id="clipurl" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">สถานะ :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="status" name="status" value="1" checked />&nbsp;Active&nbsp;&nbsp;<input type="radio" id="status" name="status" value="0" />&nbsp;Inactive</td>
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
