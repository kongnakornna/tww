<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/imei.php';
require './controller/product.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$param_typeb = (!empty($_REQUEST["typeb"])) ? $_REQUEST["typeb"] : "";

$SQLSearch = "";
$imei = new imei();
$product = new product();
$typelist = $imei->getgroupdd($param_typeb);
if ($param_keyword=='') {
  $SQLSearch .= "";
}else{
  $SQLSearch .= " and m_emei like '".trim($param_keyword)."%'";
}

if ($param_typeb=='') {
  $SQLSearch .= "";
}else{
  $SQLSearch .= " and m_type='".trim($param_typeb)."'";
}

if ($SQLSearch=='') $SQLSearch = " and m_type=''";

$totalrecords = $imei->getlistcount($SQLSearch,'desc');
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

$memberdata = $imei->getlist($SQLSearch,'desc',$min,$max);

$DataList = "";
$iColor = "#eeeeee";
for ($p=0;$p<$max;$p++) {
	  $db_id = stripslashes($memberdata[$p]['m_id']);
	  $db_emei = stripslashes($memberdata[$p]['m_emei']);
	  $db_docno = stripslashes($memberdata[$p]['m_docno']);
	  $db_used = stripslashes($memberdata[$p]['m_used']);	  
	  $db_barcode = stripslashes($memberdata[$p]['m_barcode']);	  
	  $db_type = stripslashes($memberdata[$p]['m_type']);
	  $db_docdate = $DT->ShowDate($memberdata[$p]['m_docdate'],'en');
      
	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

	  if ($db_used=='Y') {
		 $userdtext = 'ลงทะเบียนแล้ว';
	  }else{
		 $userdtext = 'ยังไม่ลงทะเบียน';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"center\" class=\"txt1 tblist\">".$db_type."</td><td align=\"center\" class=\"tblist\">".$db_docno."</td><td align=\"center\" class=\"tblist\">".$db_docdate."</td><td align=\"center\" class=\"txt1 tblist\">".$db_emei."</td><td align=\"center\" class=\"txt1 tblist\">".$db_barcode."</td><td align=\"center\" class=\"txt1 tblist\">".$userdtext."</td><td class=\"txt1 tblist\"><a href=\"imeidataedit_form.php?typeb=".$param_typeb."&keyword=".$param_keyword."&page=".$page."&id=".$db_id."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a>&nbsp;&nbsp;<a href=\"imeidatadel_exec.php?keyword=".$param_keyword."&typeb=".$param_typeb."&page=".$page."&id=".$db_id."\"  onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
}
$pagelist = $Web->paging($totalrecords,$maxrec,$page,'typeb=' . $param_typeb . '&keyword=' . $param_keyword);
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_function.inc.php');?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$("#typeb").change(function() {     
		var src = $(this).val();       
	    document.location.href="imeidata_view.php?typeb=" + src;
	}); 
});
//-->
</script>
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
            <td class="txttopicpage">แสดงรายการ Imei</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
				<form action="imeidata_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
				<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>                    
                    <td width="12%" height="37" align="left" valign="middle">ค้นหาจากประเภท :</td><td width="45%" height="37" align="left" valign="middle"><select name="typeb" id="typeb" style="width:300px;"><?php echo $typelist;?></select></td>
                    <td align="right" valign="middle"><button id="button" class="add">ค้นหา</button></td>
                  </tr>
					
                  <tr>                    
                    <td  width="12%" height="37" align="left" valign="middle">ค้นหาจากเลข Imei :</td><td colspan="2" height="37" align="left" valign="middle"><input type="text" name="keyword" id="keyword" maxlength="25" style="width:300px;" value="<?php echo $param_keyword;?>" /></td>
                  </tr>
                  <tr> 
                    <td colspan="3" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table></form>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="8%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>รหัสประเภท</strong></td>
                      <td width="13%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>Doc No</strong></td>
                      <td width="15%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>Doc Date</strong></td>
                      <td bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>เลข Imei</strong></td>
                      <td width="20%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>Barcode</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ลงทะเบียน</strong></td>
                      <td width="12%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>จัดการข้อมูล</strong></td>
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
