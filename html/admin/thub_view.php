<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/payment.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";

$payment = new payment();

$totalrecords = $payment->getlistcount('desc');
$totalpage = ceil ($totalrecords/$maxrec);
if ($page=='' || $page=='0' || $page=='1') {
   $page = "1";
   $min = "0";
}else{
   $min = ($maxrec * ($page-1));
}
$iNum=$maxrec*($page-1);
$memberdata = $payment->getlist('desc',$min,$maxrec);

if ($totalrecords <= $maxrec) {
   $maxrec = $totalrecords;
}

$DataList = "";
$iColor = "#eeeeee";
for ($p=0;$p<$maxrec;$p++) {
	  $iNum++;
	  $db_id = stripslashes($memberdata[$p]['p_id']);
	  $db_cardpayment = stripslashes($memberdata[$p]['p_cardpayment']);
	  $db_membercode = stripslashes($memberdata[$p]['p_membercode']);

	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td align=\"right\" class=\"txt1 tblist\">".$iNum.".</td><td align=\"center\" class=\"txt1 tblist\">".$db_membercode."</td><td align=\"center\" class=\"tblist\">".$db_cardpayment."</td><td class=\"txt1 tblist\"><a href=\"thubedit_form.php?id=".$db_id."&page=".$page."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a></td></tr>";
}
$pagelist = $Web->paging($totalrecords,$maxrec,$page,'');
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_function.inc.php');?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$("#typeb").change(function() {     
		var src = $(this).val();       
	    document.location.href="thub_view.php?typeb=" + src;
	}); 
});
//-->
</script>
</head>

<body class="bgbd">
<?php
	include ("_header.inc.php");
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18" align="left" valign="top" background="images/obj_06.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
    <td class="warea frameoutside"><table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td width="200" class="sidearea">
        <?php
			include ("_sidebar.inc.php");
		?>        </td>
        <td height="480" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">แสดงรายการ TWZpay Code</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="3%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>#</strong></td>
                      <td width="25%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>รหัสสมาชิก</strong></td>
                      <td height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>TWZpay Code</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>จัดการข้อมูล</strong></td>
                    </tr>
                    <?php echo $DataList;?>
                </table>               
				

				</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr><td><?php echo $pagelist; ?></td></tr>

          <tr>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td class="sidearea"><img src="images/spacer.gif" width="200" height="1" /></td>
        <td align="left" valign="top"><img src="images/spacer.gif" width="772" height="1" /></td>
      </tr>
	<?php
		include ("_footer.inc.php");
	?>
    </table></td>
    <td width="18" align="left" valign="top" background="images/obj_08.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
  </tr>
</table>
</body>
</html>
