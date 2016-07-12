<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/member.php';
require './controller/product.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$member = new member();
$product = new product();

if ($param_keyword=='') {
  $SQLSearch = "";
}else{
  $SQLSearch = " m_fullname like '%".$param_keyword."%'";
}

$memberdata = $member->getlist($SQLSearch,'desc');
$totalrecords = count($memberdata);
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

$DataList = "";
$iColor = "#eeeeee";
for ($p=$min;$p<$max;$p++) {
	  $db_id = stripslashes($memberdata[$p]['m_id']);
	  $db_type = stripslashes($memberdata[$p]['m_type']);
	  $db_fullname = stripslashes($memberdata[$p]['m_fullname']);
	  $db_producttype = stripslashes($memberdata[$p]['m_producttype']);	  
	  $db_productbrand = stripslashes($memberdata[$p]['m_productbrand']);
	  $db_productmodel = stripslashes($memberdata[$p]['m_productmodel']);
	  $db_registerdate = $DT->ShowDate($memberdata[$p]['m_registerdate'],'th');
      
	  if ($db_type=='1') {
		  $TypeName = "TWZ";
		  $fileForEdit = "memberedit_form.php";
	  }else if ($db_type=='2') {
		  $TypeName = "Other";
		  $fileForEdit = "nonmemberedit_form.php";
	  }else{
		  $TypeName = "ไม่ระบุ";
		  $fileForEdit = "memberedit_form.php";
	  }

	  $producttype = $product->gettype($db_producttype);

	  $MobileTitle = $db_productbrand . " / " . $db_productmodel . " / " . $producttype;

	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"center\" class=\"txt1 tblist\">".$TypeName."</td><td align=\"left\" class=\"tblist\">".$db_fullname."</td><td align=\"center\" class=\"tblist\">".$MobileTitle."</td><td align=\"center\" class=\"tblist\">".$db_registerdate."</td><td class=\"txt2 tblist\">&nbsp;</td><td class=\"txt1 tblist\"><a href=\"".$fileForEdit."?id=$db_id\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a>&nbsp;&nbsp;<a href=\"memberdel_exec.php?id=$db_id\"  onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
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
<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#button").click(function(){
		document.location.href="memberadd_form.php";
    });
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });
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
            <td class="txttopicpage">แสดงรายการสมาชิก</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top" class="txtsg">ค้นหาชื่อสมาชิก :</td>
                      <td align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="member_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
                    <td width="400" height="37" align="left" valign="top"><input type="text" name="keyword" id="keyword" value="<?php echo $param_keyword;?>" style="width:80%;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" /></td></form>
                    <td align="right" valign="top"><button id="button" class="add">เพิ่มรายการสมาชิก</button></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="10%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ประเภทเครื่อง</strong></td>
                      <td width="28%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ชื่อสมาชิก</strong></td>
                      <td bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>โทรศัพท์ยี่ห้อ / รุ่น / ประเภท</strong></td>
                      <td width="13%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>วันที่ลงทะเบียน</strong></td>
                      <td width="12%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>จำนวนเงินในระบบ</strong></td>
                      <td width="8%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>จัดการข้อมูล</strong></td>
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
