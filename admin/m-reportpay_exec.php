<?php
require '../leone.php';
require './controller/payment.php';
require './controller/user.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$payment = new payment();
$user = new user();
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$num = 0;

$period = $param_sdate . " �֧ " . $param_edate;

$SqlCheck = "select * from tbl_member,tbl_payment where (m_email=p_email) and (m_adddate>='".$startdate." 00:00:00' and m_adddate<='".$enddate." 59:59:59') and m_saleid='".$param_code."' and p_type='A' and p_status='1' order by m_adddate";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $dbs_code = $RowCheck['m_code'];
		 $dbs_email = $RowCheck['m_email'];
		 $dbs_rdate = $DT->ShowDate($RowCheck['m_registerdate']);
		 $dbs_fullname = $RowCheck['m_fullname'];
		 $dbs_price = $RowCheck['p_price'];
		 $dbs_station = $RowCheck['p_station'];

		 if ($iColor=='#eeeeee') {
			 $iColor = '#ffffff';
		 }else{
			 $iColor = '#eeeeee';
		 }
		 $totalprice = $totalprice + $dbs_price;
		 $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"left\" class=\"tblist\">".$dbs_fullname."</td><td align=\"center\" class=\"tblist\">".$dbs_price."</td></tr>";
	}
}
unset($RowCheck);

$UserList .= "<tr><td colspan=\"2\" align=\"right\" class=\"tblist\">�ʹ��� : </td><td align=\"center\" class=\"tblist\">".$totalprice."</td></tr>";

$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'');

$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $partnertitle;?></title>
<?php include('_function.inc.php');?>
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {
    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-print' } });
});
//-->
</SCRIPT>
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
            <td class="txttopicpage">�ʴ���ª��ͷ��ӡ����Ѥ���Ҫԡ �� S-Code</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				   <tr><td colspan="4" valign="middle" style="height:30px;"><b>�ѹ��� </b><?php echo $period;?></td></tr>
                    <tr>
                      <td width="5%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>������Ҫԡ</strong></td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>�ӹǹ�Թ</strong></td>
					</tr>
                    <?php echo $UserList;?>
                </table>                
				
				<br/><br/>      
				<form method="post" action="m-reportpay_exec_csv.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />
				<input type="hidden" name="code" value="<?php echo $param_code;?>" />		
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="���͡ CSV" /></td></tr>
				</table> 
				</form>
				
				</td>
              </tr>
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
