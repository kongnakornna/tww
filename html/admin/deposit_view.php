<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/wallet.php';

if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$wallet = new wallet();

if ($param_sdate != '' && $param_edate != '') {
$date = date_create_from_format('d/m/Y',$param_sdate);
$param_sdate=date_format($date,'Y-m-d');
$date = date_create_from_format('d/m/Y',$param_edate);
$param_edate=date_format($date,'Y-m-d');
$depositdata = $wallet->getdeposit_list_withdate($param_sdate,$param_edate);
}
else
$depositdata = $wallet->getdeposit_list();
$totalrecords = count($depositdata);
$totalpage = ceil ($totalrecords/$maxrec);
if ($page=='' || $page=='0' || $page=='1') {
   $page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($page-1));
   $max = $maxrec * $page;
}
if ($max > $totalrecords) $max = $totalrecords;

$iNum = 0;
$DataList = "";
$iColor = "#eeeeee";
for ($p=$min;$p<$max;$p++) {
	  $iNum++;
	  $db_logtime= stripslashes($depositdata[$p]['d_logtime']);
	  $db_amount = stripslashes($depositdata[$p]['amount']);
	  $db_remark1 = stripslashes($depositdata[$p]['d_remark1']);
	  $db_remark2= stripslashes($depositdata[$p]['d_remark2']);
	  $db_username = stripslashes($depositdata[$p]['d_username']);	  
	  $db_date = stripslashes($depositdata[$p]['d_date']);
          $db_partner =  stripslashes($depositdata[$p]['d_partner']);	  
          if ($db_partner == '01') {
              $mypartner = 'MPAY';
          }
	  if ($db_partner == '02') {
              $mypartner = 'WOP';
          }

	  if ($db_partner == '03') {
              $mypartner = 'MYWORLD';
          }

	  if ($db_partner == '04') {
              $mypartner = 'IPPS';
          }


          if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"txt1 tblist\">".$db_logtime."</td><td align=\"center\" class=\"tblist\">".$mypartner."</td><td align=\"center\" class=\"tblist\">".$db_date."</td><td align=\"center\" class=\"tblist\">".$db_amount."</td><td align=\"center\" class=\"tblist\">".$db_username."</td><td align=\"center\" class=\"tblist\">".$db_remark1."</td><td align=\"center\" class=\"tblist\">".$db_remark2."</td><td class=\"txt1 tblist\"><a href=\"depositdel_exec.php?partner=$db_partner&logtime=$db_logtime\" onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
}


$pagelist = $Web->paging($totalrecords,$maxrec,$page,'');
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
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$('#s_sdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
	$('#s_edate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
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
            <td class="txttopicpage">แสดงรายการข้อมูลการ advance ระหว่างคู่ค้า </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top" class="txtsg">ค้นหาวันที่บันทึก :</td>
                      <td align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="deposit_view.php" method="post" name="depreport" id="depreport">
	              <tr>
                      <td align="left" valign="middle">วันที่เริ่ม :&nbsp;</td>
                      <td class="linemenu" align="left"><input type="text" name="s_sdate" id="s_sdate" style="width:300px;" readonly=readonly />*</td>
                      <td align="left" valign="middle">วันที่สิ้นสุด :&nbsp;</td>
                      <td class="linemenu" align="left"><input type="text" name="s_edate" id="s_edate" style="width:300px;" readonly=readonly />*</td>
	              <td width=400" height="37" align="left" valign="top">
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" />
                      </td>
                      </tr>
                      </form>
                    <td align="right" valign="top">&nbsp;</td>
                  </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
					  <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ลำดับที่</strong></td>
                      <td width="20%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>วันเวลาที่บันทึก</strong></td>
                      <td bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ชื่อคู่ค้า</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>วันที่โอน</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>จำนวนเงิน</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>ชื่อผู้บันทึก</strong></td>
		  	          <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>บันทีกเพิ่มเติม 1</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>บันทีกเพิ่มเติม 2</strong></td>
                      <td width="5%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>ลบข้อมูล</strong></td>
                 
                    </tr>
                    <?php echo $DataList;?>
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
