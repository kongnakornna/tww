<?php
require '../leone.php';
require './controller/imei.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$imei = new imei();
$imeidata = $imei->getdata($param_id);
for ($p=0;$p<count($imeidata);$p++) {
	  $db_id = stripslashes($imeidata[$p]['m_id']);
	  $db_type = stripslashes($imeidata[$p]['m_type']);
	  $db_emei = stripslashes($imeidata[$p]['m_emei']);	  
	  $db_docno = stripslashes($imeidata[$p]['m_docno']);
	  $db_docdate = stripslashes($imeidata[$p]['m_docdate']);
	  $db_barcode = stripslashes($imeidata[$p]['m_barcode']);	  
}
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
	$("#btnBack").click(function(){
		document.location.href="imeidata_view.php?page=1";
    }); 

	$('#docdate').datepicker({ showOtherMonths: true,selectOtherMonths: true,changeMonth: true,changeYear: true,dateFormat: 'yy-mm-dd',showOn: "button",buttonImage: "images/cal.gif",buttonImageOnly: true});

	$('.add0').button({ icons: { primary: 'ui-icon-search' } });

    $('#btnSubmit').each(function(){
	   $(this).replaceWith('<button class="add1" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add1').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$('#btnCancel').each(function(){
	   $(this).replaceWith('<button class="add2" type="' + $(this).attr('type') + '">' + $(this).val() + '</button>');
	});
	$('.add2').button({ icons: { primary: 'ui-icon-circle-close' } });
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
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
        <td height="480" align="left" valign="top">
        <form action="imeidataedit_exec.php" method="post" name="frmAddimeiData" id="frmAddimeiData">
		<input type="hidden" id="id" name="id" value="<?php echo $param_id;?>" />
		<input type="hidden" id="keyword" name="keyword" value="<?php echo $param_keyword;?>" />
		<input type="hidden" id="page" name="page" value="<?php echo $param_page;?>" />
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">�Ѵ�����¡�� Imei - ��Ѻ��ا��¡�� Imei</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td width="15%" align="right" valign="middle" class="barG">������ :&nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="type" id="type" maxlength="15" style="width:300px;" value="<?php echo $db_type;?>" />*</td>
                <td width="15%" align="right" valign="middle" class="barG">�����Ţ Imei :&nbsp;</td>
                <td width="35%" class="linemenu"><input type="text" name="imeicode" id="imeicode" maxlength="75" style="width:300px;" value="<?php echo $db_emei;?>" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">Doc No :&nbsp;</td>
                <td class="linemenu"><input type="text" name="docno" id="docno" maxlength="75" style="width:300px;" value="<?php echo $db_docno;?>" />*</td>
                <td align="right" valign="middle" class="barG">Doc Date :&nbsp;</td>
                <td class="linemenu"><input type="text" name="docdate" id="docdate" style="width:300px;" value="<?php echo $db_docdate;?>" />*</td>
              </tr>
              <tr>
                <td align="right" valign="middle" class="barG">Bar Code :&nbsp;</td>
                <td class="linemenu"><input type="text" name="barcode" id="barcode" maxlength="100" style="width:300px;" value="<?php echo $db_barcode;?>" />*</td>
                <td align="right" valign="middle" class="barG">&nbsp;</td>
                <td class="linemenu">&nbsp;</td>
              </tr>
              </table></td></tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td bgcolor="#9B9B9B"><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td><img src="images/spacer.gif" width="1" height="3" /></td>
              </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">��Ѻ�</button></td>
                    <td align="right"><input type="submit" name="btnSubmit" id="btnSubmit" value="��ŧ" />&nbsp;&nbsp;<input type="reset" name="btnCancel" id="btnCancel" value="��ҧ������" />
					</td>
                  </tr>
                </table>                
				</td>
              </tr>
        </table>
        </form>
        </td>
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
