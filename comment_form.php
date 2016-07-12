<?php
require './leone.php';
//if (!isset($_SESSION['ismemberlogin'])) $Web->Redirect("loginform.php");
header('Content-Type: text/html; charset=tis-620');
$param_appid = (!empty($_REQUEST["appid"])) ? $_REQUEST["appid"] : "";
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
<form method="post" action="comment_exec.php" name="frmcomment" id="frmcomment">
<input type="hidden" id="appid" name="appid" value="<?php echo $param_appid;?>" />
<table width="98%" cellpadding="1" cellspacing="1" border="0">
    <tr><td colspan="2" id="topicstyle1">แสดงความคิดเห็น</td><tr>
	<tr>
		<td>คะแนน :</td>
		<td><input type="radio" name="rate" value="1" />&nbsp;1&nbsp;&nbsp;<input type="radio" name="rate" value="2" />&nbsp;2&nbsp;&nbsp;<input type="radio" name="rate" value="3" />&nbsp;3&nbsp;&nbsp;<input type="radio" name="rate" value="4" />&nbsp;4&nbsp;&nbsp;<input type="radio" name="rate" value="5" />&nbsp;5</td>
	</tr>
	<tr>
		<td valign="top" width="20%">ความคิดเห็น :</td>
		<td width="80%"><textarea id="message" name="message" rows="8" class="contactbox"></textarea></td>
	</tr>
	<tr>
		<td>จากคุณ :</td>
		<td><input name="from" id="from" type="text" maxlength="35" class="contactbox" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input name="btSubmit" id="btSubmit" type="submit" class="submitbox" value="แสดงความคิดเห็น" /></td>
	</tr>
</table></form>

</body>
</html>
