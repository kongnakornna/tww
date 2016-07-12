<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/wallet.php';

if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_sdate = (!empty($_REQUEST["s_sdate"])) ? $_REQUEST["s_sdate"] : "";
$param_edate = (!empty($_REQUEST["s_edate"])) ? $_REQUEST["s_edate"] : "";
$wallet = new wallet();

$depositdata = $wallet->getdeposit_list($param_sdate,$param_edate);
$totalrecords = count($depositdata);
$totalpage = ceil ($totalrecords/$maxrec);
if ($page=='' || $page=='0' || $page=='1') {
   $page = "1";
   $min = "0";
   $max = $maxrec;
}else{
   $min = ($maxrec * ($page-1));
   $max = $maxrec * $page;
}
if ($max > $totalrecords) $max = $totalrecords;

$iNum = 0;
$DataList = "";
$iColor = "#eeeeee";
for ($p=$min;$p<$max;$p++) {
	  $iNum++;
	  $db_logtime= stripslashes($depositdata[$p]['d_logtime']);
	  $db_amount = stripslashes($depositdata[$p]['amount']);
	  $db_remark1 = stripslashes($depositdata[$p]['d_remark1']);
	  $db_remark2= stripslashes($depositdata[$p]['d_remark2']);
	  $db_username = stripslashes($depositdata[$p]['d_username']);	  
	  $db_date = stripslashes($partnerdata[$p]['d_date']);
      $db_partner =  stripslashes($partnerdata[$p]['d_partner']);	  
	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"txt1 tblist\">".$db_logtime."</td><td align=\"left\" class=\"tblist\">".$db_partner."</td><td align=\"left\" class=\"tblist\">".$db_date."</td><td align=\"center\" class=\"tblist\">".$db_amount."</td><td align=\"center\" class=\"tblist\">".$db_username."</td><td align=\"center\" class=\"tblist\">".$db_remark1."</td><td align=\"center\" class=\"tblist\">".$db_remark2."</td><td class=\"txt1 tblist\"><a href=\"depositdel_exec.php?partner=$db_partner&logtime=$db_logtime\" onclick=\"return confirmLink(this, 'ź������?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
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
<SCRIPT LANGUAGE="JavaScript">
<!--
$(document).ready(function() {
    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$('#s_sdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
	$('#s_edate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'dd/mm/yy',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});
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
            <td class="txttopicpage">�ʴ���¡�â����š�� advance �����ҧ����� </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top" class="txtsg">�����ѹ���ѹ�֡ :</td>
                      <td align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="deposit_view.php" method="post" name="frmreport" id="frmreport">
				      <tr>
                      <td align="right" valign="middle" class="barG">�ѹ�������� :&nbsp;</td>
                      <td class="linemenu"><input type="text" name="s_sdate" id="s_sdate" style="width:300px;" readonly=readonly />*</td>
                      <td align="right" valign="middle" class="barG">�ѹ�������ش :&nbsp;</td>
                      <td class="linemenu"><input type="text" name="s_edate" id="s_edate" style="width:300px;" readonly=readonly />*</td>
         	         </tr>
			       <td width="400" height="37" align="left" valign="top">
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="����" /></td></form>
                    <td align="right" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="3%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>#</strong></td>
   
					   $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"txt1 tblist\">".$db_logtime."</td><td align=\"left\" class=\"tblist\">".$db_partner."</td><td align=\"left\" class=\"tblist\">".$db_date."</td><td align=\"center\" class=\"tblist\">".$db_amount."</td><td align=\"center\" class=\"tblist\">".$db_username."</td><td align=\"center\" class=\"tblist\">".$db_remark1."</td><td align=\"center\" class=\"tblist\">".$db_remark2."</td><td class=\"txt1 tblist\"><a href=\"depositdel_exec.php?partner=$db_partner&logtime=$db_logtime\" onclick=\"return confirmLink(this, 'ź������?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";

					  
					  <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>�ӴѺ���</strong></td>
                      <td width="20%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>�ѹ���ҷ��ѹ�֡</strong></td>
                      <td bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>���ͤ����</strong></td>
                      <td width="15%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>�ѹ����͹</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>�ӹǹ�Թ</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>���ͼ��ѹ�֡</strong></td>
		  	          <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>�ѹ�ա������� 1</strong></td>
                      <td width="10%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>�ѹ�ա������� 2</strong></td>
                      <td width="5%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>ź������</strong></td>
                 
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
