<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$iColor = '#eeeeee';
$DataList = "";

$SqlComCheck = "select * from tbl_commission_config order by c_id";
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

$SqlCheck = "select * from tbl_commission_config order by c_id desc limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['c_id'];
		 $db_create_by = stripslashes($RowCheck['c_create_by']);
		 $db_create_date = $DT->ShowDate($RowCheck['c_create_date'],'th');
		 $db_com_1 = stripslashes($RowCheck['c_com_1']);
		 $db_com_2 = stripslashes($RowCheck['c_com_2']);
		 $db_tp_1 = stripslashes($RowCheck['c_tp_1']);
		 $db_tp_2 = stripslashes($RowCheck['c_tp_2']);
		 $db_tpf_1 = stripslashes($RowCheck['c_tpf_1']);
		 $db_tpf_2 = stripslashes($RowCheck['c_tpf_2']);
		 $db_tpa_1 = stripslashes($RowCheck['c_tpa_1']);
		 $db_tpa_2 = stripslashes($RowCheck['c_tpa_2']);
		 $db_tpfa_1 = stripslashes($RowCheck['c_tpfa_1']);
		 $db_tpfa_2 = stripslashes($RowCheck['c_tpfa_2']);


         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

	     $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$db_create_by."</td><td align=\"center\" class=\"tblist\">".$db_create_date."</td><td align=\"center\" class=\"tblist\">".$db_com_1."</td><td align=\"center\" class=\"tblist\">".$db_com_2."</td><td align=\"center\" class=\"tblist\">".$db_tp_1."</td><td align=\"center\" class=\"tblist\">".$db_tp_2."</td><td align=\"center\" class=\"tblist\">".$db_tpf_1."</td><td align=\"center\" class=\"tblist\">".$db_tpf_2."</td><td align=\"center\" class=\"tblist\">".$db_tpa_1."</td><td align=\"center\" class=\"tblist\">".$db_tpa_2."</td><td align=\"center\" class=\"tblist\">".$db_tpfa_1."</td><td align=\"center\" class=\"tblist\">".$db_tpfa_2."</td><td align=\"center\" class=\"tblist\"><a href=\"commissionedit_form.php?id=".$db_id."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a>&nbsp;&nbsp;<a href=\"commissiondel_exec.php?id=".$db_id."\"  onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'');

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
            <td class="txttopicpage">แสดงรายการประเภทบริการรอง</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tablehead"><strong>#</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tablehead"><strong>สร้างโดย</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tablehead"><strong>วันที่สร้าง</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>Com/PP</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>Com/PO</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TP/PP</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TP/PO</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TPA/PP</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TPA/PO</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TPF/PP</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TPF/PO</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TPFA/PP</strong></td>
                      <td width="5%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>TPFA/PO</strong></td>
                      <td width="10%" bgcolor="#F5F5F5" class="tablehead txt1"><strong>จัดการ</strong></td>
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
