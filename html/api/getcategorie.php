<?php
include '../leone.php';
include '../admin/controller/content.php';
header('Content-Type: application/json; charset=utf-8');
$content = new content();
$cdata = $content->getdata();
for ($b=0;$b<count($cdata);$b++) {
	$tt_id = $cdata[$b]['c_id'];
	$tt_title = stripslashes($cdata[$b]['c_title']);
	$tt_banner = stripslashes($cdata[$b]['c_bannerapp']);

    if ($tt_banner=='') {
		$banner = "";
	}else{
	    $banner = "https://www.easycard.club/photo/".$tt_banner;
	}
    $dataarray[$b] = array ("categorie_id"=>$tt_id,"categorie_name"=>$String->tis2utf8($tt_title),"categorie_banner"=>$banner);
}

$filearray = array("status"=>"OK","status_detail"=>"","categorielist"=>$dataarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>