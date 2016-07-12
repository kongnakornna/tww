<?php
include "leone.php";
if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
include "./admin/controller/app.php";
include "./admin/controller/banner.php";
include "./admin/controller/bank.php";
include "./admin/controller/content.php";
include "./admin/controller/member.php";
include "./admin/controller/partner.php";
include "./admin/controller/payment.php";
include "./admin/controller/province.php";
$app = new app();
$banner = new banner();
$bank = new bank();
$content = new content();
$member = new member();
$partner = new partner();
$payment = new payment();
$province = new province();

$mdata = $member->getdata($_SESSION['TWID']);
for ($g=0;$g<count($mdata);$g++) {
	$m_id = $mdata[0]['m_id'];
    $m_code = $mdata[0]['m_code'];
    $m_fullname = $mdata[0]['m_fullname'];
    $m_email = $mdata[0]['m_email'];
    $m_province = $mdata[0]['m_province'];
    $m_mobile = $mdata[0]['m_mobile'];
    $m_bankid = $mdata[0]['m_bankid'];
    $m_bankcode = $mdata[0]['m_bankcode'];
}
$banklist = $bank->getlistdd($m_bankid);
$provincelist = $province->getgroupdd($m_province);
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
        
    <div id="pagenavi"><a href="mainpage.php">หน้าแรก</a> &raquo;&nbsp;แก้ไขข้อมูลส่วนตัว</div>
    
    <div id="topicstyle1">แก้ไขข้อมูลส่วนตัว</div>
    
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
	    <form method="post" action="member_profile_exec.php" name="frmupdateprofile" id="frmupdateprofile">
		<input type="hidden" id="id" name="id" value="<?php echo $m_id;?>" />

    อีเมล์<br />
    <?php echo $m_email;?><br /><br />
    รหัสสมาชิก<br />
    <?php echo $m_code;?><br /><br />
    ชื่อ-นามสกุล<br />
    <input name="fname" id="fname" type="text" maxlength="100" value="<?php echo $m_fullname;?>" class="contactbox" />&nbsp;<font color="#ff0000">*</font><br /><br />
    จังหวัด<br />
    <select name="province" id="province" class="contactbox"><?php echo $provincelist;?></select>&nbsp;<font color="#ff0000">*</font><br /><br />
    เบอร์โทรศัพท์<br />
    <input name="phone" id="phone" type="text" maxlength="35" value="<?php echo $m_mobile;?>" class="contactbox" /><br /><br />

    ธนาคาร<br />
    <select name="bankid" id="bankid" class="contactbox"><?php echo $banklist;?></select><br /><br />
    เลขที่บัญชีธนาคาร<br />
    <input name="bankcode" id="bankcode" type="text" maxlength="35" value="<?php echo $m_bankcode;?>" class="contactbox" /><br /><br />

    <input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="ปรับปรุงข้อมูล" />
    </form>
    </div>
    </div>
    

    <br clear="all" /><br /><br />
    </div>
    
    <?php include('_footer.inc.php'); ?>
    

</div>

</body>
</html>
