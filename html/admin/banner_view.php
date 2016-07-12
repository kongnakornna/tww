<?php
require '../leone.php';
require './controller/content.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$content = new content();
$partner = new partner();
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$iColor = '#eeeeee';
$DataList = "";

if ($param_keyword=='') {
  $SQLSearch1 = "";
}else{
  $SQLSearch1 = " and p_title like '%".$param_keyword."%'";
}

$SqlComCheck = "select * from tbl_banner where 1 $SQLSearch1 order by b_id";
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

$SqlCheck = "select * from tbl_banner where 1 $SQLSearch1 order by b_id desc limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['b_id'];
		 $db_title = stripslashes($RowCheck['b_title']);
		 $db_url = stripslashes($RowCheck['b_url']);
		 $db_file = stripslashes($RowCheck['b_file']);
		 $db_startdate = stripslashes($RowCheck['b_startdate']);
		 $db_enddate = stripslashes($RowCheck['b_enddate']);
		 $periodlist = $DT->ShowDate($db_startdate,'th') . " ถึง " . $DT->ShowDate($db_enddate,'th');
         if ($db_file=='') {
             $img = "";
		 }else{
             $img = "<img src=\"../../photo/".$db_file."\" width=\"300\" border=\"0\" />";
		 }

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

	     $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"left\" class=\"tblist\">".$db_title."</td><td align=\"center\" class=\"tblist\">".$img."</td><td align=\"center\" class=\"tblist\">".$periodlist."</td><td class=\"txt1 tblist\"><a href=\"banneredit_form.php?id=".$db_id."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a>&nbsp;&nbsp;<a href=\"banner_del.php?id=".$db_id."\"  onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
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
            <td class="txttopicpage">จัดการข้อมูลกลาง-แสดงป้ายโฆษณาหน้าแรก (Web/App)</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="60%" align="left" valign="top" class="txtsg">ค้นหาชื่อป้ายโฆษณา :</td>
                    <td width="40%" align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="banner_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
                    <td height="37" align="left" valign="middle"><input type="text" name="keyword" id="keyword" value="<?php echo $param_keyword;?>" style="width: 370px;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" /></td></form>
                    <td align="left" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
					<td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>#</strong></td>
					<td width="20%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>ชื่อป้ายโฆษณา</strong></td>
					<td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ป้ายโฆษณา</strong></td>
					<td width="25%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>วันที่แสดง</strong></td>
					<td width="8%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>จัดการ</strong></td>
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
