<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("loginform.php");
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
<link rel="stylesheet" href="css/south-street/jquery-ui-1.10.4.custom.css" type="text/css" media="screen" />
<link href="css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="js/jquery.rsv.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('#s_sdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
	$('#s_edate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
});
//-->
</script>
</head>

<body>
<div id="wrapper">
   <?php include('_headerdev.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;รายงานยอดขาย</div>
    
    <div id="topicstyle1">รายงานยอดขาย</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
	    <form method="post" action="dev_report_exec.php" name="frmreportdev" id="frmreportdev">
    วันที่เริ่ม<br />
    <input type="text" name="s_sdate" id="s_sdate" style="width:300px;" readonly=readonly />&nbsp;<font color="#ff0000">*</font><br /><br />
    วันที่สิ้นสุด<br />
    <input type="text" name="s_edate" id="s_edate" style="width:300px;" readonly=readonly />&nbsp;<font color="#ff0000">*</font><br /><br />

    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value=" ตกลง " />
    </form>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
