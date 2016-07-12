<?php
require '../leone.php';
require './controller/content.php';
require './controller/partner.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$content = new content();
$partner = new partner();
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_catid = (!empty($_REQUEST["catid"])) ? $_REQUEST["catid"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$iColor = '#eeeeee';
$DataList = "";

$catlist = $content->getlistdd($param_catid);

if ($param_catid=='') {
  $SQLSearch = "";
}else{
  $SQLSearch = " and p_categorie='".$param_catid."'";
}

if ($param_keyword=='') {
  $SQLSearch1 = "";
}else{
  $SQLSearch1 = " and p_title like '%".$param_keyword."%'";
}

$SqlComCheck = "select * from tbl_product where 1 $SQLSearch $SQLSearch1 order by p_id";
$ResultComCheck = $DatabaseClass->DataExecute($SqlComCheck);
$RowsComCheck = $DatabaseClass->DBNumRows($ResultComCheck);

if ($param_page=="") $param_page=1;
if ($param_page=="1") {
   $min = 0;
}else{
   $min = (($param_page-1)*$maxrec);
}
$numPage = ceil ($RowsComCheck/$maxrec);
if ($numPage==0) $numPage=1;
$iNum=$maxrec*($param_page-1);

$SqlCheck = "select * from tbl_product where 1 $SQLSearch $SQLSearch1 order by p_id desc limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['p_id'];
		 $db_title = stripslashes($RowCheck['p_title']);
		 $db_partner = stripslashes($RowCheck['p_partnerid']);
		 $db_type = stripslashes($RowCheck['p_type']);
		 $db_recommended = stripslashes($RowCheck['p_recommended']);
		 $db_status = stripslashes($RowCheck['p_status']);
		 $db_cate = stripslashes($RowCheck['p_categorie']);
		 $db_price = stripslashes($RowCheck['p_price']);
		 $contentname = $content->gettitle($db_cate);
		 $partnername = $partner->getname($db_partner);

         if ($db_status=='0' || $db_status=='') {
             $statusName = 'Inactive';
		 }else{
             $statusName = 'Active';
		 }

         if ($db_recommended=='Y') {
             $recomtext = '<a href=\'setrecoms.php?id='.$db_id.'&keyword='.$param_keyword.'&rec=N&page='.$param_page.'&catid='.$param_catid.'\'>���ʹ�</a>';
		 }else{
             $recomtext = '<a href=\'setrecoms.php?id='.$db_id.'&keyword='.$param_keyword.'&rec=Y&page='.$param_page.'&catid='.$param_catid.'\'>����</a>';
		 }

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

	     $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"center\" class=\"tblist\">".$contentname."</td><td align=\"left\" class=\"tblist\">".$db_title."</td><td align=\"center\" class=\"tblist\">".$partnername."</td><td class=\"tblist\" align=\"center\">".$recomtext."</td><td class=\"tblist\" align=\"center\">".$statusName."</td><td class=\"txt1 tblist\"><a href=\"productedit_form.php?id=".$db_id."&catid=".$param_catid."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a>&nbsp;&nbsp;<a href=\"productdel_exec.php?id=".$db_id."&catid=".$param_catid."\"  onclick=\"return confirmLink(this, 'ź������?')\"><img src=\"images/delete.png\" width=\"16\" height=\"16\" border=\"0\" title=\"delete record\"/></a></td></tr>";
	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'catid='.$param_catid.'&keyword='.$param_keyword);

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
	$('.add').button({ icons: { primary: 'ui-icon-circle-plus' } });

	$("#categorie").change(function() {     
		var src = $(this).val();       
	    document.location.href="product_view.php?catid=" + src;
	}); 
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
            <td class="txttopicpage">�й���ҹ��ҷ���� EasyCard ��- �ʴ���¡����ҹ���</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="60%" align="left" valign="top" class="txtsg">���Ҫ�����ҹ��� :</td>
                    <td width="40%" align="left" valign="top" class="txtsg">���͡�����������ҹ��� : </td>
                  </tr>
                  <tr>
                    <form action="product_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
                    <td height="37" align="left" valign="middle"><input type="text" name="keyword" id="keyword" value="<?php echo $param_keyword;?>" style="width: 370px;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="����" /></td></form>
                    <td align="left" valign="middle"><select name="categorie" id="categorie" style="width:400px;"><?php echo $catlist;?></select></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
					<td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>#</strong></td>
					<td width="15%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>��������ҹ���</strong></td>
					<td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>������ҹ���</strong></td>
					<td width="17%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>���ͼ��������� </strong></td>
					<td width="10%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>�������ʹ�</strong></td>
					<td width="10%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>ʶҹ�</strong></td>
					<td width="8%" bgcolor="#F5F5F5" class="tablehead tblist txt1"><strong>�Ѵ���</strong></td>
                    </tr>
                    <?php echo $DataList;?>
                </table>                </td>
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
