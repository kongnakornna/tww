<?php
require '../leone.php';
require './controller/product.php';
require './controller/province.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$product = new product();
$province = new province();
$user = new user();
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;

$SqlComCheck = "select * from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') order by m_id";
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

$SqlCheck = "select * from tbl_member where (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') order by m_id limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_fullname = $RowCheck['m_fullname'];
		 $db_email = $RowCheck['m_email'];
		 $db_province = $RowCheck['m_province'];
		 $db_mobile = $RowCheck['m_mobile'];
		 $db_code = $RowCheck['m_code'];
		 $db_registerdate = $DT->ShowDate($RowCheck['m_registerdate'],'th');
		 $db_bdate = $DT->ShowDate($RowCheck['m_bdate'],'th');
		 $db_saleid = $RowCheck['m_saleid'];
		 $db_dcode = $RowCheck['m_dcode'];
		 $db_imei = $RowCheck['m_imei'];
		 $db_price = $RowCheck['m_price_sync'];

		 $provincetitle = $province->getname($db_province);
         $totalsub = "-";
		 $dname = "";
		 $By = "";

		 if ($db_dcode=='') {
			 if ($db_saleid=='') {
			    $dname = "";
			    $By = "";
			 }else{
				$By = $db_saleid;
				$dname = $user->getsalename($db_saleid);
			 }
		 }else{
			$By = $db_dcode;
			$dname = $user->getdealername($db_dcode);
		 }

		 if (trim($By)=='') $By = "user";

		 if ($iColor=='#eeeeee') {
			 $iColor = '#ffffff';
		 }else{
			 $iColor = '#eeeeee';
		 }

		 $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_registerdate."</td><td align=\"center\" class=\"tblist\">".$db_code."</td><td align=\"left\" class=\"tblist\">".$db_fullname."</td><td align=\"center\" class=\"tblist\">".$db_bdate."</td><td align=\"center\" class=\"tblist\">".$provincetitle."</td><td align=\"center\" class=\"tblist\">".$db_mobile."</td><td class=\"txt1 tblist\">".$db_email."</td><td align=\"center\" class=\"tblist\">".$db_imei."</td><td align=\"center\" class=\"tblist\">".$By."</td><td align=\"center\" class=\"tblist\">".$dname."</td><td align=\"center\" class=\"tblist\">".number_format ($db_price,'2','.',',')."</td></tr>";

	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'s_sdate=' . $param_sdate . '&s_edate='.$param_edate);

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
            <td class="txttopicpage">จัดการรายงาน-ยอดผู้ลงทะเบียนสมาชิก</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:20px;"><b>วันที่ </b><?php echo $period;?></td></tr>
				   <tr><td colspan="4" valign="middle" style="height:30px;"><b>ยอดสมาชิกทั้งหมด </b><?php echo $RowsComCheck;?>&nbsp;คน</td></tr>
                    <tr>
                      <td width="2%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>วันที่ลงทะเบียน</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รหัส EasyCard</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อ-นามสกุล</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ว/ด/ป เกิด</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>จังหวัด</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>เบอร์โทร</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>อีเมล์</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>IMEI</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รหัสผู้ลงทะเบียน</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อผู้ลงทะเบียน</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดเงินคงเหลือ</strong></td>
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
