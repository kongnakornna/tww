<?php
include "leone.php";
if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
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

$totalrecords = $payment->getbuyhistorycount($_SESSION['TWEmail']);
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

$paymentdata = $payment->getbuyhistorydata($_SESSION['TWEmail'],$min,$max);
$DataList = "";
$iColor = "#eeeeee";
for ($p=0;$p<$max;$p++) {
	  $iNum++;
	  $db_id = stripslashes($paymentdata[$p]['p_id']);
	  $db_type = stripslashes($paymentdata[$p]['p_type']);
	  $db_product = stripslashes($paymentdata[$p]['p_productid']);
	  $db_price = stripslashes($paymentdata[$p]['p_price']);
	  $db_partner = stripslashes($paymentdata[$p]['p_partnercode']);	  
	  $db_ref1 = stripslashes($paymentdata[$p]['p_ref1']);	  
	  $db_detail = stripslashes($paymentdata[$p]['p_detail']);
	  $db_date = $DT->ShowDateTime($paymentdata[$p]['p_adddate'],'en');
	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }
      
	  if ($db_type=='B') {
	      $apptitle = $app->gettitle($db_product);
	  }else{
	      $apptitle = $db_ref1;
	  }

      $DataList .= "<tr><td class=\"tablelist\" align=\"right\">".$iNum.".</td><td class=\"tablelist\" align=\"center\">".$db_date."</td><td class=\"tablelist\" align=\"left\">".$apptitle."</td><td class=\"tablelist\" align=\"right\">".$db_price." บ.&nbsp;&nbsp;</td></tr>";
}
$pagelist = $Web->paging($totalrecords,$maxrec,$page,'');
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
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;ประวัติการติดตั้งแอป</div>
    
    <div id="topicstyle1">ประวัติการติดตั้งแอป</div>
    
    <div id="contentwide">
    <div style="float:left; width:216px; margin-right:15px;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="membermenu_topic">เมนูสมาชิก</td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="member_profile_form.php"><li>แก้ไขข้อมูลส่วนตัว</li></a></td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="member_book.php"><li>ดูรายการซื้อสินค้า</li></a></td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="member_check.php"><li>เช็คยอดเงิน EasyCard</li></a></td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="member_payform.php"><li>ดูรหัส EasyCard</li></a></td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="member_payment.php"><li>ดูรหัสเติมเงิน</li></a></td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="changepass_form.php"><li>เปลี่ยนรหัสผ่าน</li></a></td>
      </tr>
      <tr>
        <td class="membermenu_list"><a href="logout.php"><li>ออกจากระบบ</li></a></td>
      </tr>
    </table>
    </div>
    <div style="float:left; width:720px;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="3%" class="tabletopic">#</td>
          <td class="tabletopic">วันและเวลาที่ซื้อ</td>
          <td width="55%" class="tabletopic">ชื่อแอป</td>
          <td width="20%" class="tabletopic">ราคา</td>
        </tr>
		<?php echo $DataList;?>
      </table><br/>
	  <table width="100%" border="0" cellspacing="1" cellpadding="0">
      <tr><td align="center"><?php echo $pagelist;?></td></tr>
	  </table>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
