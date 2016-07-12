<?php
require '../leone.php';
require './controller/app.php';
require './controller/payment.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$app = new app();
$payment = new payment();
$partner = new partner();
$param_partner = (!empty($_REQUEST["partner"])) ? $_REQUEST["partner"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$param_appid = (!empty($_REQUEST["appid"])) ? $_REQUEST["appid"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$startdate = $DT->ConvertDate($param_sdate);
$enddate = $DT->ConvertDate($param_edate);
$iColor = '#eeeeee';
$UserList = "";
$iNum = 0;

$partnercode = $partner->getcode($param_partner);
$partnertitle = $partner->getnamebycode($partnercode);

$period = $param_sdate . " ถึง " . $param_edate;

if ($param_type=='F') {
  $SqlCriteria1 = " and p_total='0'";
}else if ($param_type=='B') {
  $SqlCriteria1 = " and p_total>0";
}else{
  $SqlCriteria1 = " and p_total>0";
}

if ($param_type=='F') {
	if ($param_appid=='') {
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='B' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') $SqlCriteria1 group by p_productid order by p_productid";
	}else{
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where p_productid='".$param_appid."' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_productid order by p_productid";
	}
}else if ($param_type=='B') {
	if ($param_appid=='') {
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='I' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') $SqlCriteria1 group by p_detail order by p_productid";
	}else{
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment,tbl_confirmpin where (p_ref=cp_ref) and cp_respurl_rec='OK' and p_detail='".$param_appid."' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='I' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_detail order by p_productid";
	}
}else{
	if ($param_appid=='') {
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_type='".$param_type."' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') $SqlCriteria1 group by p_productid order by p_productid";
	}else{
	   $SqlCheck = "select p_partnercode,p_productid,p_detail,sum(p_total) as Total from tbl_payment where p_detail='".$param_appid."' and (p_adddate>='".$startdate." 00:00:00' and p_adddate<='".$enddate." 59:59:59') and p_partnercode='".$partnercode."' and p_reinstall NOT IN ('Y') and p_email not in ('jgodsonline@gmail.com','bancomsci@gmail.com','inoomok@gmail.com','havemoney1@twz.com','havemoney2@twz.com','havemoney3@twz.com','nomoney@twz.com') group by p_productid order by p_productid";
	}
}
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_productid'];
		 $db_detail = $RowCheck['p_detail'];
		 $db_code = $RowCheck['p_partnercode'];
		 $db_total = $RowCheck['Total'];

         $share = $partner->getshareapp($db_code,"B");
		 $sharetotal = $db_total * ($share/100);

	     if ($param_type=='B' || $param_type=='F') {
		    $appcode = $app->getcode($db_id);
			$apptitle = $app->gettitle($db_id);
			if ($apptitle=='') $apptitle = $db_detail;
		 }else{
		    $appcode = "-";
			$apptitle = $db_detail;
		 }

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

		 if ($param_appid=='') {
		     $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"left\" class=\"tblist\">".$partnertitle."</td><td align=\"left\" class=\"tblist\">".$apptitle."</td><td align=\"center\" class=\"tblist\">".number_format($db_total,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".$period."</td><td align=\"center\" class=\"tblist\">".number_format($sharetotal,2,'.',',')."</td></tr>";
		 }else{
		    $UserList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$appcode."</td><td align=\"left\" class=\"tblist\">".$apptitle."</td><td align=\"center\" class=\"tblist\">".number_format($db_total,2,'.',',')."</td><td align=\"center\" class=\"tblist\">".number_format($sharetotal,2,'.',',')."</td></tr>";
		 }
	}
}

unset($RowCheck);
$DatabaseClass->DBClose();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
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
            <td class="txttopicpage">จัดการรายงาน-ยอดขายแต่ละร้านค้า</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td>
<?php
if ($param_appid=='') {
?>
				 <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="5%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อร้านค้า</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อผู้ร่วมค้า</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดขายสินค้าทุกรายการ</strong></td>
                      <td width="22%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>วันที่</strong></td>
                      <td width="8%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ส่วนแบ่ง</strong></td>
                    </tr>
                    <?php echo $UserList;?>
                </table>  

<?php
}else{
?>

                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				    <tr><td colspan="4" valign="middle"><b>ชื่อร้านค้า : </b><?php echo $partnertitle;?></td></tr>
					<tr><td colspan="4" valign="middle"><b>วันที่ : </b><?php echo $period;?></td></tr>
                    <tr>
                      <td width="5%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>รหัสสินค้า</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อสินค้า</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ยอดขาย</strong></td>
                      <td width="15%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ส่วนแบ่ง</strong></td>
                    </tr>
                    <?php echo $UserList;?>
                </table>  
				
<?php
}
?>		

				
				
				
				<br/><br/>      
				<form method="post" action="report_dev_exec_csv.php" name="frmToCsv" id="frmToCsv" target="csv">
				<input type="hidden" name="partner" value="<?php echo $param_partner;?>" />	
				<input type="hidden" name="appid" value="<?php echo $param_appid;?>" />	
				<input type="hidden" name="type" value="<?php echo $param_type;?>" />	
				<input type="hidden" name="ptype" value="<?php echo $param_ptype;?>" />	
				<input type="hidden" name="s_sdate" value="<?php echo $param_sdate;?>" />	
				<input type="hidden" name="s_edate" value="<?php echo $param_edate;?>" />	
				<table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
				<tr><td align="left"><input type="submit" name="btnSubmit" id="btnSubmit" value="นำออก CSV" /></td></tr>
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
