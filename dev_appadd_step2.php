<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();

if ($param_id=='') {
	$Web->AlertWinGo("ขั้นตอนผิดพลาดกรุณาลองใหม่อีกครั้ง.","dev_applist.php");
	die();
}

$SqlCheck = "select * from tbl_product where p_id='".$param_id."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_title = stripslashes($RowCheck['p_title']);
		 $db_gallery = stripslashes($RowCheck['p_gallery']);
	}
	if ($db_gallery!='') {
	   $PhotoArray = explode ("|",$db_gallery);
	}
}

for ($t=0;$t<count($PhotoArray);$t++) {
  $number++;
  $HiddenField .= "<input type=\"hidden\" name=\"img".$number."_url\" value=\"".$PhotoArray[$t]."\">\n";
  $file_img[$t] = "<img src=\"../photo/gallery/".$PhotoArray[$t]."\" border=\"0\" width=\"140\" />";
  $file_chk[$t] = "checked";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<link href="css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
<!--
$(document).ready(function() {
   $("#btSubmit").click(function(){
		document.location.href="dev_applist.php";
   }); 
});

function UploadImage(element,imgnum,id,code,url,filename) {
   if (element.type == "checkbox") {
	if (element.checked) {
		window.open('dev_galleryupload.php?url='+url+'&id='+id+'&code='+code+'&imgno='+imgnum+'&fn='+filename,'frmupload','left=50,width=600,height=270,toolbar=0,location=no,directories=0,status=0,resizable=0');
	}else{               
		window.open('dev_gallerydelete.php?url='+url+'&id='+id+'&code='+code+'&imgno='+imgnum+'&fn='+filename,'frmupload','left=50,width=280,height=340,toolbar=0,location=no,directories=0,status=0,resizable=0');
	}
   }
}
//-->
</script>
</head>

<body>
<div id="wrapper">
   <?php include('_headerdev.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;เพิ่มรายการสินค้า</div>
    
    <div id="topicstyle1">เพิ่มรายการสินค้า (ขั้นตอนที่ 2)</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
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
		<tr><td align="right" colspan="6"><input name="btSubmit" id="btSubmit" type="button" class="submitbox" value="ตกลง" /></td></tr>
		</table><br/><br/>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
