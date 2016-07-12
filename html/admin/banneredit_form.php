<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$DateNow = date ("j M Y");


$SqlCheck = "select * from tbl_banner where b_id='".$param_id."' order by b_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['b_id'];
		 $db_title = stripslashes($RowCheck['b_title']);
		 $db_url = stripslashes($RowCheck['b_url']);
		 $db_file = stripslashes($RowCheck['b_file']);
		 $db_fileapp = stripslashes($RowCheck['b_fileapp']);
		 $db_startdate = stripslashes($RowCheck['b_startdate']);
		 $db_enddate = stripslashes($RowCheck['b_enddate']);
		 $db_sdate = $DT->ShowDateValue($RowCheck['b_startdate']);
		 $db_edate = $DT->ShowDateValue($RowCheck['b_enddate']);
	}
    if ($db_file=='') {
		$img1 = "";
	}else{
        $img1 = "<img src=\"../../photo/".$db_file."\" width=\"200\" border=\"0\" />&nbsp;&nbsp;<a href=\"banner_del_photo.php?type=1&id=".$param_id."\"  onclick=\"return confirmLink(this, 'ลบรูปภาพ ?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete photo\"/></a><br/>";
	}

    if ($db_fileapp=='') {
		$img2 = "";
	}else{
        $img2 = "<img src=\"../../photo/".$db_fileapp."\" width=\"200\" border=\"0\" />&nbsp;&nbsp;<a href=\"banner_del_photo.php?type=2&id=".$param_id."\"  onclick=\"return confirmLink(this, 'ลบรูปภาพ ?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete photo\"/></a><br/>";
	}
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
        <form action="banneredit_exec.php" enctype="multipart/form-data" method="post" name="frmAddBanner" id="frmAddBanner">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
		<input type="hidden" id="oldfile" name="oldfile" value="<?php echo $db_file;?>" />
		<input type="hidden" id="oldfileapp" name="oldfileapp" value="<?php echo $db_fileapp;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการข้อมูลกลาง-ปรับปรุงป้ายโฆษณาหน้าแรก (Web/App)</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อป้ายโฆษณา :&nbsp;</td>
                <td class="linemenu"><input type="text" name="title" id="title" maxlength="100" style="width:300px;" value="<?php echo $db_title;?>" />*</td>
                <td align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td class="linemenu"><?php echo $DateNow;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">วันที่เริ่ม :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_sdate" id="s_sdate" style="width:300px;" value="<?php echo $db_sdate;?>" />*</td>
                <td align="right" valign="middle" class="barG">วันที่สิ้นสุด :&nbsp;</td>
                <td class="linemenu"><input type="text" name="s_edate" id="s_edate" style="width:300px;" value="<?php echo $db_edate;?>" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">URL :&nbsp;</td>
                <td class="linemenu"><input type="text" name="url" id="url" maxlength="100" value="<?php echo $db_url;?>" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu"></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ไฟล์ป้ายโฆษณา (สำหรับ Web) :&nbsp;<br/><font color="#ff0000">Size : 560x90</font></td>
                <td class="linemenu"><?php echo $img1;?><input type="file" name="image1" id="image1" style="width:400px;" />*</td>
                <td align="right" valign="middle" class="barG">ไฟล์ป้ายโฆษณา (สำหรับ App) :&nbsp;<br/><font color="#ff0000">Size : 600x100</font></td>
                <td class="linemenu"><?php echo $img2;?><input type="file" name="image2" id="image2" style="width:400px;" />*</td>
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
