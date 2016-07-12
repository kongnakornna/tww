<?php
require '../leone.php';
require './controller/app.php';
require './controller/member.php';
require './controller/payment.php';
require './controller/partner.php';
require './controller/eservice.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$member = new member();
$payment = new payment();
$partner = new partner();
$eservice = new eservice();
$user = new user();
$app = new app();
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$DataList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;
$RowCheck = array();
$memberid = $user->getmemberid($_SESSION['TWZUsername']);
$email = $member->getemailbycode($memberid);

if ($param_type == '' || $param_type == '01') {
$SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid not in ('ES9999') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ส่วนลดจากการทำรายการเอง' and p_email = '".$email."' order by p_adddate desc,p_partnercode";
}
else {
      if ($param_type == '02') {
          $SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid in ('ES9996','ES1001','ES1002') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ส่วนลดจากการทำรายการเอง' and p_email = '".$email."' order by p_adddate desc,p_partnercode";
      }
      if ($param_type == '03') {
          $SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid not in ('ES9996','ES1001','ES1002','ES9999','ES9997') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ส่วนลดจากการทำรายการเอง'  and p_email = '".$email."' order by p_adddate desc,p_partnercode";
      }
      if ($param_type == '04') {
          $SqlCheck = "select p_id,p_partnercode,p_adddate,p_productid,p_email,p_detail,p_price,p_charge,p_total,p_msisdn,p_ref1 from tbl_payment where p_productid in ('ES9999','ES9997') and  (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_type IN ('D') and p_status = '1' and p_reinstall NOT IN ('Y') and p_detail = 'ส่วนลดจากการทำรายการเอง'  and p_email = '".$email."' order by p_adddate desc,p_partnercode";
      }
}        

$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	$grandtotal = "0";
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_code = $RowCheck['p_productid'];
		 $db_pncode = $RowCheck['p_partnercode'];
		 $db_email = $RowCheck['p_email'];
		 $db_detail = $RowCheck['p_detail'];
		 $db_date = $DT->ShowDate($RowCheck['p_adddate'],'th');
		 $db_time = $DT->ShowTime($RowCheck['p_adddate']);
		 $db_discount = $RowCheck['p_price'];
		 $db_total = $RowCheck['p_ref1'];
		 $db_charge = $RowCheck['p_ref2'];
		 $db_price = $db_total - $db_charge;
                 $db_msisdn = $RowCheck['p_msisdn']; 
		  
		 $custname = $member->getnamefromemail($db_email);
		 $custmobile = $member->getmobilefromemail($db_email);
		 $custcode = $member->getcodefromemail($db_email);
		 $codename = $eservice->gettitle($db_code);
		 $partnername = $partner->getnamebycode($db_pncode);

		 $grandprice = $grandprice + $db_price;
		 $grandcharge = $grandcharge + $db_charge;
		 $grandtotal = $grandtotal + $db_total;
		 $granddiscount = $granddiscount + $db_discount;

		 if ($iColor=='#ffffff') {
			 $iColor = "#eeeeee";
		 }else{
			 $iColor = "#ffffff";
		 }

         $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_date."</td><td align=\"left\" class=\"tblist\">".$db_time."</td><td align=\"center\" class=\"tblist\">".$custcode."</td><td align=\"center\" class=\"tblist\">".$custname."</td><td align=\"center\" class=\"tblist\">".$codename."</td><td align=\"left\" class=\"tblist\">".$db_msisdn."</td><td align=\"center\" class=\"tblist\">".$db_price."</td><td align=\"center\" class=\"tblist\">".$db_charge."</td><td align=\"center\" class=\"tblist\">".$db_total."</td><td align=\"center\" class=\"tblist\">".$db_discount."</strong></td></tr>";
	}
}
$DataList .= "<tr bgcolor=\"#ffffff\"><td colspan=\"7\" align=\"right\" class=\"tblist\">ยอดรวม : </td><td align=\"center\" class=\"tblist\">".number_format($grandprice,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandcharge,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($grandtotal,2,'.',',')."</td><td align=\"center\" class=\"tblist\"><strong>".number_format($granddiscount,2,'.',',')."</strong></td></tr>";

unset($RowCheck);
$DatabaseClass->DBClose();
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
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });
    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-print' } });
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
        <td height="480" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">รายงานผลตอบแทนของตัวแทน</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
	          <tr>
                   <td width="10%" align="right" valign="middle" class="barG">ประเภทบริการ :&nbsp;</td>
                   <form action="report_all_exec_discount_own.php" method="post" name="frmreport" id="frmreport"> 
                   <td width="10%" class="linemenu"><select name="type" id="type" style="width:200px;">
                       <option value="01">ทั้งหมด</option> 
					   <option value="02">เติมเงิน</option>
                       <option value="03">จ่ายบิล</option>
                       <option value="04">ถอนโอน</option>
                   </select>
                   <input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" /> 
                   <input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" /> 
                   <td width="10%" class="linemenu"><input type="submit" name="submit" value="ค้นหา" /> 
                   </form>   
                   </td>
                 </tr>	
                  <tr><td colspan="11" valign="middle" style="height:30px;"><b>วันที่ </b><?php echo $period;?></td></tr>
                    <tr>
                      <td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ลำดับที่</td>
  		      <td width="6%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>วันที่ทำรายการ</strong></td>
	              <td width="4%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เวลา</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รหัสสมาชิก</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อสมาชิก</strong></td>
		     <td width="11%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รายการ</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เบอร์ที่ทำรายการ</strong></td>
                      <td width="6%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดรวม</strong></td>
                      <td width="7%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ค่าบริการ</strong></td>
                      <td width="9%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดรวมทั้งสิ้น</strong></td>
		      <td width="7%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ผลตอบแทน</strong></td>
                    </tr>
                    <?php echo $DataList;?>
                </table>    
				
				<br/><br/>

				<form method="post" action="report_all_exec_csv_discount_own.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />	
				<input type="hidden" name="type" value="<?php echo $param_type;?>" />	
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="นำออก CSV" /></td></tr>
				</table> 
				</form>
		
		</td>
              </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
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
