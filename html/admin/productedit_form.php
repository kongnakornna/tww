<?php
require '../leone.php';
require './controller/content.php';
require './controller/partner.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
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
		 $db_apk = stripslashes($RowCheck['p_apk']);
		 $db_type = stripslashes($RowCheck['p_type']);
  		 $db_showtype = stripslashes($RowCheck['p_showtype']);
		 $db_cate = stripslashes($RowCheck['p_categorie']);
		 $db_detail = stripslashes($RowCheck['p_detail']);
		 $db_whatnew = stripslashes($RowCheck['p_whatnew']);
		 $db_clipurl = stripslashes($RowCheck['p_clipurl']);
		 $db_url = stripslashes($RowCheck['p_url']);
		 $db_gallery = stripslashes($RowCheck['p_gallery']);
		 $db_status = stripslashes($RowCheck['p_status']);
		 $db_version = stripslashes($RowCheck['p_version']);
	}
	if ($db_gallery!='') {
	   $PhotoArray = explode ("|",$db_gallery);
	}

    if ($db_apk=='') {
		$apkfile = "";
	}else{
        $apkfile = "<b>".$db_apk."</b>&nbsp;&nbsp;<a href=\"productapk_del_photo.php?id=".$param_id."\"  onclick=\"return confirmLink(this, 'ลบรูปภาพ ?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete photo\"/></a><br/>";
	}
}

if (strlen($db_clipurl) > 1) $db_clipurl = "http://www.youtube.com/watch?v=".$db_clipurl;

for ($t=0;$t<count($PhotoArray);$t++) {
  $number++;
  $HiddenField .= "<input type=\"hidden\" name=\"img".$number."_url\" value=\"".$PhotoArray[$t]."\">\n";
  $file_img[$t] = "<img src=\"../photo/gallery/".$PhotoArray[$t]."\" border=\"0\" width=\"140\" />";
  $file_chk[$t] = "checked";
}

$partnerlist = $partner->getlistdd($db_partner);
$catlist = $content->getlistdd($db_cate);
if ($db_type=='F') {
	$typeFree = "checked";
	$typePay = "";
}else{
	$typeFree = "";
	$typePay = "checked";
}

if ($db_showtype=='1') {
	$showtype1 = "checked";
	$showtype2 = "";
}else{
	$showtype1 = "";
	$showtype2 = "checked";
}

