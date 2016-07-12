<?php
require '../leone.php';
if (!isset($_SESSION['islogin'])) $Web->Redirect("index.php");
header('Content-Type: text/html; charset=tis-620');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_imgno = (!empty($_REQUEST["imgno"])) ? $_REQUEST["imgno"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";
$param_fn = (!empty($_REQUEST["fn"])) ? $_REQUEST["fn"] : "";

$SqlMember = "select * from tbl_product where p_id='".$param_id."' limit 0,1";
$ResultMember = $DatabaseClass->DataExecute($SqlMember);
$RowsMember = $DatabaseClass->DBNumRows($ResultMember);
if ($RowsMember>0) {
	for ($t=0;$t<$RowsMember;$t++) {
		 $RowMember = $DatabaseClass->DBfetch_array($ResultMember,$t);
		 $db_gallery = $RowMember['p_gallery'];	
	}
}
$PhotoArray = explode ("|",$db_gallery);
for ($t=0;$t<count($PhotoArray);$t++) {
      if ($PhotoArray[$t]==$param_fn) {
		  if (file_exists($photo_folder . $Ext . "gallery" . $Ext . $PhotoArray[$t])) {
		    unlink($photo_folder . $Ext . "gallery" . $Ext . $PhotoArray[$t]);
		  }
	  }else{
		  if ($GList=='') {
		     $GList .= $PhotoArray[$t];
		  }else{
		     $GList .= "|" . $PhotoArray[$t];
		  }
	  }
}

$SqlGallery = "update tbl_product set p_gallery='".$GList."' where p_id='".$param_id."'";
$ResultGallery = $DatabaseClass->DataExecute($SqlGallery);
$DatabaseClass->DBClose();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    window.opener.location.reload();
	window.opener.location.href = "productedit_form.php?id=<?php echo $param_id;?>";
	window.self.close();
//-->
</SCRIPT>