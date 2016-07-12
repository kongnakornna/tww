<?php
require '../leone.php';
require './controller/content.php';
require './controller/member.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$content = new content();
$member = new member();
$partner = new partner();
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$DataList = "";

if ($param_keyword=='') {
  $SQLSearch1 = "";
}else{
  $SQLSearch1 = " and ( p_ref2 like '".$param_keyword."%' or p_ref2 like '%".$param_keyword."%')";
}

if ($param_sdate=='') {
  $SQLSearch2 = "";
}else{
  $SQLSearch2 = " and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59')";
}

$SqlComCheck = "select * from tbl_payment where p_type='A' and p_status='1' $SQLSearch1 $SQLSearch2 order by p_id";
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

$SqlCheck = "select * from tbl_payment where p_type='A' and p_status='1' $SQLSearch1 $SQLSearch2 order by p_id desc limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_detail = stripslashes($RowCheck['p_detail']);
		 $db_email = stripslashes($RowCheck['p_email']);
		 $db_type = stripslashes($RowCheck['p_type']);
		 $db_addby = stripslashes($RowCheck['p_addby']);
		 $db_ref1 = stripslashes($RowCheck['p_ref1']);
		 $db_ref2 = stripslashes($RowCheck['p_ref2']);
		 $db_status = stripslashes($RowCheck['p_status']);
		 $db_price = stripslashes($RowCheck['p_price']);
		 $db_station = stripslashes($RowCheck['p_station']);
		 $db_date = $DT->ShowDateTime($RowCheck['p_adddate'],'en');

		 $custname = $member->getnamefromcode($db_detail);

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

		 if ($db_station=='TWZ') {
			 $refnumber = $db_ref1;
		 }else{
			 $refnumber = $db_ref2;
		 }

         $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_date."</td><td align=\"center\" class=\"tblist\">".$db_station."</td><td align=\"center\" class=\"tblist\">".$refnumber."</td><td class=\"tblist\" align=\"center\">".$db_detail."</td><td class=\"tblist\" align=\"center\">".$custname."</td><td class=\"tblist\" align=\"center\">".$db_price."</td></tr>";
	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'keyword='.$param_keyword);

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
	$('#s_sdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
	$('#s_edate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
});

function datarun(e) {
   window.open ("front_payment_print.php?orid=" + e,'_blank','width=800,height=600');
}
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
            <td class="txttopicpage">จัดการการเงิน-ดูรายการเติมเงินของสมาชิก</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="60%" align="left" valign="top" class="txtsg">ค้นหาด้วยเลขที่บิล :</td>
                    <td width="40%" align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="paymoney_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
                    <td height="37" align="left" valign="middle"><input type="text" name="keyword" id="keyword" value="<?php echo $param_keyword;?>" style="width: 320px;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" /></td></form>
					  <form action="paymoney_view.php" method="post" name="frmsearchuser2" id="frmsearchuser2">
                    <td align="right">ช่วงวันที่ <input type="text" name="s_sdate" id="s_sdate" style="width:100px;" value="<?php echo $param_sdate;?>" readonly=readonly />&nbsp;ถึง&nbsp;<input type="text" name="s_edate" id="s_edate" value="<?php echo $param_edate;?>" style="width:100px;" readonly=readonly />&nbsp;<input type="submit" name="btnSubmit2" id="btnSubmit2" value="ตกลง" /></td>
                  </tr></form>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
					<td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>#</strong></td>
					<td width="20%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>วันที่ / เวลา</strong></td>
					<td width="15%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>เติมที่</strong></td>
					<td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เลขที่บิล</strong></td>
					<td width="10%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>EasyCard</strong></td>
					<td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อสมาชิก</strong></td>
					<td width="15%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>จำนวนเงิน</strong></td>
                    </tr>
                    <?php echo $DataList;?>
                </table>                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr><td><?php echo $pagelist; ?></td></tr>
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
