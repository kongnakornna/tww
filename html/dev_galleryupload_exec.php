<?php
include "leone.php";
if (!isset($_SESSION['isdevlogin'])) $Web->Redirect("dev_loginform.php");
header('Content-Type: text/html; charset=tis-620');
$param_code = (!empty($_REQUEST["code"])) ? $_REQUEST["code"] : "";
$param_id = (!empty($_REQUEST["id"])) ? $_REQUEST["id"] : "";
$param_wmark = (!empty($_REQUEST["wmark"])) ? $_REQUEST["wmark"] : "";
$param_imgno = (!empty($_REQUEST["imgno"])) ? $_REQUEST["imgno"] : "";
$param_url = (!empty($_REQUEST["url"])) ? $_REQUEST["url"] : "";
$param_fn = (!empty($_REQUEST["fn"])) ? $_REQUEST["fn"] : "";

$GenCode = $String->GenKey(8);

$Image_name = $_FILES["image1"]['name'];
$temp=explode(".",$Image_name);
$Imgexe=strtolower($temp[sizeof($temp)-1]);
if($Image_name!="") {
   if ($Imgexe=='png') {
		   $uploadpath = $photo_folder . $Ext . "gallery" . $Ext;
           list ($newfilename,$uploadresult) = $GC->uploadPhoto("image1",$GenCode,$uploadpath,'175','png','2048');
   }else{
	   print "<hr><p align='center'>Please upload only png file.</p><hr>\n";
	   die();   
   }
}

$SqlMember = "select * from tbl_product where p_id='".$param_id."' limit 0,1";
$ResultMember = $DatabaseClass->DataExecute($SqlMember);
$RowsMember = $DatabaseClass->DBNumRows($ResultMember);
if ($RowsMember>0) {
	for ($t=0;$t<$RowsMember;$t++) {
		 $RowMember = $DatabaseClass->DBfetch_array($ResultMember,$t);
		 $db_gallery = $RowMember['p_gallery'];	
	}
	if ($db_gallery=='') {
		$FileText = $newfilename;
	}else{
        $FileText = $db_gallery ."|" . $newfilename;
	}
}

$SqlNew = "update tbl_product set p_gallery='".$FileText."' where p_id='".$param_id."'";
$ResultNew = $DatabaseClass->DataExecute($SqlNew);
$DatabaseClass->DBClose();
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    window.opener.location.reload();
	window.opener.location.href = "dev_appadd_step2.php?id=<?php echo $param_id;?>";
	window.self.close();
//-->
</SCRIPT>