<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("loginform.php");
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

$totalapp = $app->countappbyid($DVID);
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
   <?php include('_headerdev.inc.php'); ?>
    
    <div id="msgbody">
        
    <div id="pagenavi"><a href="dev_mainpage.php">˹���á</a> &raquo;&nbsp;�Թ�յ�͹�Ѻ</div>
    
    <div id="topicstyle1">�Թ�յ�͹�Ѻ��ҹ��Ҫԡ����������</div>
    
    <div id="contentwide">
    <div style="float:left; width:720px;">
      <table width="100%" border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td width="25%" class="tablelist" align="left"><b>���ͼ���������</b></td>
          <td width="75%" class="tablelist" align="left"><?php echo $_SESSION['DVFullname'];?></td>
		</tr>
        <tr>
          <td class="tablelist" align="left"><b>������ҹ���</b></td>
          <td class="tablelist" align="left"><?php echo $_SESSION['DVTitle'];?></td>
		</tr>
		<tr>
          <td class="tablelist" align="left"><b>���ʼ���������</b></td>
          <td class="tablelist" align="left"><?php echo $_SESSION['DVCode'];?></td>
        </tr>
		<tr>
          <td class="tablelist" align="left"><b>���������������</b></td>
          <td class="tablelist" align="left"><?php echo $_SESSION['DVEmail'];?></td>
        </tr>
		<tr>
          <td class="tablelist" align="left"><b>�����ҹ����ش�����</b></td>
          <td class="tablelist" align="left"><?php echo $DT->ShowDateTime($_SESSION['DVLastlogin'],'th');?></td>
        </tr>
		<tr>
          <td class="tablelist" align="left"><b>�ӹǹ�Թ�����к�</b></td>
          <td class="tablelist" align="left"><?php echo $totalapp;?></td>
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
