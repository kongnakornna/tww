<?php
require '../leone.php';
require './controller/product.php';
require './controller/member.php';
require './controller/province.php';
require './controller/bank.php';
require './controller/payment.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$province = new province();
$bank = new bank();
$payment = new payment();
$product = new product();
$member = new member();
$memberdata = $member->getdata($param_id);
for ($p=0;$p<count($memberdata);$p++) {
	  $db_id = stripslashes($memberdata[$p]['m_id']);
	  $db_type = stripslashes($memberdata[$p]['m_type']);
	  $db_code = stripslashes($memberdata[$p]['m_code']);
	  $db_fullname= stripslashes($memberdata[$p]['m_fullname']);	  
	  $db_province = stripslashes($memberdata[$p]['m_province']);	  
	  $db_mobile = stripslashes($memberdata[$p]['m_mobile']);
	  $db_status = stripslashes($memberdata[$p]['m_status']);
	  $db_imei = stripslashes($memberdata[$p]['m_imei']);	  
	  $db_email = stripslashes($memberdata[$p]['m_email']);
	  $db_saleid = stripslashes($memberdata[$p]['m_saleid']);
	  $db_dcode = stripslashes($memberdata[$p]['m_dcode']);
	  $db_personal = stripslashes($memberdata[$p]['m_personal']);
	  $db_cardid = stripslashes($memberdata[$p]['m_cardid']);
	  $db_bdate = stripslashes($memberdata[$p]['m_bdate']);
	  $db_address = stripslashes($memberdata[$p]['m_address']);
	  $db_registerdate = stripslashes($memberdata[$p]['m_registerdate']);	  
	  $db_bankid = stripslashes($memberdata[$p]['m_bankid']);	  
	  $db_bankcode = stripslashes($memberdata[$p]['m_bankcode']);

	  $birthdate = $DT->ShowDateValue($db_bdate);
	  $registerdate = $DT->ShowDate($db_registerdate,'th');
	  $banklist = $bank->getlistdd($db_bankid);
}
$phonemodel = $db_productbrand . '@' . $db_productmodel;
$cardno = $payment->getcardcodefromid($db_code);
$provincelist = $province->getgroupdd($db_province);
$productlist = $product->getbrandmodeldd($phonemodel);

if ($db_personal=='Y') {
	$By = "บุคคลทั่วไป";
}else{
	if ($db_dcode=='') {
		$By = "รหัสผู้ขาย " . $db_saleid;
	}else{
		$By = "รหัสตัวแทน " . $db_dcode;
	}
}

if ($db_status=='1') {
	$status = "<input type=\"radio\" name=\"status\" id=\"status\" value=\"1\" checked>&nbsp;ปกติ&nbsp;&nbsp;<input type=\"radio\" name=\"status\" id=\"status\" value=\"9\">&nbsp;ปิดบัตร";
}else{
	$status = "<input type=\"radio\" name=\"status\" id=\"status\" value=\"1\">&nbsp;ปกติ&nbsp;&nbsp;<input type=\"radio\" name=\"status\" id=\"status\" value=\"9\" checked>&nbsp;ปิดบัตร";
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
		document.location.href="member_view.php?page=1";
    }); 

	$("#btnEmail").click(function(){
		document.location.href="member_sendmail.php?id=<?php echo $param_id;?>";
    }); 

	$('.add0').button({ icons: { primary: 'ui-icon-search' } });

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

	$('#bdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
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
        <form action="memberedit_exec.php" method="post" name="frmAddMember" id="frmAddMember">
         <input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการรายการ - ปรับปรุงทะเบียน</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="15%" align="right" valign="middle" class="barG">วันที่ลงทะเบียน :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $registerdate;?></td>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu">&nbsp;</td>
              </tr>
              <tr>
                <td width="15%" align="right" valign="middle" class="barG">IMEI :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $db_imei;?></td>
                <td align="right" valign="middle" class="barG">อีเมล์ (ชื่อบัญชี):&nbsp;</td>
                <td class="linemenu"><input type="text" name="email" id="email" style="width:300px;" value="<?php echo $db_email;?>" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อ-นามสกุล :&nbsp;</td>
                <td class="linemenu"><input type="text" name="fname" id="fname" maxlength="75" style="width:300px;" value="<?php echo $db_fullname;?>" />*</td>
                <td align="right" valign="middle" class="barG">รหัสผ่าน : &nbsp;</td>
                <td class="linemenu"><input type="text" name="pname" id="pname" maxlength="15" style="width:300px;" />*<br/><font color="#ff0000"><i>** กรอกรหัสผ่านใหม่เมื่อต้องการเปลี่ยน</i></font></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">เลขที่บัตรประชาชน :&nbsp;</td>
                <td class="linemenu"><input type="text" name="cardid" id="cardid" maxlength="13" style="width:300px;" value="<?php echo $db_cardid;?>" />*</td>
                <td align="right" valign="middle" class="barG">วันเดือนปีเกิด : &nbsp;</td>
                <td class="linemenu"><input type="text" name="bdate" id="bdate" style="width:300px;" value="<?php echo $birthdate;?>" readonly=readonly /></td>
              </tr>
              <tr>                
                <td align="right" valign="middle" class="barG">ที่อยู่ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="address" id="address" maxlength="250" style="width:300px;" value="<?php echo $db_address;?>" /></td>
                <td align="right" valign="middle" class="barG">จังหวัด :&nbsp;</td>
                <td class="linemenu"><select name="province" id="province" style="width:300px;"><?php echo $provincelist;?></select>*</td>
              </tr>
              <tr>  
			  <td align="right" valign="middle" class="barG">เบอร์โทรศัพท์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="mobileno" id="mobileno" maxlength="35" style="width:300px;" value="<?php echo $db_mobile;?>" />*</td>
                <td align="right" valign="middle" class="barG">รหัส EasyCard : &nbsp;</td>
                <td class="linemenu"><?php echo $db_code;?></td>
              </tr>
              <tr>            

                <td align="right" valign="middle" class="barG">ธนาคาร :&nbsp;</td>
                <td class="linemenu"><select name="bankid" id="bankid" style="width:300px;"><?php echo $banklist;?></select></td>
                <td align="right" valign="middle" class="barG">เลขบัญชีธนาคาร : &nbsp;</td>
                <td class="linemenu"><input type="text" name="bankcode" id="bankcode" maxlength="35" style="width:300px;" value="<?php echo $db_bankcode;?>" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ผู้ลงทะเบียน : &nbsp;</td>
                <td class="linemenu"><?php echo $By;?></td>
                <td align="right" valign="middle" class="barG">สถานะบัตร : &nbsp;</td>
                <td class="linemenu"><?php echo $status;?></td>
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
                    <td align="right"><button name="btnEmail" id="btnEmail" type="button" class="add3">ส่งอีเมล์อีกครั้ง</button>&nbsp;&nbsp;<input type="submit" name="btnSubmit" id="btnSubmit" value="ตกลง" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="ล้างข้อมูล" />
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
