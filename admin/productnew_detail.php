<?php
require '../leone.php';
require './controller/content.php';
require './controller/partner.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_catid = (!empty($_REQUEST["catid"])) ? $_REQUEST["catid"] : "";
$content = new content();
$partner = new partner();


$SqlCheck = "select * from tbl_product where p_id='".$param_id."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_title = stripslashes($RowCheck['p_title']);
		 $db_partner = stripslashes($RowCheck['p_partnerid']);
		 $db_type = stripslashes($RowCheck['p_type']);
		 $db_cate = stripslashes($RowCheck['p_categorie']);
		 $db_detail = stripslashes(nl2br($RowCheck['p_detail']));
		 $db_whatnew = stripslashes(nl2br($RowCheck['p_whatnew']));
		 $db_price = stripslashes($RowCheck['p_price']);
		 $db_clipurl = stripslashes($RowCheck['p_clipurl']);
		 $db_url = stripslashes($RowCheck['p_url']);
		 $db_gallery = stripslashes($RowCheck['p_gallery']);
		 $db_status = stripslashes($RowCheck['p_status']);
		 $db_version = stripslashes($RowCheck['p_version']);
	}
	if ($db_gallery!='') {
	   $PhotoArray = explode ("|",$db_gallery);
	}
}

if (strlen($db_clipurl) > 1) $db_clipurl = "http://www.youtube.com/watch?v=".$db_clipurl;

for ($t=0;$t<count($PhotoArray);$t++) {
  $number++;
  $HiddenField .= "<input type=\"hidden\" name=\"img".$number."_url\" value=\"".$PhotoArray[$t]."\">\n";
  $file_img[$t] = "<img src=\"../photo/gallery/".$PhotoArray[$t]."\" border=\"0\" width=\"140\" />";
  $file_chk[$t] = "checked";
}

$partnername = $partner->getname($db_partner);
$catname = $content->gettitle($db_cate);
if ($db_type=='F') {
	$typename = "ฟรี";
}else{
	$typename = "ซื้อ";
}
if ($db_status=='1') {
	$status1 = "checked";
	$status2 = "";
}else{
	$status1 = "";
	$status2 = "checked";
}
$DateNow = date ("j M Y");
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
		document.location.href="product_view.php?page=1";
    }); 

    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });
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
        <form action="productnew_approve_exec.php" method="post" name="frmApproveProduct" id="frmApproveProduct">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
		<input type="hidden" id="catid" name="catid" value="<?php echo $param_catid;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">จัดการรายการแอป - ดูรายการแอป</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="15%" align="right" valign="middle" class="barG">ชื่อผู้ร่วมค้า :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $partnername;?></td>
                <td width="15%" align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $DateNow;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อแอป :&nbsp;</td>
                <td class="linemenu"><?php echo $db_title;?></td>
                <td align="right" valign="middle" class="barG">ประเภทแอป :&nbsp;</td>
                <td class="linemenu"><?php echo $catname;?></td>
              </tr>
              <tr>
                <td align="right" valign="top" class="barG">รายละเอียด :&nbsp;</td>
                <td class="linemenu" valign="top"><?php echo $db_detail;?></td>
                <td align="right" valign="top" class="barG">อะไรใหม่ :&nbsp;</td>
                <td class="linemenu"><?php echo $db_whatnew;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ประเภท :&nbsp;</td>
                <td class="linemenu"><?php echo $typename;?></td>
                <td align="right" valign="middle" class="barG">ราคา :&nbsp;</td>
                <td class="linemenu"><?php echo $db_price;?> บาท</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">รหัสเวอร์ชั่น :&nbsp;</td>
                <td class="linemenu"><?php echo $db_version;?></td>
                <td align="right" valign="middle" class="barG">URL App :&nbsp;</td>
                <td class="linemenu"><?php echo $db_url;?></td>
              </tr>
              <tr>
			    <td align="right" valign="middle" class="barG">Clip ตัวอย่าง :&nbsp;</td>
                <td class="linemenu"><?php echo $db_clipurl;?></td>
                <td align="right" valign="middle" class="barG">สถานะ :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="status" name="status" value="1" <?php echo $status1;?> />&nbsp;ออกขาย&nbsp;&nbsp;<input type="radio" id="status" name="status" value="0" <?php echo $status2;?> />&nbsp;รอการ Approve</td>
              </tr>
              </table>
			  
			   <table width="100%" border="0" cellspacing="1" cellpadding="1">
					 <tr>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext">ภาพ 1</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext">ภาพ 2</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext">ภาพ 3</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext">ภาพ 4</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext">ภาพ 5</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext">ภาพ 6</td><td width="2%" align="center" valign="middle">&nbsp;</td>
					</tr>
					 <tr>
						<td width="15%" height="120" align="center" valign="middle" bgcolor="#F5F5F5"><?php if($file_img[0]!="") echo $file_img[0];?></td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="120" align="center" valign="middle" bgcolor="#F5F5F5"><?php if($file_img[1]!="") echo $file_img[1];?></td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="120" align="center" valign="middle" bgcolor="#F5F5F5"><?php if($file_img[2]!="") echo $file_img[2];?></td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="120" align="center" valign="middle" bgcolor="#F5F5F5"><?php if($file_img[3]!="") echo $file_img[3];?></td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="120" align="center" valign="middle" bgcolor="#F5F5F5"><?php if($file_img[4]!="") echo $file_img[4];?></td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="120" align="center" valign="middle" bgcolor="#F5F5F5"><?php if($file_img[5]!="") echo $file_img[5];?></td><td width="2%" align="center" valign="middle">&nbsp;</td>
					</tr>
			  </table>
			  
			  
			  
			  
			  </td></tr>
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
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="ตกลง" /></td>
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
