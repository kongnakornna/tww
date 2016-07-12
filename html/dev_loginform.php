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
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#btRegisterDev').click(function(){		
		window.document.location.href = "dev_register_form.php";
	});
});
//-->
</script>
</head>

<body>
<div id="wrapper">
   <?php include('_header.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;เข้าสู่ระบบผู้ร่วมค้า</div>
    
    <div id="topicstyle1">เข้าสู่ระบบผู้ร่วมค้า</div>
    
    <div id="contentwide">
	    <form method="post" action="dev_loginform_exec.php" name="frmLogin" id="frmLogin">
    อีเมล์ผู้ร่วมค้า<br />
    <input name="uname" id="uname" type="text" maxlength="35" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    
    รหัสผ่านผู้ร่วมค้า<br />
    <input name="pname" id="pname" type="password" maxlength="35" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    
    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="เข้าสู่ระบบ" />&nbsp;&nbsp;<input name="btRegisterDev" id="btRegisterDev" type="button" class="submitbox" value="สมัครเป็นผู้ร่วมค้า" />
    </form>
	
	</div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
