<?php
include "leone.php";
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/province.php";
$app = new app();
$banner = new banner();
$province = new province();

$provincelist = $province->getgroupdd();
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
        
    <div id="pagenavi"><a href="mainpage.php">˹���á</a> &raquo;&nbsp;��Ѥ��繼���������</div>
    
    <div id="topicstyle1">��Ѥ��繼���������</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
	    <form method="post" action="dev_register_exec.php" name="frmregisterdev" id="frmregisterdev">
    ������ҹ���<br />
    <input name="title" id="title" type="text" maxlength="100" class="contactbox" /><br /><br />
    ����-���ʡ��<br />
    <input name="fname" id="fname" type="text" maxlength="100" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    ������<br />
    <input name="email" id="email" type="text" maxlength="85" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    ���ʼ�ҹ<br />
    <input name="pass" id="pass" type="password" maxlength="15" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    �������<br />
    <input name="address1" id="address1" type="text" maxlength="100" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    �ѧ��Ѵ<br />
    <select name="province" id="province" class="contactbox"><?php echo $provincelist;?></select>&nbsp;<font color="#ff0000">*</font><br /><br />
    ������ɳ���<br />
    <input name="postcode" id="postcode" type="text" maxlength="5" class="contactbox" /><br /><br />
    �����Ţ���Ѿ��<br />
    <input name="phone" id="phone" type="text" maxlength="35" class="contactbox" /><br /><br />

	���ʻ�ͧ�ѹ/Secret Code<br /><a name="top"></a>
<img src="captcha.php" id="captcha" border="0" /><br />Please enter the characters in the image above.<br /><a href="#top" onclick="document.getElementById('captcha').src='captcha.php?'+Math.random();document.getElementById('chkcode').focus();" id="change-image">Not readable? Change text.</a><br/><input type="text" name="chkcode" id="chkcode" class="validatebox" style="width: 250px;" autocomplete="off" />&nbsp;<font color="#ff0000">*</font><br/><br/>
    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value=" ��ŧ " />
    </form>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
