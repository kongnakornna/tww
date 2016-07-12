<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/payment.php';
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$payment = new payment();
$iColor = "#ffffff";
$list = "";
$no = 0;
$mdata = $payment->getdatafromkeyword($param_keyword);
$mdata_count = count($mdata);
if (count($mdata) > 0) {
	$list .= "<table width=\"95%\" cellpadding=\"1\" border=\"0\" cellspacing=\"1\">";
    $list .= "<tr bgcolor=\"#c0c0c0\"><td align=\"center\" width=\"3%\">#</td><td width=\"25%\" align=\"center\">วันที่และเวลาเติมเงิน</td><td align=\"center\" width=\"25%\">จำนวนเงิน</td><td align=\"center\">หมายเลขใบเสร็จ</td></tr>\n";
	for ($p=0;$p < $mdata_count;$p++) {
		$no++;
		$m_id = $mdata[$p]['p_id'];
		$m_price = $mdata[$p]['p_price'];
		$m_date = $mdata[$p]['p_adddate'];
		$m_ref1 = $mdata[$p]['p_ref1'];
		$m_ref2 = $mdata[$p]['p_ref2'];
		$m_status = $mdata[$p]['p_status'];

		if ($iColor=='#ffffff') {
			$iColor = "#e4e4e4";
		}else{
            $iColor = "#ffffff";
		}

		if ($m_status=='9') {
           $list .= "<tr bgcolor='".$iColor."' style=\"cursor:pointer;\"><td align=\"right\" onclick=\"datarun('".$m_ref1."-1');\"><s>".$no.".</s></td><td align=\"center\" onclick=\"datarun('".$m_ref1."-1');\"><s>".$DT->ShowDateTime($m_date,'th')."</s></td><td align=\"center\" onclick=\"datarun('".$m_ref1."-1');\"><s>".$m_price."</s></td><td align=\"center\" onclick=\"datarun('".$m_ref1."-1');\"><s>".$m_ref1."</s></td></tr>\n";
		}else{
           $list .= "<tr bgcolor='".$iColor."' style=\"cursor:pointer;\"><td align=\"right\" onclick=\"datarun('".$m_ref1."');\">".$no.".</td><td align=\"center\" onclick=\"datarun('".$m_ref1."');\">".$DT->ShowDateTime($m_date,'th')."</td><td align=\"center\" onclick=\"datarun('".$m_ref1."');\">".$m_price."</td><td align=\"center\" onclick=\"datarun('".$m_ref1."');\">".$m_ref1."</td></tr>\n";
		}
	}
	$list .= "</table>";

}else{
  if ($param_keyword=='') {
	 $list = "";
  }else{
     $list = "ไม่พบข้อมูลที่ค้นหา";
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
	$('.add0').button({ icons: { primary: 'ui-icon-search' } });
	$("#btnBack").click(function(){
		document.location.href="front_menu.php?page=1";
    }); 
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
	$('.add').button({ icons: { primary: 'ui-icon-search' } });
});

function datarun(e) {
   window.open ("front_payment_print.php?orid=" + e,'_blank','width=800,height=600');
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
		
		
		 <form action="front_paymentview_form.php" method="post" name="frmsearchuser" id="frmsearchuser">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">ค้นหารายชื่อสมาชิก</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td class="linemenu">กรุณากรอกชื่อหรือเลขรหัสสมาชิก :&nbsp;<input type="text" name="keyword" id="keyword" maxlength="75" value="<?php echo $param_keyword;?>" style="width:300px;" />*&nbsp;&nbsp;<button id="button" class="add">ค้นหา</button></td>
			  </tr>
			  <tr><td height="35" valign="middle"><strong>ผลการค้นหา</strong></td></tr>
			  <tr><td align="left"><?php echo $list;?></td></tr>
			  <tr><td align="left">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">กลับไป</button></td>
                    <td align="right">&nbsp;</td>
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
