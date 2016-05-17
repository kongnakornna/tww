<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
$catlist = $content->getlistdd();
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
</head>

<body>
<div id="wrapper">
   <?php include('_headerdev.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;เพิ่มรายการสินค้า</div>
    
    <div id="topicstyle1">เพิ่มรายการสินค้า (ขั้นตอนที่ 1)</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
	<form method="post" action="dev_appadd_exec.php" enctype="multipart/form-data" name="frmaddnewapp" id="frmaddnewapp">
    รหัสสินค้า<br />
    <input name="code" id="code" type="text" maxlength="15" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    ชื่อสินค้า<br />
    <input name="title" id="title" type="text" maxlength="75" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    เวอร์ชั่น<br />
   <input name="vers" id="vers" type="text" maxlength="15" class="contactbox" /><br /><br />
    กลุ่มสินค้า<br />
    <select name="categorie" id="categorie" class="contactbox"><?php echo $catlist;?></select>&nbsp;<font color="#ff0000">*</font><br /><br />
    รายละเอียด<br />
   <textarea name="detail" id="detail" rows="8" class="contactbox"></textarea>&nbsp;<font color="#ff0000">*</font><br /><br />
    อะไรใหม่<br />
   <textarea name="whatnew" id="whatnew" rows="8" class="contactbox"></textarea><br /><br />
    URL แอป *<font color="#ff0000" style="font-size:8px;">(กรณีที่ฝากไว้ที่ Play Store)<br />
   <input name="url" id="url" type="text" maxlength="100" class="contactbox" /><br /><br />
   ไฟล์ Apk<br />
   <input name="image1" id="image1" type="file" class="contactbox" /><br /><br />
   Clip ตัวอย่าง<br />
   <input name="clipurl" id="clipurl" type="text" maxlength="100" class="contactbox" /><br /><br />


    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="ขั้นตอนถัดไป" />
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
