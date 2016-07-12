<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
include "./admin/controller/payment.php";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
$payment = new payment();
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";

$totalrecords = $app->countappbyid($DVID);
$totalpage = ceil ($totalrecords/$maxrec);
if ($page=='' || $page=='0' || $page=='1') {
   $page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($page-1));
   $max = $maxrec * $page;
}
if ($max > $totalrecords) $max = $totalrecords;
$appdata = $app->getappbyid($DVID,$min,$maxrec);

if ($totalrecords <= $maxrec) {
   $maxrec = $totalrecords;
}

$DataList = "";
$iColor = "#eeeeee";
for ($p=0;$p<$maxrec;$p++) {
	  $iNum++;
	  $db_id = stripslashes($appdata[$p]['p_id']);
	  $db_type = stripslashes($appdata[$p]['p_type']);
	  $db_title = stripslashes($appdata[$p]['p_title']);
	  $db_code = stripslashes($appdata[$p]['p_code']);
	  $db_price = stripslashes($appdata[$p]['p_price']);
	  $db_status = stripslashes($appdata[$p]['p_status']);
	  $db_comment = stripslashes(nl2br($appdata[$p]['p_admin_comment']));
	  $db_sdate = $DT->ShowDate($appdata[$p]['p_start_date'],'th');

	  if ($db_type=='F') {
         $price = "ฟรี";
	  }else{
         $price = $db_price . " บ.";
	  }

	  if ($db_status=='0') {
         $statustext = "รอการอนุมัติ";
	  }else if ($db_status=='8') {
         $statustext = "มีข้อแก้ไข";
	  }else if ($db_status=='9') {
         $statustext = "ยกเลิกการขาย";
	  }else{
         $statustext = "ออกขาย";
	  }

	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

	  if ($db_status=='9') {
         $iColor = '#ff6666';
         $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tablelist\">".$iNum.".</td><td align=\"center\" class=\"tablelist\">".$db_code."</td><td align=\"left\" class=\"tablelist\">".$db_title."</td><td align=\"center\" class=\"tablelist\">".$db_sdate."</td><td align=\"center\" class=\"tablelist\">".$price."</td><td align=\"center\" class=\"tablelist\">".$statustext."</td><td align=\"right\" class=\"tablelist\"></td><td align=\"center\" class=\"tablelist\"><a href=\"dev_appedit_form.php?id=".$db_id."\"><img src=\"./admin/images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"แก้ไขข้อมูล\" /></a></td></tr>";
	  }else if ($db_status=='8') {
         $iColor = '#ffff99';
         $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tablelist\" title=\"".$db_comment."\">".$iNum.".</td><td align=\"center\" class=\"tablelist\" title=\"".$db_comment."\">".$db_code."</td><td align=\"left\" class=\"tablelist\" title=\"".$db_comment."\">".$db_title."</td><td align=\"center\" class=\"tablelist\" title=\"".$db_comment."\">".$db_sdate."</td><td align=\"center\" class=\"tablelist\" title=\"".$db_comment."\">".$price."</td><td align=\"center\" class=\"tablelist\" title=\"".$db_comment."\">".$statustext."</td><td align=\"right\" class=\"tablelist\"></td><td align=\"center\" class=\"tablelist\"><a href=\"dev_appedit_form.php?id=".$db_id."\"><img src=\"./admin/images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"แก้ไขข้อมูล\" /></a>&nbsp;&nbsp;<a href=\"dev_appdel.php?id=".$db_id."\" onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"./admin/images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ยกเลิกการขาย\"/></a></td></tr>";
	  }else{
         $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"tablelist\">".$iNum.".</td><td align=\"center\" class=\"tablelist\">".$db_code."</td><td align=\"left\" class=\"tablelist\">".$db_title."</td><td align=\"center\" class=\"tablelist\">".$db_sdate."</td><td align=\"center\" class=\"tablelist\">".$price."</td><td align=\"center\" class=\"tablelist\">".$statustext."</td><td align=\"right\" class=\"tablelist\"></td><td align=\"center\" class=\"tablelist\"><a href=\"dev_appedit_form.php?id=".$db_id."\"><img src=\"./admin/images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"แก้ไขข้อมูล\" /></a>&nbsp;&nbsp;<a href=\"dev_appdel.php?id=".$db_id."\" onclick=\"return confirmLink(this, 'ลบข้อมูล?')\"><img src=\"./admin/images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"ยกเลิกการขาย\"/></a></td></tr>";
	  }
}

$pagelist = $Web->paging($totalrecords,$maxrec,$page,'');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=TIS-620" />
<title><?php echo $webtitle;?></title>
<link rel="stylesheet" href="./css/le-frog/jquery-ui-1.10.4.custom.css" type="text/css" media="screen" />
<link href="css/mainstyle.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.4.custom.js" ></script>
<script type="text/javascript">
<!--
$(document).ready(function() {
   $(document).tooltip();
   $("#btnAddApp").click(function(){
		document.location.href="dev_appadd_form.php";
   }); 
});
//-->
</script>
</head>

<body>
<div id="wrapper">
   <?php include('_headerdev.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="dev_mainpage.php">หน้าแรก</a> &raquo;&nbsp;แสดงรายการสินค้า</div>
    
    <div id="topicstyle1">แสดงรายการสินค้า</div>
    
    <div id="contentwide">
    <div style="float:left; width:936px;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
	    <tr><td colspan="8" valign="middle" style="height:40px;" align="right"><input name="btnAddApp" id="btnAddApp" type="button" class="submitbox" value="เพิ่มรายการสินค้า" /></td></tr>
        <tr>
          <td width="3%" class="tabletopic">#</td>
          <td width="10%" class="tabletopic">รหัสสินค้า</td>
          <td class="tabletopic">ชื่อสินค้า</td>
		  <td width="16%" class="tabletopic">วันที่เริ่มขาย</td>
          <td width="10%" class="tabletopic">ราคา</td>
          <td width="10%" class="tabletopic">สถานะ</td>
          <td width="10%" class="tabletopic">ยอดซื้อ</td>
          <td width="12%" class="tabletopic">ปรับปรุง</td>
        </tr>
		<?php echo $DataList;?>
      </table>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    <?php echo $pagelist;?><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
