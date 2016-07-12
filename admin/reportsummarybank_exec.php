<?php
require '../leone.php';
require '../controller/bank.php';
require '../controller/content.php';
require '../controller/commission.php';
require '../controller/member.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$bank = new bank();
$content = new content();
$commission = new commission();
$member = new member();
$param_memcode = (!empty($_REQUEST["memcode"])) ? $_REQUEST["memcode"] : "";
$param_bank = (!empty($_REQUEST["bank"])) ? $_REQUEST["bank"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$DataList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;

$commission_array = $commission->getdata();
if ($param_bank=='') {
	$SqlBank = "";
	$BankTitle = "ทั้งหมด";
}else{
	$SqlBank = " and tbl_member.m_bank_name='".$param_bank."'";
	$BankTitle = $bank->getbycode($param_bank);
}

if ($param_type=='') {
	$SqlType = "";
	$TypeTitle = "ทั้งหมด";
}else{
	$SqlType = " and tbl_member.m_code='".$param_type."'";
	$TypeTitle = $param_type;
}

if ($param_memcode=='') {
	 $SqlCode = "";
	 $CodeTitle = "ทั้งหมด";
}else{
	 $SqlCode = " and tbl_mpaytrans.m_mobileno='".$param_memcode."'";
	 $profilearray = $member->getdetailbymsisdn($param_memcode);
	 if (count($profilearray)>0) {
		for ($i=0;$i<count($profilearray);$i++) {
			 $a_fname = $profilearray[$i]['m_fname'];
			 $a_lname = $profilearray[$i]['m_lname'];
			 $member_name = $a_fname . " " . $a_lname;
		}
	 }else{
		$member_name = "-";
		$member_code = "";
		$member_type = "";
	 }
	 $CodeTitle =$member_name;
}

$iColor = '#ffffff';
$bank_title = "";
$total_com = "";
$total_tp = "";
$total_tpf = "";
$total_tpa = "";
$total_tpfa = "";
$total_twz = "";
$gtotal = "";
$GrandTotal = "";
$iNum = 0;

$SqlCheck = "select tbl_mpaytrans.m_id as id,tbl_mpaytrans.m_servicecode as servicecode,tbl_mpaytrans.m_tranid as tranid,tbl_mpaytrans.m_customerid as customerid,tbl_mpaytrans.m_inccustfee as inccustfee,tbl_mpaytrans.m_totalamt as totalamt,tbl_mpaytrans.m_mobileno as mobileno,tbl_mpaytrans.m_date as mdate,tbl_mpaytrans.m_productamt as productamt,tbl_mpaytrans.m_confirmstatus as confirmstatus,tbl_mpaytrans.m_confirmtransid as confirmtransid,tbl_member.m_bank_name as bankid,tbl_member.m_bank_code as bankcode from tbl_mpaytrans,tbl_member where (tbl_mpaytrans.m_mobileno=tbl_member.m_mobile) and (tbl_mpaytrans.m_date>='".$startdate." 00:00:00' and tbl_mpaytrans.m_date<='".$enddate." 59:59:59') and tbl_mpaytrans.m_confirmstatus='Y' $SqlType $SqlCode $SqlBank order by tbl_mpaytrans.m_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['id'];
		 $db_servicecode = $RowCheck['servicecode'];
		 $db_tranid = $RowCheck['tranid'];
		 $db_customerid = $RowCheck['customerid'];
		 $db_inccustfee = $RowCheck['inccustfee'];
		 $db_totalamt = $RowCheck['totalamt'];
		 $db_mobileno = $RowCheck['mobileno'];
		 $db_paydate = $DT->ShowDate($RowCheck['mdate'],'th');
		 $db_productamt = $RowCheck['productamt'];
		 $db_bankcode = $RowCheck['bankcode'];
		 $db_bankid = $RowCheck['bankid'];
		 $db_confirmstatus = $RowCheck['confirmstatus'];
		 $db_confirmtransid = $RowCheck['confirmtransid'];

		 $gtotal = $gtotal +  str_replace (",","",$db_totalamt);

		 $bank_title = $bank->getbycode($db_bankid);
		 $service_code = $content->getservicecode($db_servicecode);
		 $service_name = $content->getservicename($db_servicecode);
		 $profilearray = $member->getdetailbymsisdn($db_mobileno);
		 if (count($profilearray)>0) {
			for ($i=0;$i<count($profilearray);$i++) {
				 $a_fname = $profilearray[$i]['m_fname'];
				 $a_lname = $profilearray[$i]['m_lname'];
				 $a_tname = $profilearray[$i]['m_typename'];
				 $a_code = $profilearray[$i]['m_code'];

				 $member_name = $a_fname . " " . $a_lname;
				 $member_code = $a_code;
				 $member_type = $a_tname;
			}
		 }else{
			$member_name = "-";
			$member_code = "";
			$member_type = "";
		 }

		 if ($iColor=='#eeeeee') {
			 $iColor = '#ffffff';
		 }else{
			 $iColor = '#eeeeee';
		 }

		$Data_TP = "";
		$Data_TPA = "";
		$Data_TPF = "";
		$Data_TPFA = "";
		$Data_TWZ = "";
		$Data_Total = "";
		$data_com = "";

		 if ($service_code=='12C') {
			 $data_com = $commission_array[0]['c_com_2'];
			 $Data_Commission = str_replace (",","",$db_totalamt) * ($data_com/100);
			 if (strtoupper($member_type)=='TP') {
				 $data = $commission_array[0]['c_tp_2'];
				 $Data_TP = str_replace (",","",$db_totalamt) * ($data/100);
			 }
			 if (strtoupper($member_type)=='TPF') {
				 $data = $commission_array[0]['c_tpf_2'];
				 $Data_TPF = str_replace (",","",$db_totalamt) * ($data/100);
			 }
			 if (strtoupper($member_type)=='TPA') {
				 $data = $commission_array[0]['c_tpa_2'];
				 $Data_TPA = str_replace (",","",$db_totalamt) * ($data/100);
			 }
			 if (strtoupper($member_type)=='TPFA') {
				 $data = $commission_array[0]['c_tpfa_2'];
				 $Data_TPFA = str_replace (",","",$db_totalamt) * ($data/100);
			 }
			 $Data_TWZ = $Data_Commission - ($Data_TP+$Data_TPA+$Data_TPF+$Data_TPFA);

			 $total_com= $total_com + $Data_Commission;
			 $total_tp = $total_tp + $Data_TP;
			 $total_tpf = $total_tpf + $Data_TPF;
			 $total_tpa = $total_tpa + $Data_TPA;
			 $total_tpfa = $total_tpfa + $Data_TPFA;
			 $total_twz = $total_twz + $Data_TWZ;
		 }else{
			 $Data_Commission = $commission_array[0]['c_com_1'];
			 if (strtoupper($member_type)=='TP') $Data_TP = $commission_array[0]['c_tp_1'];
			 if (strtoupper($member_type)=='TPF') $Data_TPF = $commission_array[0]['c_tpf_1'];
			 if (strtoupper($member_type)=='TPA') $Data_TPA = $commission_array[0]['c_tpa_1'];
			 if (strtoupper($member_type)=='TPFA') $Data_TPFA = $commission_array[0]['c_tpfa_1'];
			 $Data_TWZ = $Data_Commission - ($Data_TP+$Data_TPA+$Data_TPF+$Data_TPFA);

			 $total_com= $total_com + $Data_Commission;
			 $total_tp = $total_tp + $Data_TP;
			 $total_tpf = $total_tpf + $Data_TPF;
			 $total_tpa = $total_tpa + $Data_TPA;
			 $total_tpfa = $total_tpfa + $Data_TPFA;
			 $total_twz = $total_twz + $Data_TWZ;
		 }
		 $Data_Total = $Data_TP + $Data_TPF + $Data_TPA + $Data_TPFA;
		 $GrandTotal = $GrandTotal + $Data_Total;
		 $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$member_type."</td><td align=\"center\" class=\"tblist\">".$member_name."</td><td align=\"center\" class=\"tblist\">".$member_code."</td><td align=\"center\" class=\"tblist\">".$Data_TP."</td><td align=\"center\" class=\"tblist\">".$Data_TPF."</td><td align=\"center\" class=\"tblist\">".$Data_TPA."</td><td align=\"center\" class=\"tblist\">".$Data_TPFA."</td><td align=\"center\" class=\"tblist\">".$Data_Total."</td><td align=\"center\" class=\"tblist\">".$bank_title."</td><td align=\"center\" class=\"tblist\">".$db_bankcode."</td><td align=\"center\" class=\"tblist\">&nbsp;</td></tr>";

	}
}
unset($RowCheck);
$DataList .= "<tr bgcolor=\"#ffffff\"><td colspan=\"4\" align=\"right\" class=\"tblist\"><b>Total :</b></td><td align=\"center\" class=\"tblist\">".$total_tp."</td><td align=\"center\" class=\"tblist\">".$total_tpf."</td><td align=\"center\" class=\"tblist\">".$total_tpa."</td><td align=\"center\" class=\"tblist\">".$total_tpfa."</td><td align=\"center\" class=\"tblist\">".$GrandTotal."</td><td colspan=\"3\" align=\"right\" class=\"tblist\">&nbsp;</td></tr>";
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
            <td class="txttopicpage">แสดงรายงานสรุปผลตอบแทนแยกตามบริการ</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:15px;"><b>วันที่ </b><?php echo $period;?></td></tr>
				   <tr><td colspan="4" valign="middle" style="height:15px;"><b>ธนาคาร </b><?php echo $BankTitle;?></td></tr>
				   <tr><td colspan="4" valign="middle" style="height:15px;"><b>ประเภทลูกค้า </b><?php echo $TypeTitle;?></td></tr>
				   <tr><td colspan="4" valign="middle" style="height:15px;"><b>รหัสลูกค้า </b><?php echo $CodeTitle;?></td></tr>
				   </table><br/>

                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                   <tr><td width="2%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ลำดับ</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รหัสลูกค้า</strong></td><td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อลูกค้า</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ประเภทลูกค้า</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>TP</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>TPF</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>TPA</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>TPF/A</strong></td><td width="5%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>Total</strong></td><td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ธนาคาร</strong></td><td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เลขที่บัญชี</strong></td><td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>หมายเหตุ</strong></td></tr>
                    <?php echo $DataList;?>
                </table>
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
