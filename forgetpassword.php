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
        
    <div id="pagenavi"><a href="mainpage.php">˹���á</a> &raquo;&nbsp;������ʼ�ҹ</div>
    
    <div id="topicstyle1">������ʼ�ҹ</div>
    
    <div id="contentwide">
	    <form method="post" action="forgetpassword_exec.php" name="frmforgetpass" id="frmforgetpass">
    ��س������������ŧ����¹<br />
    <input name="email" id="email" type="text" maxlength="75" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    	���ʻ�ͧ�ѹ/Secret Code<br /><a name="top"></a>
<img src="captcha.php" id="captcha" border="0" /><br />Please enter the characters in the image above.<br /><a href="#top" onclick="document.getElementById('captcha').src='captcha.php?'+Math.random();document.getElementById('chkcode').focus();" id="change-image">Not readable? Change text.</a><br/><input type="text" name="chkcode" id="chkcode" class="validatebox" style="width: 250px;" autocomplete="off" />&nbsp;<font color="#ff0000">*</font>
    
    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="������ʼ�ҹ" />
    </form>
	
	</div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
