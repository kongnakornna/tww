<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$DateNow = date ("j M Y");
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";

$SqlData = "select * from tbl_subcategorie where s_id='".$param_id."' order by s_id";
$ResultData = $DatabaseClass->DataExecute($SqlData);
$RowsData = $DatabaseClass->DBNumRows($ResultData);
if ($RowsData>0) {
	for ($e=0;$e<$RowsData;$e++) {
		 $RowData = $DatabaseClass->DBfetch_array($ResultData,$e);
		 $dbs_id = $RowData['s_id'];
		 $dbs_title = stripslashes($RowData['s_title']);
		 $dbs_catid = stripslashes($RowData['s_catid']);
	}
}

$catlist = "<option value=\"\"></option>\n";
$SqlCheck = "select * from tbl_categorie order by c_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['c_id'];
		 $db_title = stripslashes($RowCheck['c_title']);
         if ($db_id==$dbs_catid) {
			 $catlist .= "<option value=\"".$db_id."\">".$db_title."</option>\n";
		 }else{
			 $catlist .= "<option value=\"".$db_id."\">".$db_title."</option>\n";
		 }
	}
}
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
	$("#btnBack").click(function(){
		document.location.href="subcategorie_view.php?page=1";
    }); 

    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$('#btnCancel').each(function(){
	   $(this).replaceWith('<button class="add2" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add2').button({ icons: { primary: 'ui-icon-circle-close' } });
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
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
        <td height="480" align="left" valign="top">
        <form action="subcategorieedit_exec.php" method="post" enctype="multipart/form-data" name="frmAddCategorie" id="frmAddCategorie">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">แนะนำร้านค้า - ปรับปรุงรายการประเภทบริการรอง</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">ประเภทบริการหลัก :&nbsp;</td>
                <td width="30%" class="linemenu"><select name="maincat" id="maincat" style="width:250px;"><?php echo $catlist;?></select></td>
                <td width="20%" align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td width="30%" class="linemenu"><?php echo $DateNow;?></td>
              </tr>
                <tr>
                <td width="20%" align="right" valign="middle" class="barG">ชื่อประเภทบริการ :&nbsp;</td>
                <td width="30%" class="linemenu"><input type="text" name="title" id="title" maxlength="75" <?php echo $dbs_title;?> style="width:250px;" />*</td>
                <td width="20%" align="right" valign="middle" class="barG">&nbsp;</td>
                <td width="30%" class="linemenu">&nbsp;</td>
              </tr>
              </table></td></tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td bgcolor="#9B9B9B"><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">กลับไป</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="ตกลง" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="ล้างข้อมูล" />
					</td>
                  </tr>
                </table>                
				</td>
              </tr>
        </table>
        </form>
        </td>
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
