<?php
require_once '../../kongga.php';
header ("Content-Type: text/html; charset=utf-8"); 
$Security->CheckSession($_SESSION['OFPBUsername'],'../index.php');
$paramPage = $_REQUEST['page'];
$MaxPage = 60;
$SqlCount = "select * from tbl_photostock";
$ResultCount = $DatabaseClass->DataExecute($SqlCount);
$RowsCount =$DatabaseClass->DBNumRows($ResultCount);

if ($paramPage=="") $paramPage=1;
if ($paramPage=="1") {
   $min = 0;
}else{
   $min = (($paramPage-1)*$MaxPage);
}
$numPage = ceil ($RowsCount/$MaxPage);

$iNum=1;
$PhotoList = "";
$SqlPhoto = "select * from tbl_photostock order by s_id desc limit $min,$MaxPage";
$ResultPhoto = $DatabaseClass->DataExecute($SqlPhoto);
$RowsPhoto = $DatabaseClass->DBNumRows($ResultPhoto);
if ($RowsPhoto>0) {
	for ($t=0;$t<$RowsPhoto;$t++) {
	    $RowCheck = $DatabaseClass->DBfetch_array($ResultPhoto,$t);
		$dbhID = $RowCheck['s_id'];
		$dbhTitle = $RowCheck['s_title'];
	    if ($iNum==1) {
		  $PhotoList .= "<tr><td align=\"center\" width=\"10%\" bgcolor=\"#FFFFFF\"><img src=\"../../stock/". $dbhTitle ."\" width=\"75\" height=\"75\" border=\"0\" onClick=\"insertImage('".$dbhTitle."');\" style=\"cursor:hand\"></td>";
		  $iNum++;
	    }else if ($iNum==10) {
		  $PhotoList .= "<td align=\"center\" width=\"10%\" bgcolor=\"#FFFFFF\"><img src=\"../../stock/". $dbhTitle."\" width=\"75\" height=\"75\" border=\"0\" onClick=\"insertImage('".$dbhTitle."');\" style=\"cursor:hand\"></td></tr>\n";
		  $iNum=1;
	    }else{
		  $PhotoList .= "<td align=\"center\" width=\"10%\" bgcolor=\"#FFFFFF\"><img src=\"../../stock/". $dbhTitle."\" width=\"75\" height=\"75\" border=\"0\" onClick=\"insertImage('".$dbhTitle."');\" style=\"cursor:hand\"></td>";
		  $iNum++;
	    }

	}
}
if ($iNum==2) {
	$PhotoList .= "<td colspan=\"8\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";
}else if ($iNum==3) {
	$PhotoList .= "<td colspan=\"7\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";
}else if ($iNum==4) {
	$PhotoList .= "<td colspan=\"6\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";
}else if ($iNum==5) {
	$PhotoList .= "<td colspan=\"5\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";			
}else if ($iNum==6) {
	$PhotoList .= "<td colspan=\"4\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";
}else if ($iNum==7) {
	$PhotoList .= "<td colspan=\"3\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";
}else if ($iNum==8) {
	$PhotoList .= "<td colspan=\"2\" bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";		
}else if ($iNum==9) {
	$PhotoList .= "<td bgcolor=\"#FFFFFF\" class=\"normaltxt\">&nbsp;</td></tr>";
}

if ($paramPage>1) {
   $p_page = $paramPage-1;
   $PAGELIST = "<a href=\"?page=$p_page\">Prev</a>&nbsp;page&nbsp;";
}else{
   $p_page = $paramPage;
   $PAGELIST = "<font color=\"#C0C0C0\">Prev</font>&nbsp;page&nbsp;";
}
if ($numPage==0) $numPage = "1";
$PAGELIST .= $paramPage . " to " . $numPage;

if ($paramPage==$numPage || $numPage==1) {
   $n_page = $paramPage;
   $PAGELIST .= "&nbsp;<font color=\"#C0C0C0\">Next</font>";
}else{
   $n_page = $paramPage+1;
   $PAGELIST .= "&nbsp;<a href=\"?page=$n_page\">Next</a>";
}
$PhotoList .= "<tr><td align=\"center\" class=\"normaltxtb\" valign=\"middle\" height=\"25\" colspan=\"10\">$PAGELIST</td></tr>\n";
$DatabaseClass->DBClose();
?>

<script language="JavaScript" type="text/javascript">

var qsParm = new Array();
function retrieveWYSIWYG() {
  var query = window.location.search.substring(1);
  var parms = query.split('&');
  for (var i=0; i<parms.length; i++) {
    var pos = parms[i].indexOf('=');
    if (pos > 0) {
       var key = parms[i].substring(0,pos);
       var val = parms[i].substring(pos+1);
       qsParm[key] = val;
    }
  }
}
function insertImage(e) {
  var image = '<img src="../stock/' + e + '" border="0" class="bdimage">';
  window.opener.insertHTML(image, qsParm['wysiwyg']);
  window.close();
}

</script>
<link href="../../style/style.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0" marginheight="0" marginwidth="0" onLoad="retrieveWYSIWYG();">
<table border="0" cellpadding="0" cellspacing="0" bgcolor="#C0C0C0" width="100%"><tr><td bgcolor="#FFFFFF"><span style="font-family: arial, verdana, helvetica; font-size: 12px; font-weight: bold;">Insert Image:</span></td></tr>
<tr><td valign="top"><table width="100%" cellpadding="1" cellspacing="1" border="0">
<?php echo $PhotoList;?>
</table>
</td></tr>
 <tr><td align="center" bgcolor="#FFFFFF"><input type="submit" value="  Cancel  " onClick="window.close();" style="font-size: 12px;" ></td></tr>

</table>
</body>
</html>
