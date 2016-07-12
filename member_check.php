<?php
include "leone.php";
if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/content.php";
include "./admin/controller/partner.php";
include "./admin/controller/member.php";
$app = new app();
$banner = new banner();
$content = new content();
$partner = new partner();
$member = new member();

$memberprice = $member->getprice($_SESSION['TWEmail']);
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
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;เช็คยอดเงิน EasyCard</div>
    
    <div id="topicstyle1">เช็คยอดเงิน EasyCard</div>
    
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
          <td width="20%" class="tabletopic">ยอดเงินคงเหลือ</td>
          <td width="80%" class="tablelist">&nbsp;&nbsp;<?php echo $memberprice;?> บ.</td>
        </tr>
      </table>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
