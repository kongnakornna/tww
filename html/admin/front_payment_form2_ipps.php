<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis620');
require './controller/member.php';
require './controller/payment.php';
require './controller/province.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_cardcode = (!empty($_REQUEST["cardcode"])) ? $_REQUEST["cardcode"] : "";
$member = new member();
$payment = new payment();
$province = new province();
$membercode = $payment->getmembercodefromcardno($param_cardcode);
$membername = $member->getnamefromcode($membercode);

$mdata = $member->getdatabycode($param_cardcode);
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
		$m_code = $mdata[$p]['m_code'];
		$m_personal = $mdata[$p]['m_personal'];
		$m_cardid = $mdata[$p]['m_cardid'];
		$m_mcode = $mdata[$p]['m_mcode'];
		$m_saleid = $mdata[$p]['m_saleid'];
	}
	$cardno = $payment->getcardcodefromid($m_code);
	$provincelist = $province->getname($m_province);

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
		
		
		 <form action="front_payment_view_ipps.php" method="post" name="frmPayment2" id="frmPayment2">
		 <input type="hidden" name="cardcode" id="cardcode" value="<?php echo $param_cardcode;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">เติมเงิน บัตร EasyCard</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="20%" align="right" valign="middle" class="barG">รหัส EasyCard :&nbsp;</td>
                <td width="80%" class="linemenu"><?php echo $param_cardcode;?></td>
			  </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อสมาชิก :&nbsp;</td>
                <td class="linemenu"><?php echo $membername;?></td>
			  </tr>
           <tr>
                <td align="right" valign="middle" class="barG">เลขที่บัตรประชาชน:&nbsp;</td>
                <td class="linemenu"><?php echo $m_cardid;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">จังหวัด :&nbsp;</td>
                <td class="linemenu"><?php echo $provincelist;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">เบอร์โทรศัพท์ :&nbsp;</td>
                <td class="linemenu"><?php echo $m_mobile;?></td>
              </tr>
			  <tr>
                <td align="right" valign="middle" class="barG">จำนวนเงิน :&nbsp;</td>
                <td class="linemenu"><input type="text" name="price" id="price" maxlength="35" style="width:300px;" />*</td>
              </tr>
			  <tr>
                <td align="right" valign="middle" class="barG">หมายเหตุ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="ref1" id="ref1" maxlength="75" style="width:300px;" /></td>
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
