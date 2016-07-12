<?php
require '../leone.php';
require '../admin/controller/partner.php';
header('Content-Type: text/html; charset=utf-8');
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
		 $db_title = stripslashes($String->tis2utf8($RowCheck['cp_appcode']));
		 $db_ref1 = stripslashes($RowCheck['cp_ref1']);
  		 $db_price = stripslashes($RowCheck['cp_price']);
		 $db_charge = stripslashes($RowCheck['cp_charge']);
		 $db_total = stripslashes($RowCheck['cp_total']);
		 $partnername = $partner->getnamebycode($db_partner);
	}
}
$price_show = number_format($db_price,2,'.',',');
$charge_show = number_format($db_charge,2,'.',',');
$total_show = number_format($db_total,2,'.',',');
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

      <form class="form-signin" method="post" name="frmEnterPin" action="https://www.easycard.club/payment/confirmpayment_exec.php">
	    <input type="hidden" name="r" id="r" value="<?php echo $param_r;?>" />
        <h2 class="form-signin-heading"><center><img src="logo.png" border="0" width="200" /></center></h2>
         <br/>
        <label for="inputEmail">Shop Title : <?php echo $partnername;?></label>
        <br/>
        <label for="inputEmail">Product Code : <?php echo $db_ref1;?></label>
        <br/>
        <label for="inputEmail">Product Title : <?php echo $db_title;?></label>
        <br/>
        <label for="inputEmail">Price : <?php echo $price_show;?> Baht</label>
		<br/>
        <label for="inputEmail">Service Charge 2.5% : <?php echo $charge_show;?> Baht</label>
		<br/>   
        <label for="inputEmail">Total : <?php echo $total_show;?> Baht</label>
		<br/>   		
        <button class="btn btn-success btn-block" type="submit"><?php echo $String->tis2utf8("�׹�ѹ��ê���");?></button>
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>