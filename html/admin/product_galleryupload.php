<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$TotalSize = $FileUploadSize*1000;

$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_imgno = (!empty($_REQUEST["imgno"])) ? $_REQUEST["imgno"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";
$param_fn = (!empty($_REQUEST["fn"])) ? $_REQUEST["fn"] : "";

?>
<html>
<head>
<title>เลือกรูปภาพ</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<style type="text/css">
body {
	background-color: #FFFFFF;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.barG {
	font-family: Tahoma, "MS Sans Serif", sans-serif, Verdana;
    font-size: 13px;
	font-weight: normal;
	color:#ff3300;
}
.linemenu {
	font-family: Tahoma, "MS Sans Serif", sans-serif, Verdana;
    font-size: 12px;
	font-weight: normal;
	color:#000000;
}
</style>

</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
<form name="PostForm" method="post" action="product_galleryupload_exec.php" enctype="multipart/form-data">
<input type="hidden" name="imgno" value="<?php echo $param_imgno;?>">
<input type="hidden" name="code" value="<?php echo $param_code;?>">
<input type="hidden" name="id" value="<?php echo $param_id;?>">
<input type="hidden" name="url" value="<?php echo $param_url;?>">
<input type="hidden" name="fn" value="<?php echo $param_fn;?>">
  <tr>
      <td valign="top" align="center" height="273"> <b><u>เลือกรูปภาพ</u></b><br>
      
        <table width="96%" border="1" cellspacing="3" cellpadding="0">
        <tr>
            <td align="center" height="15" colspan="2"> 
              <input type="file" id="image1" name="image1" />
		  
			  </td>
        </tr>
		  <tr>
			<td align="right" valign="top" class="barG">เงื่อนไข :&nbsp;</td>
			<td class="linemenu">1.กรุณาใช้ภาพที่เป็นนามสกุล png เท่านั้น<br/>
			2.ขนาดไม่เกิน 2 Mb<br/>
			3.กว้างxยาว 175 x 220 pixels
			</td>
		  </tr>


      </table>
       <br/>
        <input type="submit" name="submit" value="Upload Photo">
      </td>
  </tr>
</form>
</table>
</body>
</html>