<?php
include '../leone.php';
include '../admin/controller/eservice.php';
header('Content-Type: application/json; charset=utf-8');
$eservice = new eservice();

$folderarray = array ("ªÓÃÐ¤èÒ¹éÓ»ÃÐ»Ò ä¿¿éÒ â·ÃÈÑ¾·ìºéÒ¹","àµÔÁà§Ô¹â·ÃÈÑ¾·ìà¤Å×èÍ¹·Õè","ªÓÃÐ¤èÒâ·ÃÈÑ¾·ìà¤Å×èÍ¹·Õè","ªÓÃÐ¤èÒºÃÔ¡ÒÃÍÔ¹àµÍÃìà¹çµ ADSL","ªÓÃÐ¤èÒºÑµÃà¤Ã´Ôµ");
$folderimage = array ("m_public_utilities.png","m_mobile_topup.png","m_mobile_phone.png","m_adsl.png","m_credit.png");
$folderindex = array ("3","1","2","4","5");
for ($num=0;$num<count($folderindex);$num++) {
	$cdata = $eservice->getdataall($folderindex[$num]);

	$iconurl = "https://www.easycard.club/images/icons/" . $folderimage[$num];
    
	for ($b=0;$b<count($cdata);$b++) {
		$tt_id = $cdata[$b]['e_id'];
		$tt_title = stripslashes($cdata[$b]['e_title']);
		$tt_code = stripslashes($cdata[$b]['e_code']);
		$tt_image = stripslashes($cdata[$b]['e_image']);
		$tt_group = stripslashes($cdata[$b]['e_group']);

		$imgurl = "https://www.easycard.club/images/icons/" . $tt_image;

		$dataarray[$b] = array ("eserviceid"=>$tt_id,"eservice_group"=>$tt_group,"eservice_name"=>$String->tis2utf8($tt_title),"eservice_code"=>$tt_code,"eservice_icon"=>$imgurl);
	}
    $catarray[$num] = array ("catid"=>$folderindex[$num],"cattitle"=>$String->tis2utf8($folderarray[$num]),"catimg"=>$String->tis2utf8($iconurl),"eservicelist"=>$dataarray);

	unset ($dataarray);
}

$filearray = array("status"=>"OK","status_detail"=>"","eservicedata"=>$catarray);
$carddata = array ("resultdata"=>$filearray);
$resultxml = json_encode($carddata,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
print $resultxml;
?>

