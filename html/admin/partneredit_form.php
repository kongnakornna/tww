<?php
require '../leone.php';
require './controller/province.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$province = new province();

$SqlCheck = "select * from tbl_partner where p_id='".$param_id."' order by p_id limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_fullname = stripslashes($RowCheck['p_fullname']);
		 $db_email = stripslashes($RowCheck['p_email']);
		 $db_title = stripslashes($RowCheck['p_title']);
		 $db_address1 = stripslashes($RowCheck['p_address1']);
		 $db_address2 = stripslashes($RowCheck['p_address2']);
		 $db_province = $RowCheck['p_province'];
		 $db_postcode = $RowCheck['p_postcode'];
		 $db_share_app = $RowCheck['p_share_app'];
		 $db_share_inapp = $RowCheck['p_share_inapp'];
		 $db_code = $RowCheck['p_code'];
		 $db_mobile = $RowCheck['p_mobile'];
		 $db_status = $RowCheck['p_status'];
	}
}
unset($RowCheck);
$provincelist = $province->getgroupdd($db_province);
if ($db_status=='1') {
	$status1 = "checked";
	$status2 = "";
}else{
	$status1 = "";
	$status2 = "checked";
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
		document.location.href="partner_view.php?page=1";
    }); 

	$("#btnEmail").click(function(){
		document.location.href="partner_setform.php?id=<?php echo $param_id;?>";
    }); 

    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$('#btnCancel').each(function(){
	   $(this).replaceWith('<button class="add2" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add2').button({ icons: { primary: 'ui-icon-circle-close' } });
	$('.add3').button({ icons: { primary: 'ui-icon-mail-open' } });
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
        <form action="partneredit_exec.php" method="post" name="frmUpdatePartner" id="frmUpdatePartner">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
		<input type="hidden" id="oldstatus" name="oldstatus" value="<?php echo $db_status;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการผู้ร่วมค้า - แก้ไขผู้ร่วมค้า</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="15%" align="right" valign="middle" class="barG">ชื่อผู้ร่วมค้า :&nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="fname" id="fname" maxlength="100" value="<?php echo $db_fullname;?>" style="width:300px;" /></td>
                <td width="15%" align="right" valign="middle" class="barG">ชื่อร้านค้า :&nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="title" id="title" maxlength="100" value="<?php echo $db_title;?>" style="width:300px;" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">อีเมล์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="email" id="email" value="<?php echo $db_email;?>" style="width:300px;" readonly=readonly /></td>
                <td align="right" valign="middle" class="barG">รหัสผ่าน :&nbsp;</td>
                <td class="linemenu"><input type="text" name="pname" id="pname" maxlength="15" style="width:300px;" /><br/><font color="#ff0000"><i>** กรอกรหัสผ่านใหม่เมื่อต้องการเปลี่ยน</i></font></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ที่อยู่ :&nbsp;</td>
                <td class="linemenu" valign="middle"><input type="text" name="addr1" id="addr1" maxlength="100" value="<?php echo $db_address1;?>" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">จังหวัด :&nbsp;</td>
                <td class="linemenu"><select name="province" id="province" style="width:300px;"><?php echo $provincelist;?></select></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัสไปรษณีย์</td>
                <td class="linemenu"><input type="text" name="postcode" id="postcode" maxlength="5" value="<?php echo $db_postcode;?>" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">หมายเลขโทรศัพท์ :&nbsp;</td>
                <td class="linemenu" valign="middle"><input type="text" name="mobile" id="mobile" maxlength="35" value="<?php echo $db_mobile;?>" style="width:300px;" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">สถานะการใช้งาน :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="status" name="status" value="1" <?php echo $status1;?> />&nbsp;ใช้งานได้&nbsp;&nbsp;<input type="radio" id="status" name="status" value="0" <?php echo $status2;?> />&nbsp;หยุดใช้งาน</td>
                <td align="right" valign="middle" class="barG">ส่วนแบ่ง % :&nbsp;</td>
                <td class="linemenu" valign="middle"><input type="text" name="share_app" id="share_app" maxlength="3" style="width:300px;" value="<?php echo $db_share_app;?>" /></td>
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
