<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/broadcast.php';

if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$broadcast = new broadcast();

if ($param_sdate != '' && $param_edate != '') {
$date = date_create_from_format('d/m/Y',$param_sdate);
$param_sdate=date_format($date,'Y-m-d');
$date = date_create_from_format('d/m/Y',$param_edate);
$param_edate=date_format($date,'Y-m-d');
$broadcastdata = $broadcast->getbroadcast_list_withdate($param_sdate,$param_edate);
}
else
$broadcastdata = $broadcast->getbroadcast_list();
$totalrecords = count($broadcastdata);
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
	  $db_logtime= stripslashes($broadcastdata[$p]['b_logtime']);
	  $db_broadcasttype = stripslashes($broadcastdata[$p]['b_type']);
	  $db_broadcastto = stripslashes($broadcastdata[$p]['b_to']);
	  $db_message = stripslashes($broadcastdata[$p]['b_message']);
	  $db_username =  stripslashes($broadcastdata[$p]['b_username']);
     
     if ($db_broadcasttype == '01') 
     {
        $type = 'ทั้งหมด';
     }
	 else 
     {
        $type = 'เจาะจงสมาชิก'; 
     }	 


 
      if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"txt1 tblist\">".$db_logtime."</td><td align=\"center\" class=\"tblist\">".$type."</td><td align=\"center\" class=\"tblist\">".$db_broadcastto."</td><td align=\"center\" class=\"tblist\">".$db_username."</td><td align=\"center\" class=\"tblist\">".$db_message."</td></tr>";
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
            <td class="txttopicpage">แสดงรายการข้อมูลการแจ้งข่าว </td>
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
                    <form action="broadcast_view.php" method="post" name="broadcastreport" id="broadcastreport">
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
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>วันเวลาที่บันทึก</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ประเภทการแจ้งข่าว</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>Email สมาชิก</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>User ผู้แจ้งข่าว</strong></td>
                      <td width="50%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ข้อความ</strong></td>
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
