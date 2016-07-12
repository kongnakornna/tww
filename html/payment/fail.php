<?php
require '../leone.php';
require '../admin/controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
$param_cmd = (!empty($_REQUEST["cmd"])) ? $_REQUEST["cmd"] : "";
$param_r = (!empty($_REQUEST["r"])) ? $_REQUEST["r"] : "";

$partner = new partner();

$SqlCheck = "select * from tbl_confirmpin where cp_ref='".$param_r."' order by cp_id";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['cp_id'];
		 $db_partner = stripslashes($RowCheck['cp_partnerid']);
		 $db_title = stripslashes($RowCheck['cp_appcode']);
		 $db_ref1 = stripslashes($RowCheck['cp_ref1']);
  		 $db_price = stripslashes($RowCheck['cp_price']);
		 $db_charge = stripslashes($RowCheck['cp_charge']);
		 $db_total = stripslashes($RowCheck['cp_total']);
		 $partnername = $partner->getnamebycode($db_partner);
	}
}


if ($param_cmd=='1') {
   $msg = "ชื่อบัญชีนี้ไม่มีในระบบ Easy Card";
}else if ($param_cmd=='2') {
   $msg = "รหัสยืนยันการชำระเงินไม่ถูกต้อง กรุณาใช้รหัสที่ถูกต้อง";
}else if ($param_cmd=='3') {
   $msg = "จำนวนเงินในบัญชีของท่านไม่พอชำระค่าสินค้า หรือค่าบริการนี้ กรุณาเติมเงินเข้าบัญชีเพิ่ม ขอบคุณค่ะ";
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EasyCard Confirm PIN Code</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="./js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

    <input type="hidden" name="r" id="r" value="<?php echo $param_r;?>" />
        <h2 class="form-signin-heading"><center><img src="logo.png" border="0" width="200" /></center></h2>
         <br/>
        <label for="inputEmail"><?php echo $msg;?></label>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
