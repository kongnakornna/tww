<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/product.php";
$app = new app();
$banner = new banner();
$content = new content();
$product = new product();

$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;

$period = $param_sdate . " ถึง " . $param_edate;

$SqlCheck = "select p_productid,p_detail,count(*) as Total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$_SESSION['DVCode']."' and p_type='I' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_detail order by p_detail";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_code = $RowCheck['p_productid'];
		 $db_detail = $RowCheck['p_detail'];
		 $db_total = $RowCheck['Total'];

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }
		 $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"left\" class=\"tblist\">".$db_detail."</td><td align=\"center\" class=\"tblist\">".$db_total."</td></tr>";
	}
}

unset($RowCheck);
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
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;รายงานยอดขาย</div>
    
    <div id="topicstyle1">รายงานยอดขาย</div>
    
    <div id="contentwide">
    <div style="float:left; width:860px;">


	<table width="100%" border="0" cellspacing="2" cellpadding="2">
   <tr><td colspan="4" valign="middle" style="height:30px;" class="txt1"><b>วันที่ </b><?php echo $period;?></td></tr>
	<tr>
	  <td width="5%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
	  <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อสินค้า</strong></td>
	  <td width="20%" bgcolor="#F5F5F5" align="center" class="tblist tablehead"><strong>จำนวนยอดขาย</strong></td>
	</tr>
	<?php echo $UserList;?>
	</table>
    
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
