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
$msgdata = $content->getmessage('03');
$msgtitle = stripslashes($msgdata[0]['m_title']);
$msgdetail = stripslashes($msgdata[0]['m_message']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<link href="css/mainstyle.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="wrapper">
   <?php include('_header.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;<?php echo $msgtitle;?></div>
    
    <div id="topicstyle1"><?php echo $msgtitle;?></div>
    
    <div id="contentwide"><?php echo $msgdetail;?></div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
