<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis620');
require './controller/member.php';
require './controller/province.php';
require './controller/product.php';
require './controller/payment.php';

if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$province = new province();
$product = new product();
$payment = new payment();
$member = new member();
$mdata = $member->getdata($param_id);
$mdata_count = count($mdata);
if (count($mdata) > 0) {
	for ($p=0;$p < $mdata_count;$p++) {
		$m_id = $mdata[$p]['m_id'];
		$m_type = $mdata[$p]['m_type'];
		$m_imei = $mdata[$p]['m_imei'];
		$m_email = $mdata[$p]['m_email'];
		$m_fullname = $mdata[$p]['m_fullname'];
		$m_province = $mdata[$p]['m_province'];
		$m_mobile = $mdata[$p]['m_mobile'];
		$m_producttype = $mdata[$p]['m_producttype'];
		$m_productbrand = $mdata[$p]['m_productbrand'];
		$m_productmodel = $mdata[$p]['m_productmodel'];
		$m_code = $mdata[$p]['m_code'];
		$m_personal = $mdata[$p]['m_personal'];
		$m_cardid = $mdata[$p]['m_cardid'];
		$m_mcode = $mdata[$p]['m_mcode'];
		$m_saleid = $mdata[$p]['m_saleid'];
	}
	$cardno = $payment->getcardcodefromid($m_code);
	if ($m_type=='OTH'){
       $type1 = "";
	   $type2 = "checked";
	}else{
       $type1 = "checked";
	   $type2 = "";
	}
	$phonemodel = $m_productbrand . '@' . $m_productmodel;
	if ($m_personal=='Y') {
		$By = "บุคคลทั่วไป";
	}else{
		if ($m_mcode=='') {
			$By = "รหัสผู้ขาย " . $m_saleid;
		}else{
			$By = "รหัสตัวแทน " . $m_mcode;
		}
	}
}
$productlist = $product->getbrandmodeldd($phonemodel);
$provincelist = $province->getgroupdd($m_province);
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_functionfront.inc.php');?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('.add').button();
	$("#btnBack").click(function(){
		document.location.href="front_menu.php?page=1";
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
</script>
</head>

<body class="bgbd">
<div style="width:100%;">
<?php
	include ("_header_in.inc.php");
?>

<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18" align="left" valign="top" background="images/obj_06.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
    <td class="warea frameoutside"><table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td height="580" align="center" valign="top" >
		
		
		 <form action="front_onlinememberadd_exec.php" method="post" name="frmAddOnlineMember" id="frmAddOnlineMember" onsubmit="return confirm('คุณแน่ใจว่าต้องการเปลี่ยนแปลงข้อมูล หากแน่ใจ กด ตกลง หากไม่ต้องการ กด ยกเลิก');">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
		<input type="hidden" id="mcode" name="mcode" value="<?php echo $m_code;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">ข้อมูลสมาชิก</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">IMEI :&nbsp;</td>
                <td width="80%" class="linemenu"><?php echo $m_imei;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อ-นามสกุล :&nbsp;</td>
                <td class="linemenu"><?php echo $m_fullname;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">เลขที่บัตรประชาชน:&nbsp;</td>
                <td class="linemenu"><?php echo $m_cardid;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัสผ่าน :&nbsp;</td>
                <td class="linemenu"><input type="text" name="pname" id="pname" maxlength="15" style="width:300px;" />&nbsp;<font color="#ff0000"><i>** กรอกรหัสผ่านใหม่เมื่อต้องการเปลี่ยน</i></font></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">จังหวัด :&nbsp;</td>
                <td class="linemenu"><select name="province" id="province" style="width:300px;" disabled><?php echo $provincelist;?></select></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">เบอร์โทรศัพท์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="mobileno" id="mobileno" maxlength="35" style="width:300px;" value="<?php echo $m_mobile;?>" readonly=readonly /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัส EasyCard :&nbsp;</td>
                <td class="linemenu"><?php echo $m_code;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ที่มา :&nbsp;</td>
                <td class="linemenu"><?php echo $By;?></td>
              </tr>
			  <tr><td colspan="2">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">กลับไป</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="ยืนยัน" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="กลับไปค่าเริ่มต้น" />
					</td>
                  </tr>
                </table>
				
				</td></tr>
              </table>		
		 </form>
		</td></tr>
              </table>	
		</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
	<?php
		include ("_footer.inc.php");
	?>
    </table></td>
    <td width="18" align="left" valign="top" background="images/obj_08.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
  </tr>
</table>
</div>
</body>
</html>
