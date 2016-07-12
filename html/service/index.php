<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $partnertitle;?></title>
<?php include('_function.inc.php');?>
<style type="text/css">
* { margin:0px; padding:0px; }
input, select { vertical-align : middle; }
.txtbox {
	font-family: Tahoma, "MS Sans Serif", sans-serif, Verdana;
	font-size: 12px;
	color: #333;
	border: 1px solid #999;
	height:20px;
	vertical-align:absmiddle;
}
.boxlogin { width:105px; }
#boxlogin {
	font-family: Tahoma, "MS Sans Serif", sans-serif, Verdana;
	font-size: 12px;
	width:358px; 
	text-align:right;
	margin:0px; 
}
</style>
</head>

<body bgcolor="#FFFFFF">
<form action="login.php" method="post" name="frmLogin" id="frmLogin" enctype="multipart/form-data">
<div style="width:358px; height:193px; position:absolute; top:50%; left:50%; margin:-97px 0px 0px -179px; background: #FFF url(images/loginbg.gif) center center no-repeat;">
        <div id="boxlogin">
		<div style="float:left; width:230px; text-align:center;"><img src="images/spacer.gif" width="1" height="70"><br /><br /><img src="./images/logo.png" border="0" width="100" /></div>
		<div style="float:left; width:120px; text-align:left;">
        <img src="images/spacer.gif" width="1" height="55"><br />
        ชื่อผู้ใช้ : 
         <input name="uname" type="text" class="txtbox boxlogin" id="uname" maxlength="15" /><br /><img src="images/spacer.gif" width="1" height="5"><br />
        รหัสผ่าน : 
        <input name="pname" type="password" class="txtbox boxlogin" id="pname" maxlength="15" /><br /><img src="images/spacer.gif" width="1" height="17"><br />
        <div style="floiat:right; text-align:left;">
		<input name="submit" type="image" src="images/bt_login.gif" id="submit" border="0" />&nbsp;&nbsp;&nbsp;&nbsp;</div>
		</div>
        </div>
</div>
</form>
</body>
</html>
