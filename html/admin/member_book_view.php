<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis-620');
require './controller/member.php';
require './controller/product.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
$page = (!empty($_REQUEST["page"])) ? $_REQUEST["page"] : "";
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$member = new member();
$product = new product();

if ($param_keyword=='') {
  $SQLSearch = "";
}else{
  $SQLSearch = " (m_email like '%".$param_keyword."%' or m_email like '".$param_keyword."%' or m_fullname like '%".$param_keyword."%' or m_fullname like '".$param_keyword."%')";
}

$iNum = 0;

$memberdata = $member->getlist($SQLSearch,'desc');
$totalrecords = count($memberdata);
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
$iNum=$maxrec*($page-1);

$DataList = "";
$iColor = "#eeeeee";
for ($p=$min;$p<$max;$p++) {
	  $iNum++;
	  $db_id = stripslashes($memberdata[$p]['m_id']);
	  $db_type = stripslashes($memberdata[$p]['m_type']);
	  $db_price = stripslashes($memberdata[$p]['m_price']);
	  $db_fullname = stripslashes($memberdata[$p]['m_fullname']);
	  $db_email = stripslashes($memberdata[$p]['m_email']);	  
	  $db_registerdate = $DT->ShowDate($memberdata[$p]['m_registerdate'],'th');

	  $MobileTitle = "";
	  if ($db_type=='TWZ') {
         $TypeName = "TWZ";
	  }else{
         $TypeName = "Other";
	  }

	  if ($iColor=='#eeeeee') {
		 $iColor = '#ffffff';
	  }else{
		 $iColor = '#eeeeee';
	  }

      $DataList .= "<tr bgcolor=\"".$iColor."\"><td class=\"txt1 tblist\">".$iNum."</td><td align=\"left\" class=\"tblist\">".$db_fullname."</td><td class=\"txt1 tblist\"><a href=\"member_book_show.php?email=".$db_email."\"><img src=\"images/edit.png\" width=\"16\" height=\"16\" border=\"0\" title=\"edit record\" /></a></td></tr>";
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
            <td class="txttopicpage">จัดการการเงิน-รายการเดินบัญชีสมาชิก</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
              <tr>
                <td><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top" class="txtsg">ค้นหาชื่อสมาชิกหรืออีเมล์ :</td>
                      <td align="left" valign="top" class="txtsg">&nbsp;</td>
                  </tr>
                  <tr>
                    <form action="member_book_view.php" method="post" name="frmsearchuser" id="frmsearchuser">
                    <td width="400" height="37" align="left" valign="top"><input type="text" name="keyword" id="keyword" value="<?php echo $param_keyword;?>" style="width:80%;" />
                      <input type="submit" name="btnSubmit" id="btnSubmit" value="ค้นหา" /></td></form>
					  
                    <td align="right" valign="top">&nbsp;</td>
                  </tr></form>
                  <tr>
                    <td colspan="2" align="left" valign="top" bgcolor="#9B9699" ><img src="images/spacer.gif" width="1" height="5" /></td>
                    </tr>
                </table>
                  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1">
                    <tr>
                      <td width="3%" height="25" bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>#</strong></td>
                      <td bgcolor="#99cccc" class="txt1 tblist tablehead"><strong>ชื่อสมาชิก</strong></td>
                      <td width="12%" bgcolor="#99cccc" class="tablehead tblist txt1"><strong>รายการเดินบัญชี</strong></td>
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
