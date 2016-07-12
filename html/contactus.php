<?php
include "leone.php";
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<link href="css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/global.js"></script>
</head>

<body>
<div id="wrapper">
   <?php include('_header.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;ติดต่อเรา</div>
    
    <div id="topicstyle1">ติดต่อเรา</div>
    
    <div id="contentwide">
	    <form method="post" action="contactus_exec.php" name="frmContact" id="frmContact">
    ชื่อ - นามสกุล ผู้ติดต่อ<br />
    <input name="contactname" id="contactname" type="text" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    
    อีเมล์ ผู้ติดต่อ<br />
    <input name="contactemail" id="contactemail" type="text" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />

    เบอร์โทร ผู้ติดต่อ<br />
    <input name="contactphone" id="contactphone" type="text" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />

    เรื่องที่ต้องการติดต่อ<br />
    <input name="contacttopic" id="contacttopic" type="text" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    
    รายละเอียด<br />
    <textarea name="contactdetail" id="contactdetail" cols="5" rows="7" class="contactbox"></textarea>&nbsp;<font color="#ff0000">*</font><br /><br />
	
	รหัสป้องกัน/Secret Code<br /><a name="top"></a>
<img src="captcha.php" id="captcha" border="0" /><br />Please enter the characters in the image above.<br /><a href="#top" onclick="document.getElementById('captcha').src='captcha.php?'+Math.random();document.getElementById('chkcode').focus();" id="change-image">Not readable? Change text.</a><br/><input type="text" name="chkcode" id="chkcode" class="validatebox" style="width: 250px;" autocomplete="off" />&nbsp;<font color="#ff0000">*</font>

	
	
	<br /><br />
    
    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="ส่งข้อความ" />
    </form>
	
	</div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
