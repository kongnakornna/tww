<?php
require '../leone.php';
header('Content-Type: text/html; charset=tis620');
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
require './controller/member.php';
$param_keyword = (!empty($_REQUEST["keyword"])) ? $_REQUEST["keyword"] : "";
$member = new member();
$iColor = "#ffffff";
$list = "";
$no = 0;
$mdata = $member->finddata($param_keyword);
$mdata_count = count($mdata);
if (count($mdata) > 0) {
	$list .= "<table width=\"95%\" cellpadding=\"1\" border=\"0\" cellspacing=\"1\">";
    $list .= "<tr bgcolor=\"#c0c0c0\"><td align=\"right\" width=\"3%\">#</td><td align=\"left\">ชื่อเต็ม</td><td align=\"center\" width=\"25%\">หมายเลข IMEI</td></tr>\n";
	for ($p=0;$p < $mdata_count;$p++) {
		$no++;
		$m_id = $mdata[$p]['m_id'];
		$m_imei = $mdata[$p]['m_imei'];
		$m_email = $mdata[$p]['m_email'];
		$m_fullname = $mdata[$p]['m_fullname'];

		if ($iColor=='#ffffff') {
			$iColor = "#e4e4e4";
		}else{
            $iColor = "#ffffff";
		}

        $list .= "<tr bgcolor='".$iColor."' style=\"cursor:pointer;\"><td align=\"right\" onclick=datarun('".$m_id."');>".$no.".</td><td align=\"left\" onclick=datarun('".$m_id."');>".$m_fullname."</td><td align=\"center\" onclick=datarun('".$m_id."');>".$m_imei."</td></tr>\n";
	}
	$list .= "</table>";

}else{
  if ($param_keyword=='') {
	 $list = "";
  }else{
     $list = "ไม่พบข้อมูลที่ค้นหา";
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874" />
<title><?php echo $webtitle;?></title>
<?php include('_functionfront.inc.php');?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$('.add0').button({ icons: { primary: 'ui-icon-search' } });
	$("#btnBack").click(function(){
		document.location.href="front_menu.php?page=1";
    }); 
	$('.back').button({ icons: { primary: 'ui-icon-home' } });
	$('.add').button({ icons: { primary: 'ui-icon-search' } });
});

function datarun(e) {
   document.location.href="front_onlinememberadd_form.php?id=" + e;
}
//-->
</script>
</head>

<body class="bgbd">
<div style="width:100%;">
<?php
	include ("_header_in.inc.php");
?>

<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="18" align="left" valign="top" background="images/obj_06.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
    <td class="warea frameoutside"><table width="100%" border="0" cellpadding="2" cellspacing="3">
      <tr>
        <td height="580" align="center" valign="top" >
		
		
		 <form action="front_online_form.php" method="post" name="frmsearchuser" id="frmsearchuser">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="txttopicpage">ค้นหาผู้ลงทะเบียน</td>
          </tr>
          <tr>
            <td><img src="images/spacer.gif" width="1" height="3" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td class="linemenu">กรุณากรอก ชื่อ-นามสกุล อีเมล์ หรือ imei :&nbsp;<input type="text" name="keyword" id="keyword" maxlength="75" style="width:300px;" />*&nbsp;&nbsp;<button id="button" class="add">ค้นหา</button></td>
			  </tr>
			  <tr><td height="35" valign="middle"><strong>ผลการค้นหา</strong></td></tr>
			  <tr><td align="left"><?php echo $list;?></td></tr>
			  <tr><td align="left">
			  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="right" colspan="2">&nbsp;</td>
                  </tr>
                  <tr>
				    <td align="left"><button name="btnBack" id="btnBack" type="button" class="back">กลับไป</button></td>
                    <td align="right">&nbsp;</td>
                  </tr>
                </table>
				
				</td></tr>
              </table>		
		 </form>
		</td></tr>
              </table>	
		</td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
	<?php
		include ("_footer.inc.php");
	?>
    </table></td>
    <td width="18" align="left" valign="top" background="images/obj_08.png" style="background-repeat:no-repeat;"><img src="images/spacer.gif" width="18" height="1" /></td>
  </tr>
</table>
</div>
</body>
</html>
