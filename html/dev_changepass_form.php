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
        
    <div id="pagenavi"><a href="mainpage.php">˹���á</a> &raquo;&nbsp;����¹���ʼ�ҹ</div>
    
    <div id="topicstyle1">����¹���ʼ�ҹ</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
	    <form method="post" action="dev_changepass_exec.php" name="frmchnpass" id="frmchnpass" onsubmit="return confirm('�س�����ҵ�ͧ�������¹���ʼ�ҹ �ҡ��� �� ��ŧ �ҡ����ͧ���¡��ԡ �� ¡��ԡ');">
    ���ʼ�ҹ���<br />
    <input name="cname" id="cname" type="password" maxlength="15" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    ���ʼ�ҹ����<br />
    <input name="npass1" id="npass1" type="password" maxlength="15" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    ���ʼ�ҹ���� (�ա����)<br />
    <input name="npass2" id="npass2" type="password" maxlength="15" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    
    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="����¹���ʼ�ҹ" />
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
