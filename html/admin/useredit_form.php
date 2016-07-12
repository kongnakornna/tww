<?php
require '../leone.php';
require './controller/permission.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$permission = new permission();

$SqlCheck = "select * from tbl_username where u_id='".$param_id."' order by u_id limit 0,1";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['u_id'];
		 $db_fullname = $RowCheck['u_fullname'];
		 $db_email = $RowCheck['u_email'];
		 $db_username = $RowCheck['u_username'];
		 $db_frontside = $RowCheck['u_frontside'];
		 $db_permission = $RowCheck['u_permission'];
		 $db_status = $RowCheck['u_status'];
	}
}
unset($RowCheck);
$permissionlist = $permission->getcheckboxlist($db_permission);
if ($db_status=='1') {
	$status1 = "checked";
	$status2 = "";
}else{
	$status1 = "";
	$status2 = "checked";
}
if ($db_frontside=='Y') {
	$frontside1 = "checked";
	$frontside2 = "";
}else{
	$frontside1 = "";
	$frontside2 = "checked";
}
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
		document.location.href="user_view.php?page=1";
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
        <form action="useredit_exec.php" method="post" name="frmUpdateUser" id="frmUpdateUser">
		  <input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการผู้ใช้งาน - ปรับปรุงผู้ใช้งาน ระบบ Back Office</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td align="right" valign="middle" class="barG">ชื่อเต็ม :&nbsp;</td>
                <td class="linemenu"><input type="text" name="fname" id="fname" maxlength="75" style="width:300px;" value="<?php echo $db_fullname;?>" />*</td>
                <td width="15%" align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $DateNow;?></td>
              </tr>
              <tr>
                <td width="15%" align="right" valign="middle" class="barG">Username :&nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="uname" id="uname" maxlength="15" style="width:300px;" value="<?php echo $db_username;?>" readonly=readonly /></td>
                <td align="right" valign="middle" class="barG">อีเมล์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="email" id="email" style="width:300px;" value="<?php echo $db_email;?>" />*</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="barG">Password :&nbsp;</td>
                <td class="linemenu" valign="top"><input type="text" name="pname" id="pname" maxlength="15" style="width:300px;" /><br/><font color="#ff0000"><i>** กรอกรหัสผ่านใหม่เมื่อต้องการเปลี่ยน</i></font></td>
                <td align="right" valign="top" class="barG">สิทธิ์ :&nbsp;</td>
                <td class="linemenu"><?php echo $permissionlist;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">สถานะการใช้งาน :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="status" name="status" value="1" <?php echo $status1;?> />&nbsp;ใช้งานได้&nbsp;&nbsp;<input type="radio" id="status" name="status" value="0" <?php echo $status2;?> />&nbsp;หยุดใช้งาน</td>
                <td align="right" valign="top" class="barG">&nbsp;</td>
                <td class="linemenu">&nbsp;</td>
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
