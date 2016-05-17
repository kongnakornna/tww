<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_service = (!empty($_REQUEST["service"])) ? $_REQUEST["service"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;

$SqlTopic = "select * from tbl_subcategorie where s_serviceid='".$param_service."' order by s_id";
$ResultTopic = $DatabaseClass->DataExecute($SqlTopic);
$RowsTopic = $DatabaseClass->DBNumRows($ResultTopic);
if ($RowsTopic>0) {
	for ($t=0;$t<$RowsTopic;$t++) {
		 $RowTopic = $DatabaseClass->DBfetch_array($ResultTopic,$t);
		 $dbs_title = stripslashes($RowTopic['s_title']);
	}
}

$period = $param_sdate . " ถึง " . $param_edate;
if ($param_service=='') {
   $ServSQL = "";
}else{
   $ServSQL = " and m_servicecode='".$param_service."'";
}
$SqlComCheck = "select * from tbl_mpaytrans where (m_date>='".$startdate." 00:00:00' and m_date<='".$enddate." 59:59:59') and m_confirmstatus='Y' $ServSQL order by m_id";
$ResultComCheck = $DatabaseClass->DataExecute($SqlComCheck);
$RowsComCheck = $DatabaseClass->DBNumRows($ResultComCheck);
if ($param_page=="") $param_page=1;
if ($param_page=="1") {
   $min = 0;
}else{
   $min = (($param_page-1)*$maxrec);
}
$numPage = ceil ($RowsComCheck/$maxrec);
if ($numPage==0) $numPage=1;
$iNum=$maxrec*($param_page-1);

$SqlCheck = "select * from tbl_mpaytrans where (m_date>='".$startdate." 00:00:00' and m_date<='".$enddate." 59:59:59') and m_confirmstatus='Y' $ServSQL order by m_id limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_mobileno = $RowCheck['m_mobileno'];
		 $db_refid = $RowCheck['m_refid'];
		 $db_tranid = $RowCheck['m_tranid'];
		 $db_sessionid = $RowCheck['m_sessionid'];
		 $db_email = $RowCheck['m_email'];
		 $db_date = $DT->ShowDateTime($RowCheck['m_date'],'th');
		 $db_payeemobileno = $RowCheck['m_payeemobileno'];
		 $db_serviceid = $RowCheck['m_serviceid'];
		 $db_status = $RowCheck['m_status'];
		 $db_mpaycode = $RowCheck['m_mpaycode'];
		 $db_respcode = $RowCheck['m_respcode'];
		 $db_confirmstatus = $RowCheck['m_confirmstatus'];

		 if (trim($db_confirmstatus)=='Y') {
			 $status = 'OK';
		 }else{
			 $status = 'FAIL';
		 }

		 if ($iColor=='#eeeeee') {
			 $iColor = '#ffffff';
		 }else{
			 $iColor = '#eeeeee';
		 }

		 $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_date."</td><td align=\"center\" class=\"tblist\">".$db_refid."</td><td align=\"center\" class=\"tblist\">".$db_sessionid."</td><td align=\"center\" class=\"tblist\">".$db_mobileno."</td><td align=\"center\" class=\"tblist\">".$db_payeemobileno."</td><td align=\"center\" class=\"tblist\">".$status."</td></tr>";

	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'service=' . $param_service . '&s_sdate=' . $param_sdate . '&s_edate='.$param_edate);

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
            <td class="txttopicpage">แสดงรายงานยอดการใช้บริการ <?php echo $dbs_title;?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:30px;"><b>วันที่ </b><?php echo $period;?></td></tr>
                    <tr>
                      <td width="2%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>วันเวลาที่ดำเนินการ</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>หมายเลขอ้างอิง</strong></td>
                      <td width="16%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>SessionId</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เบอร์โทร</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เบอร์โทรที่รับการโอน</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>สถานะ</strong></td>
                    </tr>
                    <?php echo $UserList;?>
                </table>
				</td>
              </tr>
				              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr><td><?php echo $pagelist; ?></td></tr>
												              <tr>
                <td>&nbsp;</td>
              </tr>
			  <tr><td>
				<br/><br/>      
				<form method="post" action="reportmember_exec_csv.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />	
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="นำออก CSV" /></td></tr>
				</table> 
				</form>
										</td>
              </tr>	              <tr>
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
