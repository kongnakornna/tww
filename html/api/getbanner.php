<?php
include '../leone.php';
include '../admin/controller/banner.php';
header('Content-Type: application/json; charset=utf-8');
$banner = new banner();
$bannerdata = $banner->getbanner();
$bannerdata_count = count($bannerdata);
if ($bannerdata_count>2) $bannerdata_count = 2;
for ($b=0;$b<$bannerdata_count;$b++) {
	 $bnn_id = $bannerdata[$b]['b_id'];
	 $bnn_title = stripslashes($bannerdata[$b]['b_title']);
	 $bnn_url = stripslashes($bannerdata[$b]['b_url']);
	 $bnn_file = stripslashes($bannerdata[$b]['b_file']);
	 if ($bnn_file=='') {
		$imgbanner = "";
	 }else{
	    $imgbanner = "https://www.easycard.club/photo/".$bnn_file;
	 }

	 $dataarray[$b] = array ("banner_id"=>$bnn_id,"banner_name"=>$String->tis2utf8($bnn_title),"banner_url"=>$bnn_url,"banner_img"=>$imgbanner);

}
$filearray = array("status"=>"OK","status_detail"=>"","bannerlist"=>$dataarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>