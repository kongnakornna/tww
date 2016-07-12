<?php
require '../leone.php';
require './controller/product.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$product = new product();
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_brand = (!empty($_REQUEST["brand"])) ? $_REQUEST["brand"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$iColor = '#eeeeee';
$UserList = "";

if ($param_keyword=='') {
  $SQLSearch = "";
}else{
  $SQLSearch = " and m_title like '%".$param_keyword."%'";
}

if ($param_brand=='') {
  $SQLSearch .= " and m_phone_id=''";
}else{
  $SQLSearch .= " and m_phone_id='".trim($param_brand)."'";
}

$SqlComCheck = "select * from tbl_phone_model where 1 $SQLSearch order by m_id";
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

$SqlCheck = "select * from tbl_phone_model where 1 $SQLSearch order by m_id desc limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['m_id'];
		 $db_title = stripslashes($RowCheck['m_title']);
		 $db_brand = stripslashes($RowCheck['m_phone_id']);

         $brandName = $product->getbrandname($db_brand);

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

	     $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$brandName."</td><td align=\"left\" class=\"tblist\">".$db_title."</td><td class=\"txt1 tblist\"><a href=\"phonemodeledit_form.php?id=".$db_id."&brand=".$param_brand."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a>&nbsp;&nbsp;<a href=\"phonemodeldel_exec.php?id=".$db_id."&brand=".$param_brand."\"  onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'keyword='.$param_keyword);

$brandlist = $product->getbrandlist($param_brand);

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
	$("#brand").change(function() {     
		var src = $(this).val();       
	    document.location.href="phonemodel_view.php?brand=" + src;
	}); 

	$("#buttonadd").click(function(){
		document.location.href="phonemodeladd_form.php?brand=<?php echo $param_brand;?>";
    });
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
            <td class="txttopicpage">แสดงรายการยี่ห้อมือถือ</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
				
				<form action="phonemodel_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
				<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>                    
                    <td width="12%" height="37" align="left" valign="middle">ค้นหาจากชื่อยี่ห้อ :</td><td width="45%" height="37" align="left" valign="middle"><select name="brand" id="brand" style="width:300px;"><?php echo $brandlist;?></select></td>
                    <td align="right" valign="middle"><button id="button" class="add">ค้นหา</button></td>
                  </tr>
					
                  <tr>                    
                    <td  width="12%" height="37" align="left" valign="middle">ค้นหาจากชื่อรุ่นมือถือ :</td><td height="37" align="left" valign="middle"><input type="text" name="keyword" id="keyword" maxlength="25" style="width:300px;" value="<?php echo $param_keyword;?>" /></td></form><td align="right" valign="middle">&nbsp;</td>
                  </tr>
                  <tr> 
                    <td colspan="3" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>				

                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="25%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อยี่ห้อมือถือ</strong></td>
                      <td bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>ชื่อรุ่นมือถือ</strong></td>
                      <td width="12%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>จัดการ</strong></td>
                    </tr>
                    <?php echo $UserList;?>
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
