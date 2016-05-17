<?php
require '../leone.php';
require '../controller/content.php';
require '../controller/commission.php';
require '../controller/member.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$content = new content();
$commission = new commission();
$member = new member();
$param_service = (!empty($_REQUEST["service"])) ? $_REQUEST["service"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$DataList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;
$commission_array = $commission->getdata();

if ($param_service=='') {
	 $SqlService = "";
	 $ServiceTitle = "ทั้งหมด";
}else{
	 $SqlService = " and tbl_mpaytrans.m_servicecode='".$param_service."'";
	 $service_code = $content->getservicecode($param_service);
	 $ServiceTitle = $content->getservicename($param_service);
}

$SqlGroup = "select DATE(tbl_mpaytrans.m_date) as mdate from tbl_mpaytrans,tbl_member where (tbl_mpaytrans.m_mobileno=tbl_member.m_mobile) and (tbl_mpaytrans.m_date>='".$startdate." 00:00:00' and tbl_mpaytrans.m_date<='".$enddate." 59:59:59') and tbl_mpaytrans.m_confirmstatus='Y' group by mdate order by tbl_mpaytrans.m_date";
$ResultGroup = $DatabaseClass->DataExecute($SqlGroup);
$RowsGroup = $DatabaseClass->DBNumRows($ResultGroup);
if ($RowsGroup>0) {
	for ($t=0;$t<$RowsGroup;$t++) {
		 $RowGroup = $DatabaseClass->DBfetch_array($ResultGroup,$t);
		 $service_array[$t] = $RowGroup['mdate'];
	}
}

for ($y=0;$y<count($service_array);$y++) {
	$iColor = '#ffffff';
	$total_com = "";
	$total_tp = "";
	$total_tpf = "";
	$total_tpa = "";
	$total_tpfa = "";
	$total_twz = "";
	$feetotal = "0";
	$producttotal = "0";
	$gtotal = "0";
	$iNum = 0;
	$DataList .= "<tr><td width=\"8%\" height=\"25\" bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>วันที่ทำรายการ</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>รหัสบริการ</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>ชื่อรายการ</strong></td><td width=\"7%\" bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>Product Amt</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>Fee Amt</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>Total Amt</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>Commission</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>TP</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>TPF</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>TPA</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>TPF/A</strong></td><td bgcolor=\"#F5F5F5\" class=\"txt1 tblist tablehead\"><strong>TWZ</strong></td></tr>";

	$SqlCheck = "select tbl_mpaytrans.m_id as id,tbl_mpaytrans.m_servicecode as servicecode,tbl_mpaytrans.m_tranid as tranid,tbl_mpaytrans.m_customerid as customerid,tbl_mpaytrans.m_inccustfee as inccustfee,tbl_mpaytrans.m_totalamt as totalamt,tbl_mpaytrans.m_mobileno as mobileno,DATE(tbl_mpaytrans.m_date) as mdate,tbl_mpaytrans.m_productamt as productamt,tbl_mpaytrans.m_confirmstatus as confirmstatus,tbl_mpaytrans.m_confirmtransid as confirmtransid from tbl_mpaytrans,tbl_member where (tbl_mpaytrans.m_mobileno=tbl_member.m_mobile) and DATE(tbl_mpaytrans.m_date)='".$service_array[$y]."' and tbl_mpaytrans.m_confirmstatus='Y' $SqlService order by tbl_mpaytrans.m_id";
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
			 $db_paydate = $DT->ShowDateDelivery($RowCheck['mdate']);
			 $db_productamt = $RowCheck['productamt'];
			 $db_confirmstatus = $RowCheck['confirmstatus'];
			 $db_confirmtransid = $RowCheck['confirmtransid'];

			 $gtotal = $gtotal +  str_replace (",","",$db_totalamt);
		     $producttotal = $producttotal + str_replace (",","",$db_productamt);
			 $feetotal = $feetotal + str_replace (",","",$db_inccustfee);

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
			 $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$db_paydate."</td><td align=\"center\" class=\"tblist\">".$service_code."</td><td align=\"center\" class=\"tblist\">".$service_name."</td><td align=\"center\" class=\"tblist\">".$db_productamt."</td><td align=\"center\" class=\"tblist\">".$db_inccustfee."</td><td align=\"center\" class=\"tblist\">".$db_totalamt."</td><td align=\"center\" class=\"tblist\">".$Data_Commission."</td><td align=\"center\" class=\"tblist\">".$Data_TP."</td><td align=\"center\" class=\"tblist\">".$Data_TPF."</td><td align=\"center\" class=\"tblist\">".$Data_TPA."</td><td align=\"center\" class=\"tblist\">".$Data_TPFA."</td><td align=\"center\" class=\"tblist\">".$Data_TWZ."</td></tr>";

		}
	}
	unset($RowCheck);
	$DataList .= "<tr bgcolor=\"#ffffff\"><td colspan=\"3\" align=\"right\" class=\"tblist\"><b>Total :</b></td><td class=\"txt1 tblist\">".$producttotal."</td><td class=\"txt1 tblist\">".$feetotal."</td><td class=\"txt1 tblist\">".$gtotal."</td><td class=\"txt1 tblist\">".$total_com."</td><td align=\"center\" class=\"tblist\">".$total_tp."</td><td align=\"center\" class=\"tblist\">".$total_tpf."</td><td align=\"center\" class=\"tblist\">".$total_tpa."</td><td align=\"center\" class=\"tblist\">".$total_tpfa."</td><td align=\"center\" class=\"tblist\">".$total_twz."</td></tr>";
    $DataList .= "<tr><td colspan=\"12\" height=\"15\">&nbsp;</td></tr>";
}
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
            <td class="txttopicpage">แสดงรายงานสรุปผลตอบแทนแต่ละบริการ แยกตามวันที่ทำรายการ</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:15px;"><b>วันที่ </b><?php echo $period;?></td></tr>
				   <tr><td colspan="4" valign="middle" style="height:15px;"><b>บริการ </b><?php echo $ServiceTitle;?></td></tr>

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
