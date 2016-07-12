<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$param_page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$param_type = (!empty($_REQUEST["type"])) ? $_REQUEST["type"] : "";
$iColor = '#eeeeee';
$UserList = "";

if ($param_type=='') $param_type = "S";

if ($param_keyword=='') {
  $SQLSearch = "";
}else{
  $SQLSearch = " and u_username like '%".$param_keyword."%' or u_fullname like '%".$param_keyword."%' or u_code like '%".$param_keyword."%'";
}
$SqlComCheck = "select * from tbl_username where u_group='".$param_type."' and u_status='1' $SQLSearch order by u_id";
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

$SqlCheck = "select * from tbl_username where u_group='".$param_type."' and u_status='1' $SQLSearch order by u_id desc limit $min,$maxrec";
$ResultCheck = $DatabaseClass->DataExecute($SqlCheck);
$RowsCheck = $DatabaseClass->DBNumRows($ResultCheck);
if ($RowsCheck>0) {
	for ($t=0;$t<$RowsCheck;$t++) {
		 $iNum++;
		 $RowCheck = $DatabaseClass->DBfetch_array($ResultCheck,$t);
		 $db_id = $RowCheck['u_id'];
		 $db_fullname = $RowCheck['u_fullname'];
		 $db_group = $RowCheck['u_group'];
		 $db_email = $RowCheck['u_email'];
		 $db_username = $RowCheck['u_username'];

         if ($iColor=='#eeeeee') {
             $iColor = '#ffffff';
		 }else{
             $iColor = '#eeeeee';
		 }

	     $UserList .= "<tr bgcolor=\"".$iColor."\" style=\"cursor:pointer;\"><td class=\"txt1 tblist\" onclick=\"parseData('".$db_username."');\">".$iNum."</td><td align=\"center\" class=\"tblist\" onclick=\"parseData('".$db_username."');\">".$db_username."</td><td class=\"tblist\" onclick=\"parseData('".$db_username."');\">".$db_fullname."</td><td class=\"txt2 tblist\" onclick=\"parseData('".$db_username."');\">".$db_email."</td></tr>";
	}
}
unset($RowCheck);
$pagelist = $Web->paging($RowsComCheck,$maxrec,$param_page,'type='.$param_type.'&keyword='.$param_keyword);

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
});

function parseData(e) {
   window.opener.document.getElementById ("code").value = e;
   self.close();
}
//-->
</SCRIPT>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">แสดงรายชื่อผู้ใช้งาน ระบบ Back Office</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top" class="txtsg">ค้นหาจากชื่อผู้ใช้งานหรือรหัส :</td>
                      <td align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="usershow.php" method="post" name="frmsearchuser" id="frmsearchuser">
					<input type="hidden" name="type" id="type" value="<?php echo $param_type;?>" />
                    <td width="400" height="37" align="left" valign="top"><input type="text" name="keyword" id="keyword" value="<?php echo $param_keyword;?>" style="width:80%;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" /></td></form>
                    <td align="right" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="3%" height="25" bgcolor="#F5F5F5" class="txt1 tblist tablehead">#</td>
                      <td width="20%" bgcolor="#F5F5F5" class="txt1 tblist tablehead">ชื่อผู้ใช้งาน</td>
                      <td width="30%" bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>ชื่อเต็ม</strong></td>
                      <td bgcolor="#F5F5F5" class="txt1 tblist tablehead"><strong>อีเมล์</strong></td>
                    </tr>
                    <?php echo $UserList;?>
                </table>                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr><td><?php echo $pagelist; ?></td></tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
</body>
</html>
