<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis620');
require './controller/product.php';
require './controller/province.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$province = new province();
$product = new product();
$provincelist = $province->getgroupdd();
$productlist = $product->getbrandmodeldd();
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
	$('.add0').button({ icons: { primary: 'ui-icon-search' } });
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
	$("#btnCheckImei").click(function(){
		 var m = document.getElementById("imeino").value;
		 if (m=='') {
             alert ("กรุณากรอกหมายเลข IMEI ด้วยค่ะ");
		 }else{
			 $.ajax({
				 type: "POST",
				 url: "checkimei.php",
				 data:"no=" + m,
				 async: true,
				 success: function(html) { ViewAlert(html); }
			 });
		 }
    });
});

function ViewAlert(e) {
  if (e=='OK') {
	   document.getElementById("imeino").readOnly = true;
	   document.getElementById("btnCheckImei").style.visibility = 'hidden';
	   document.getElementById("passcheck").value = "OK";
	   alert ("หมายเลข IMEI ตรงกับในระบบค่ะ");
  }else{
       document.getElementById("imeino").value = "";
	   alert ("หมายเลข IMEI ไม่มีในระบบค่ะ");
  }
}
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
		
		
		 <form action="front_memberadd_exec.php" method="post" name="frmAddMember" id="frmAddMember">
         <input type="hidden" id="passcheck" name="passcheck" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">ลงทะเบียนเครื่อง TWZ</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">IMEI :&nbsp;</td>
                <td width="80%" class="linemenu"><input type="text" name="imeino" id="imeino" maxlength="20" style="width:300px;" />&nbsp;<button name="btnCheckImei" id="btnCheckImei" type="button" class="add0" style="padding:-7px 0px; height:24px;" >ค้นหา</button></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ยี่ห้อมือถือ :&nbsp;</td>
                <td class="linemenu"><select name="brandname" id="brandname" style="width:300px;"><?php echo $productlist;?></select>*</td>
			  </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อเต็ม :&nbsp;</td>
                <td class="linemenu"><input type="text" name="fname" id="fname" maxlength="75" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">อีเมล์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="email" id="email" style="width:300px;" />*&nbsp;<font color="#ff0000"><i>** ใช้ @gmail.com เท่านั้น</i></font></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ที่อยู่ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="address1" id="address1" maxlength="100" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu"><input type="text" name="address2" id="address2" maxlength="100" style="width:300px;" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">จังหวัด :&nbsp;</td>
                <td class="linemenu"><select name="province" id="province" style="width:300px;"><?php echo $provincelist;?></select>*</td>
              </tr>

              <tr>
                <td align="right" valign="middle" class="barG">รหัสไปรษณีย์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="postcode" id="postcode" maxlength="5" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">เบอร์โทรศัพท์ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="mobileno" id="mobileno" maxlength="35" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัสบัตรชำระเงิน :&nbsp;</td>
                <td class="linemenu"><input type="text" name="paymentcardno" id="paymentcardno" maxlength="7" style="width:300px;" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัสผู้ขาย (SD-Code) :&nbsp;</td>
                <td class="linemenu"><input type="text" name="saleid" id="saleid" maxlength="35" style="width:300px;" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัสตัวแทน (D-Code) :&nbsp;</td>
                <td class="linemenu"><input type="text" name="mcode" id="mcode" maxlength="35" style="width:300px;" /></td>
              </tr>
			  <tr><td colspan="2">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">กลับไป</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="ตกลง" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="ล้างข้อมูล" />
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
