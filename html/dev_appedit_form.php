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

$SqlCheck = "select * from tbl_product where p_id='".$param_id."' order by p_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_title = stripslashes($RowCheck['p_title']);
		 $db_code = stripslashes($RowCheck['p_code']);
		 $db_type = stripslashes($RowCheck['p_type']);
		 $db_cate = stripslashes($RowCheck['p_categorie']);
		 $db_detail = stripslashes($RowCheck['p_detail']);
		 $db_apk = stripslashes($RowCheck['p_apk']);
		 $db_whatnew = stripslashes($RowCheck['p_whatnew']);
		 $db_price = stripslashes($RowCheck['p_price']);
		 $db_clipurl = stripslashes($RowCheck['p_clipurl']);
		 $db_url = stripslashes($RowCheck['p_url']);
		 $db_gallery = stripslashes($RowCheck['p_gallery']);
		 $db_version = stripslashes($RowCheck['p_version']);
	}
	if ($db_gallery!='') {
	   $PhotoArray = explode ("|",$db_gallery);
	}

	if ($db_apk=='') {
       $img = "";
	}else{
	   $img = "<a href=\"http://twz.khonjing.com/apk/".$db_apk."\">คลิ๊กเพื่อดาวโหลด</a><br/>";
	}
}

for ($t=0;$t<count($PhotoArray);$t++) {
  $number++;
  $HiddenField .= "<input type=\"hidden\" name=\"img".$number."_url\" value=\"".$PhotoArray[$t]."\">\n";
  $file_img[$t] = "<img src=\"../photo/gallery/".$PhotoArray[$t]."\" border=\"0\" width=\"140\" />";
  $file_chk[$t] = "checked";
}

$catlist = $content->getlistdd($db_cate);
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
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;ปรับปรุงรายการแอป</div>
    
    <div id="topicstyle1">ปรับปรุงรายการแอป (ขั้นตอนที่ 1)</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
	<form method="post" action="dev_appedit_exec.php" enctype="multipart/form-data" name="frmaddnewapp" id="frmaddnewapp">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
		<input type="hidden" id="oldapk" name="oldapk" value="<?php echo $db_apk;?>" />
    รหัสแอป<br />
    <input name="code" id="code" type="text" maxlength="15" value="<?php echo $db_code;?>" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    ชื่อแอป<br />
    <input name="title" id="title" type="text" maxlength="75" value="<?php echo $db_title;?>" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    เวอร์ชั่น<br />
   <input name="vers" id="vers" type="text" maxlength="15" value="<?php echo $db_version;?>" class="contactbox" /><br /><br />
    กลุ่มแอป<br />
    <select name="categorie" id="categorie" class="contactbox"><?php echo $catlist;?></select>&nbsp;<font color="#ff0000">*</font><br /><br />
    รายละเอียด<br />
   <textarea name="detail" id="detail" rows="8" class="contactbox"><?php echo $db_detail;?></textarea>&nbsp;<font color="#ff0000">*</font><br /><br />
    อะไรใหม่<br />
   <textarea name="whatnew" id="whatnew" rows="8" class="contactbox"><?php echo $db_whatnew;?></textarea><br /><br />
    ประเภท<br />
    <input type="radio" id="type" name="type" value="F" checked />&nbsp;ฟรี&nbsp;&nbsp;<input type="radio" id="type" name="type" value="M" />&nbsp;ซื้อ<br /><br />
    ราคา<br />
   <input name="price" id="price" type="text" maxlength="10" value="<?php echo $db_price;?>" class="contactbox" /><br /><br />
   URL แอป *<font color="#ff0000" style="font-size:8px;">(กรณีที่ฝากไว้ที่ Play Store)<br />
   <input name="url" id="url" type="text" maxlength="100" value="<?php echo $db_url;?>" class="contactbox" /><br /><br />
   ไฟล์ Apk<br />
   <?php echo $img;?><input name="image1" id="image1" type="file" class="contactbox" /><br /><br />
   Clip ตัวอย่าง<br />
   <input name="clipurl" id="clipurl" type="text" maxlength="100" value="<?php echo $db_clipurl;?>" class="contactbox" /><br /><br /><br />

    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="ขั้นตอนถัดไป" />
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