if ($db_status=='1') {
	$mstatus1 = "checked";
	$mstatus2 = "";
}else{
	$mstatus1 = "";
	$mstatus2 = "checked";
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

	$('#btnCancel').each(function(){
	   $(this).replaceWith('<button class="add2" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add2').button({ icons: { primary: 'ui-icon-circle-close' } });
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
});

function UploadImage(element,imgnum,id,code,url,filename) {
   if (element.type == "checkbox") {
	if (element.checked) {
		window.open('product_galleryupload.php?url='+url+'&id='+id+'&code='+code+'&imgno='+imgnum+'&fn='+filename,'frmupload','left=50,width=600,height=270,toolbar=0,location=no,directories=0,status=0,resizable=0');
	}else{               
		window.open('product_gallerydelete.php?url='+url+'&id='+id+'&code='+code+'&imgno='+imgnum+'&fn='+filename,'frmupload','left=50,width=280,height=340,toolbar=0,location=no,directories=0,status=0,resizable=0');
	}
   }
}
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
        <form action="productedit_exec.php" method="post" enctype="multipart/form-data" name="frmAddProduct" id="frmAddProduct">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">แนะนำร้านที่ใช้ EasyCard ได้ - ปรับปรุงรายการร้านค้า</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
                <tr>
                <td width="15%" align="right" valign="middle" class="barG">ชื่อร้านค้า :&nbsp;</td>
                <td width="35%" class="linemenu"><select name="partnerid" id="partnerid" style="width:300px;"><?php echo $partnerlist;?></select>*</td>
                <td width="15%" align="right" valign="middle" class="barG">วันที่ :&nbsp;</td>
                <td width="35%" class="linemenu"><?php echo $DateNow;?></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ชื่อบริการ :&nbsp;</td>
                <td class="linemenu"><input type="text" name="title" id="title" maxlength="75" value="<?php echo $db_title;?>" style="width:300px;" />*</td>
                <td align="right" valign="middle" class="barG">ประเภทร้านค้า :&nbsp;</td>
                <td class="linemenu"><select name="categorie" id="categorie" style="width:300px;"><?php echo $catlist;?></select>*</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="barG">รายละเอียด :&nbsp;</td>
                <td class="linemenu" valign="top"><textarea name="detail" id="detail" rows="15" style="width:300px;"><?php echo $db_detail;?></textarea>*</td>
                <td align="right" valign="top" class="barG">อะไรใหม่ :&nbsp;</td>
                <td class="linemenu"><textarea name="whatnew" id="whatnew" rows="15" style="width:300px;"><?php echo $db_whatnew;?></textarea></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ประเภทการแสดงผล :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="showtype" name="showtype" value="1" <?php echo $showtype1;?> />&nbsp;Apk&nbsp;&nbsp;<input type="radio" id="showtype" name="showtype" value="2" <?php echo $showtype2;?> />&nbsp;Web Site</td>
                <td align="right" valign="middle" class="barG">URL App :<br/><font color="#ff0000" style="font-size:8px;">(กรณีที่ฝากไว้ที่ Play Store หรือประเภทแสดงผล Web Site)</font>&nbsp;</td>
                <td class="linemenu"><input type="text" name="url" id="url" style="width:300px;" value="<?php echo $db_url;?>" /></td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">ไฟล์ Apk :&nbsp;</td>
                <td class="linemenu"><?php echo $apkfile;?><input type="file" name="image1" id="image1" style="width:300px;" /></td>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu">&nbsp;</td>
              </tr>
              <tr>
			    <td align="right" valign="middle" class="barG">URL Clip ตัวอย่าง (YouTube) :&nbsp;</td>
                <td class="linemenu"><input type="text" name="clipurl" id="clipurl" style="width:300px;" value="<?php echo $db_clipurl;?>" /></td>
                <td align="right" valign="middle" class="barG">สถานะ :&nbsp;</td>
                <td class="linemenu"><input type="radio" id="mstatus" name="mstatus" value="1" <?php echo $mstatus1;?> />&nbsp;Active&nbsp;&nbsp;<input type="radio" id="mstatus" name="mstatus" value="0" <?php echo $mstatus2;?> />&nbsp;Inactive</td>
              </tr>
              </table>
			  
			   <table width="100%" border="0" cellspacing="1" cellpadding="1">
					 <tr>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext"><INPUT TYPE="checkbox" NAME="chk1" VALUE="Y" onClick="UploadImage(this,'1','<?php echo $db_id;?>','<?php echo $dbCode;?>','img1_url','<?php echo $PhotoArray[0];?>');" <?php echo $file_chk[0]?>>&nbsp;ใช้งานภาพ 1</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext"><INPUT TYPE="checkbox" NAME="chk2" VALUE="Y" onClick="UploadImage(this,'2','<?php echo $db_id;?>','<?php echo $dbCode;?>','img2_url','<?php echo $PhotoArray[1];?>');" <?php echo $file_chk[1]?>>&nbsp;ใช้งานภาพ 2</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext"><INPUT TYPE="checkbox" NAME="chk3" VALUE="Y" onClick="UploadImage(this,'3','<?php echo $db_id;?>','<?php echo $dbCode;?>','img3_url','<?php echo $PhotoArray[2];?>');" <?php echo $file_chk[2]?>>&nbsp;ใช้งานภาพ 3</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext"><INPUT TYPE="checkbox" NAME="chk4" VALUE="Y" onClick="UploadImage(this,'4','<?php echo $db_id;?>','<?php echo $dbCode;?>','img4_url','<?php echo $PhotoArray[3];?>');" <?php echo $file_chk[3]?>>&nbsp;ใช้งานภาพ 4</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext"><INPUT TYPE="checkbox" NAME="chk5" VALUE="Y" onClick="UploadImage(this,'5','<?php echo $db_id;?>','<?php echo $dbCode;?>','img5_url','<?php echo $PhotoArray[4];?>');" <?php echo $file_chk[4]?>>&nbsp;ใช้งานภาพ 5</td><td width="2%" align="center" valign="middle">&nbsp;</td>
						<td width="15%" height="20" align="left" valign="middle" bgcolor="#FFFFFF" class="inputtext"><INPUT TYPE="checkbox" NAME="chk6" VALUE="Y" onClick="UploadImage(this,'6','<?php echo $db_id;?>','<?php echo $dbCode;?>','img6_url','<?php echo $PhotoArray[5];?>');" <?php echo $file_chk[5]?>>&nbsp;ใช้งานภาพ 6</td><td width="2%" align="center" valign="middle">&nbsp;</td>
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
